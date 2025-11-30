<?php
// TEMPORARY DEBUG FILE - Remove after fixing the issue
require_once 'config.php';

if (!isLoggedIn()) {
    die("Not logged in");
}

$customer_id = $_SESSION['customer_id'];

echo "<h2>Debug Information</h2>";

// Check if order_id is provided
if (!isset($_GET['order_id'])) {
    die("No order_id provided");
}

$order_id = intval($_GET['order_id']);
echo "<p><strong>Order ID:</strong> $order_id</p>";

// Check order
$conn = getDBConnection();
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND customer_id = ?");
$stmt->bind_param("ii", $order_id, $customer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Order not found or doesn't belong to you");
}

$order = $result->fetch_assoc();
echo "<h3>Order Details:</h3>";
echo "<pre>";
print_r($order);
echo "</pre>";

// Check payment
$stmt = $conn->prepare("SELECT * FROM payments WHERE order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$payment = $stmt->get_result()->fetch_assoc();

echo "<h3>Payment Details:</h3>";
echo "<pre>";
print_r($payment);
echo "</pre>";

// Check shipping
$stmt = $conn->prepare("SELECT * FROM shipping WHERE order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$shipping = $stmt->get_result()->fetch_assoc();

echo "<h3>Shipping Details:</h3>";
echo "<pre>";
print_r($shipping);
echo "</pre>";

// Test redirect URL
$redirect_url = 'order_success.php?order_number=' . urlencode($order['order_number']);
echo "<h3>Redirect URL:</h3>";
echo "<p><a href='$redirect_url'>$redirect_url</a></p>";

$conn->close();
?>