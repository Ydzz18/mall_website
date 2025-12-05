<?php
require_once '../config.php';

if (!isset($_SESSION['rider_id'])) {
    header('Location: login.php');
    exit;
}

$order_id = $_GET['order_id'] ?? 0;
if (empty($order_id)) {
    header('Location: dashboard.php');
    exit;
}

$rider_id = $_SESSION['rider_id'];
$conn = getDBConnection();

$order_query = "
    SELECT 
        o.*,
        c.first_name,
        c.last_name,
        c.email,
        c.phone,
        sa.street_address as shipping_street,
        sa.city as shipping_city,
        sa.postal_code as shipping_postal,
        da.assignment_id,
        da.delivery_status,
        r.rider_id,
        r.vehicle_type,
        r.vehicle_plate
    FROM orders o
    JOIN customers c ON o.customer_id = c.customer_id
    JOIN addresses sa ON o.shipping_address_id = sa.address_id
    LEFT JOIN delivery_assignments da ON o.order_id = da.order_id
    LEFT JOIN riders r ON da.rider_id = r.rider_id
    WHERE o.order_id = ?
";

$stmt = $conn->prepare($order_query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header('Location: dashboard.php');
    exit;
}

$order = $result->fetch_assoc();

$items_query = "
    SELECT oi.*, p.name, p.price
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    WHERE oi.order_id = ?
";

$items_stmt = $conn->prepare($items_query);
$items_stmt->bind_param("i", $order_id);
$items_stmt->execute();
$items_result = $items_stmt->get_result();
$items = [];
while ($item = $items_result->fetch_assoc()) {
    $items[] = $item;
}

$logs_query = "
    SELECT * FROM delivery_logs
    WHERE assignment_id = ?
    ORDER BY created_at DESC
";

$logs_stmt = $conn->prepare($logs_query);
$logs_stmt->bind_param("i", $order['assignment_id']);
$logs_stmt->execute();
$logs_result = $logs_stmt->get_result();
$logs = [];
while ($log = $logs_result->fetch_assoc()) {
    $logs[] = $log;
}

$conn->close();

$status_colors = [
    'pending_assignment' => '#fbbf24',
    'assigned' => '#60a5fa',
    'picked_up' => '#a78bfa',
    'in_transit' => '#f472b6',
    'delivered' => '#34d399',
    'failed' => '#f87171',
    'returned' => '#fb923c'
];

