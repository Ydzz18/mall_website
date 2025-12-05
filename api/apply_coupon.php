<?php
require_once '../config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$coupon_code = strtoupper(trim($_POST['coupon_code'] ?? ''));
$subtotal = floatval($_POST['subtotal'] ?? 0);
$customer_id = $_SESSION['customer_id'];

if (empty($coupon_code)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Coupon code required']);
    exit;
}

if ($subtotal <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid subtotal']);
    exit;
}

$conn = getDBConnection();

$stmt = $conn->prepare("
    SELECT * FROM coupons 
    WHERE coupon_code = ? 
    AND is_active = 1
");
$stmt->bind_param("s", $coupon_code);
$stmt->execute();
$coupon = $stmt->get_result()->fetch_assoc();

if (!$coupon) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Coupon not found or inactive']);
    $conn->close();
    exit;
}

$today = date('Y-m-d');

if ($today < $coupon['start_date'] || $today > $coupon['end_date']) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Coupon is not valid for today']);
    $conn->close();
    exit;
}

if ($subtotal < $coupon['min_purchase_amount']) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Minimum purchase of ' . formatCurrency($coupon['min_purchase_amount']) . ' required']);
    $conn->close();
    exit;
}

if ($coupon['usage_limit'] !== null) {
    $stmt = $conn->prepare("SELECT COUNT(*) as usage_count FROM order_coupons WHERE coupon_id = ?");
    $stmt->bind_param("i", $coupon['coupon_id']);
    $stmt->execute();
    $usage = $stmt->get_result()->fetch_assoc();
    
    if ($usage['usage_count'] >= $coupon['usage_limit']) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Coupon usage limit reached']);
        $conn->close();
        exit;
    }
}

$discount = 0;
if ($coupon['discount_type'] === 'percentage') {
    $discount = ($subtotal * $coupon['discount_value']) / 100;
    if ($coupon['max_discount_amount'] !== null) {
        $discount = min($discount, $coupon['max_discount_amount']);
    }
} else {
    $discount = $coupon['discount_value'];
}

$conn->close();

echo json_encode([
    'success' => true,
    'message' => 'Coupon applied successfully',
    'coupon_id' => $coupon['coupon_id'],
    'coupon_code' => $coupon['coupon_code'],
    'discount_amount' => round($discount, 2),
    'discount_percentage' => $coupon['discount_type'] === 'percentage' ? $coupon['discount_value'] : null
]);
?>
