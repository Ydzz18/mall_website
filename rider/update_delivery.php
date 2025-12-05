<?php
require_once '../config.php';

if (!isset($_SESSION['rider_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}

$assignment_id = $_POST['assignment_id'] ?? 0;
$delivery_status = $_POST['delivery_status'] ?? '';
$failure_reason = $_POST['failure_reason'] ?? '';
$notes = $_POST['notes'] ?? '';
$rider_id = $_SESSION['rider_id'];

if (empty($assignment_id) || empty($delivery_status)) {
    $_SESSION['error_message'] = 'Invalid delivery status update';
    header('Location: dashboard.php');
    exit;
}

$valid_statuses = ['assigned', 'picked_up', 'in_transit', 'delivered', 'failed', 'returned'];
if (!in_array($delivery_status, $valid_statuses)) {
    $_SESSION['error_message'] = 'Invalid delivery status';
    header('Location: dashboard.php');
    exit;
}

if (($delivery_status === 'failed' || $delivery_status === 'returned') && empty($failure_reason)) {
    $_SESSION['error_message'] = 'Failure reason is required for failed/returned deliveries';
    header('Location: dashboard.php');
    exit;
}

$conn = getDBConnection();

if (!$conn) {
    $_SESSION['error_message'] = 'Database connection failed';
    header('Location: dashboard.php');
    exit;
}

$check_stmt = $conn->prepare("
    SELECT assignment_id, delivery_status 
    FROM delivery_assignments 
    WHERE assignment_id = ? AND rider_id = ?
");
$check_stmt->bind_param("ii", $assignment_id, $rider_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows !== 1) {
    $_SESSION['error_message'] = 'Delivery assignment not found or unauthorized';
    header('Location: dashboard.php');
    exit;
}

$assignment = $result->fetch_assoc();
$old_status = $assignment['delivery_status'];

$timestamp_updates = '';
if ($delivery_status === 'picked_up' && $old_status !== 'picked_up') {
    $timestamp_updates .= ", picked_up_at = NOW()";
} elseif ($delivery_status === 'delivered' && $old_status !== 'delivered') {
    $timestamp_updates .= ", delivered_at = NOW()";
}

$update_stmt = $conn->prepare("
    UPDATE delivery_assignments 
    SET delivery_status = ?, 
        failure_reason = ?, 
        notes = ?,
        updated_at = NOW()
        $timestamp_updates
    WHERE assignment_id = ? AND rider_id = ?
");

$update_stmt->bind_param("sssii", $delivery_status, $failure_reason, $notes, $assignment_id, $rider_id);

if (!$update_stmt->execute()) {
    $_SESSION['error_message'] = 'Failed to update delivery status';
    $conn->close();
    header('Location: dashboard.php');
    exit;
}

$get_order = $conn->prepare("SELECT order_id FROM delivery_assignments WHERE assignment_id = ?");
$get_order->bind_param("i", $assignment_id);
$get_order->execute();
$order_result = $get_order->get_result()->fetch_assoc();
$order_id = $order_result['order_id'];

$log_stmt = $conn->prepare("
    INSERT INTO delivery_logs (assignment_id, rider_id, status_from, status_to, notes) 
    VALUES (?, ?, ?, ?, ?)
");
$log_stmt->bind_param("iisss", $assignment_id, $rider_id, $old_status, $delivery_status, $notes);
$log_stmt->execute();

$map_status = [
    'picked_up' => 'processing',
    'in_transit' => 'shipped',
    'delivered' => 'delivered',
    'failed' => 'pending',
    'returned' => 'pending'
];

if (isset($map_status[$delivery_status])) {
    $order_status = $map_status[$delivery_status];
    $update_order = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
    $update_order->bind_param("si", $order_status, $order_id);
    $update_order->execute();
}

logCustomerActivity(
    $rider_id,
    'delivery_status_update',
    "Delivery status updated from $old_status to $delivery_status for order ID: $order_id",
    'delivery_assignments',
    $assignment_id
);

$conn->close();

$_SESSION['success_message'] = 'Delivery status updated successfully!';
header('Location: dashboard.php');
exit;
?>