$status_labels = [
    'pending_assignment' => 'Pending Assignment',
    'assigned' => 'Assigned',
    'picked_up' => 'Picked Up',
    'in_transit' => 'In Transit',
    'delivered' => 'Delivered',
    'failed' => 'Failed',
    'returned' => 'Returned'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../logo/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .details-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            background: #f8fafc;
            min-height: calc(100vh - 200px);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #3b82f6;
            text-decoration: none;
            margin-bottom: 2rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            color: #2563eb;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .card-header h3 {
            font-size: 1.3rem;
            color: #1e293b;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            color: white;
        }

        .order-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 1rem;
            color: #1e293b;
            font-weight: 500;
        }

        .customer-section {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #e2e8f0;
        }

        .customer-section h4 {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            color: #1e293b;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            font-size: 0.95rem;
        }

        .contact-info a {
            color: #3b82f6;
            text-decoration: none;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        .address-section {
            background: #f1f5f9;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .address-section p {
            margin: 0.25rem 0;
            color: #374151;
            font-size: 0.95rem;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }

        .items-table thead {
            background: #f1f5f9;
            border-bottom: 2px solid #e2e8f0;
        }

        .items-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .items-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            color: #1e293b;
        }

        .items-table tbody tr:hover {
            background: #f8fafc;
        }

        .price {
            font-weight: 600;
            color: #3b82f6;
        }

        .summary-section {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 2px solid #e2e8f0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.95rem;
        }

        .summary-row.total {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1e293b;
            margin-top: 0.5rem;
        }

        .timeline {
            position: relative;
        }

        .timeline-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-left: 2rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0.5rem;
            width: 16px;
            height: 16px;
            background: #3b82f6;
            border: 3px solid white;
            border-radius: 50%;
            box-shadow: 0 0 0 2px #e2e8f0;
        }

        .timeline-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 7px;
            top: 2rem;
            width: 2px;
            height: calc(100% - 1rem);
            background: #e2e8f0;
        }

        .timeline-content {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .timeline-status {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.95rem;
        }

        .timeline-time {
            font-size: 0.85rem;
            color: #64748b;
        }

        .timeline-notes {
            font-size: 0.9rem;
            color: #475569;
            margin-top: 0.25rem;
            font-style: italic;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #64748b;
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .details-grid {
                grid-template-columns: 1fr;
            }

            .order-info {
                grid-template-columns: 1fr;
            }

            .items-table {
                font-size: 0.85rem;
            }

            .items-table th,
            .items-table td {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <div class="details-container">
        <a href="dashboard.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>

        <div class="details-grid">
            <div>
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h3>Order <?php echo htmlspecialchars($order['order_number']); ?></h3>
                            <small style="color: #64748b;">Created on <?php echo date('M d, Y H:i', strtotime($order['created_at'])); ?></small>
                        </div>
                        <span class="status-badge" style="background-color: <?php echo $status_colors[$order['delivery_status'] ?? 'pending_assignment']; ?>">
                            <?php echo $status_labels[$order['delivery_status'] ?? 'pending_assignment']; ?>
                        </span>
                    </div>

                    <div class="order-info">
                        <div class="info-item">
                            <span class="info-label">Total Amount</span>
                            <span class="info-value"><?php echo formatCurrency($order['total_amount']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Payment Status</span>
                            <span class="info-value"><?php echo ucfirst($order['payment_status']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Payment Method</span>
                            <span class="info-value"><?php echo htmlspecialchars($order['payment_method']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Subtotal</span>
                            <span class="info-value"><?php echo formatCurrency($order['subtotal']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tax</span>
                            <span class="info-value"><?php echo formatCurrency($order['tax_amount']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Shipping</span>
                            <span class="info-value"><?php echo formatCurrency($order['shipping_cost']); ?></span>
                        </div>
                    </div>

                    <div class="customer-section">
                        <h4><i class="fas fa-user"></i> Customer Information</h4>
                        <div class="contact-info">
                            <strong><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></strong>
                            <a href="mailto:<?php echo htmlspecialchars($order['email']); ?>">
                                <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($order['email']); ?>
                            </a>
                            <a href="tel:<?php echo htmlspecialchars($order['phone']); ?>">
                                <i class="fas fa-phone"></i> <?php echo htmlspecialchars($order['phone']); ?>
                            </a>
                        </div>

                        <div class="address-section">
                            <p><strong><i class="fas fa-map-marker-alt"></i> Shipping Address</strong></p>
                            <p><?php echo htmlspecialchars($order['shipping_street']); ?></p>
                            <p><?php echo htmlspecialchars($order['shipping_city'] . ', ' . $order['shipping_postal']); ?></p>
                        </div>
                    </div>

                    <h4 style="margin-top: 2rem; margin-bottom: 1rem;"><i class="fas fa-box"></i> Items Ordered</h4>
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td class="price"><?php echo formatCurrency($item['unit_price']); ?></td>
                                    <td class="price"><?php echo formatCurrency($item['subtotal']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="summary-section">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span><?php echo formatCurrency($order['subtotal']); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Tax:</span>
                            <span><?php echo formatCurrency($order['tax_amount']); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping:</span>
                            <span><?php echo formatCurrency($order['shipping_cost']); ?></span>
                        </div>
                        <div class="summary-row total">
                            <span>Total:</span>
                            <span><?php echo formatCurrency($order['total_amount']); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sidebar">
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-history"></i> Delivery Timeline</h3>
                    </div>
                    <?php if (!empty($logs)): ?>
                        <div class="timeline">
                            <?php foreach ($logs as $log): ?>
                                <div class="timeline-item">
                                    <div class="timeline-content">
                                        <div class="timeline-status"><?php echo ucwords(str_replace('_', ' ', $log['status_to'])); ?></div>
                                        <div class="timeline-time"><?php echo date('M d, Y H:i', strtotime($log['created_at'])); ?></div>
                                        <?php if (!empty($log['notes'])): ?>
                                            <div class="timeline-notes">
                                                <i class="fas fa-note-sticky"></i> <?php echo htmlspecialchars($log['notes']); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <p><i class="fas fa-inbox"></i> No updates yet</p>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($order['rider_id'])): ?>
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-user-tie"></i> Rider Info</h3>
                        </div>
                        <div class="info-item" style="gap: 0.75rem;">
                            <span class="info-label">Vehicle Type</span>
                            <span class="info-value"><?php echo ucfirst($order['vehicle_type']); ?></span>
                        </div>
                        <div class="info-item" style="margin-top: 1rem; gap: 0.75rem;">
                            <span class="info-label">Plate Number</span>
                            <span class="info-value"><?php echo htmlspecialchars($order['vehicle_plate'] ?? 'N/A'); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
