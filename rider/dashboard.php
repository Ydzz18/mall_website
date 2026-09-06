<?php
require_once '../config.php';

if (!isset($_SESSION['rider_id'])) {
    header('Location: login.php');
    exit;
}

$rider_id = $_SESSION['rider_id'];
$conn = getDBConnection();

$filter = $_GET['filter'] ?? 'assigned';
$search = $_GET['search'] ?? '';

$where_clause = "WHERE da.rider_id = ?";
$params = [$rider_id];
$types = "i";

if ($filter && $filter !== 'all') {
    $where_clause .= " AND da.delivery_status = ?";
    $params[] = $filter;
    $types .= "s";
}

if (!empty($search)) {
    $where_clause .= " AND (o.order_number LIKE ? OR c.first_name LIKE ? OR c.last_name LIKE ?)";
    $search_param = "%$search%";
    $params = array_merge([$rider_id], [$search_param, $search_param, $search_param]);
    if ($filter && $filter !== 'all') {
        $params = array_merge([$rider_id, $filter], [$search_param, $search_param, $search_param]);
    }
    $types = "issss";
}

$query = "SELECT 
    da.assignment_id,
    da.order_id,
    da.delivery_status,
    da.assigned_at,
    da.picked_up_at,
    da.delivered_at,
    da.failure_reason,
    o.order_number,
    o.total_amount,
    o.created_at,
    c.first_name,
    c.last_name,
    a.street_address,
    a.city,
    a.postal_code
FROM delivery_assignments da
JOIN orders o ON da.order_id = o.order_id
JOIN customers c ON o.customer_id = c.customer_id
JOIN addresses a ON o.shipping_address_id = a.address_id
$where_clause
ORDER BY da.assigned_at DESC";

$stmt = $conn->prepare($query);
if (!empty($search)) {
    $stmt->bind_param($types, ...$params);
} else {
    if ($filter && $filter !== 'all') {
        $stmt->bind_param("is", $rider_id, $filter);
    } else {
        $stmt->bind_param("i", $rider_id);
    }
}

$stmt->execute();
$result = $stmt->get_result();
$deliveries = [];
while ($row = $result->fetch_assoc()) {
    $deliveries[] = $row;
}

$rider_query = "SELECT * FROM riders WHERE rider_id = ?";
$rider_stmt = $conn->prepare($rider_query);
$rider_stmt->bind_param("i", $rider_id);
$rider_stmt->execute();
$rider = $rider_stmt->get_result()->fetch_assoc();

$stats_query = "SELECT 
    COUNT(*) as total_assigned,
    SUM(CASE WHEN delivery_status = 'delivered' THEN 1 ELSE 0 END) as completed,
    SUM(CASE WHEN delivery_status = 'in_transit' THEN 1 ELSE 0 END) as in_transit,
    SUM(CASE WHEN delivery_status IN ('pending_assignment', 'assigned') THEN 1 ELSE 0 END) as pending
FROM delivery_assignments
WHERE rider_id = ?";
$stats_stmt = $conn->prepare($stats_query);
$stats_stmt->bind_param("i", $rider_id);
$stats_stmt->execute();
$stats = $stats_stmt->get_result()->fetch_assoc();

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
    <title>Rider Dashboard - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../logo/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .rider-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            background: #f8fafc;
            min-height: calc(100vh - 200px);
        }

        .rider-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .rider-info h2 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .rider-info p {
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid white;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-top: 4px solid #3b82f6;
        }

        .stat-card.completed {
            border-top-color: #34d399;
        }

        .stat-card.in-transit {
            border-top-color: #f472b6;
        }

        .stat-card.pending {
            border-top-color: #fbbf24;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .controls {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-buttons {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.75rem 1.5rem;
            border: 2px solid #e2e8f0;
            background: white;
            color: #374151;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .filter-btn.active {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .filter-btn:hover {
            border-color: #3b82f6;
        }

        .search-box {
            flex: 1;
            min-width: 250px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .deliveries-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f1f5f9;
            border-bottom: 2px solid #e2e8f0;
        }

        th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            color: #1e293b;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            color: white;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-right: 0.5rem;
        }

        .action-btn.primary {
            background: #3b82f6;
            color: white;
        }

        .action-btn.primary:hover {
            background: #2563eb;
        }

        .action-btn.secondary {
            background: #e2e8f0;
            color: #374151;
        }

        .action-btn.secondary:hover {
            background: #cbd5e1;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #64748b;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state p {
            margin-top: 1rem;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .modal-header h3 {
            font-size: 1.3rem;
            color: #1e293b;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #64748b;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            font-size: 0.95rem;
            transition: border-color 0.3s ease;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3b82f6;
        }

        .modal-footer {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        @media (max-width: 768px) {
            .rider-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .controls {
                flex-direction: column;
            }

            .search-box {
                min-width: 100%;
            }

            table {
                font-size: 0.9rem;
            }

            th, td {
                padding: 0.75rem 0.5rem;
            }

            .action-btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="rider-container">
        <div class="rider-header">
            <div class="rider-info">
                <h2><i class="fas fa-motorcycle"></i> Welcome, <?php echo htmlspecialchars($_SESSION['rider_name']); ?></h2>
                <p><?php echo htmlspecialchars($rider['vehicle_type']); ?> • <?php echo htmlspecialchars($rider['vehicle_plate'] ?? 'No plate'); ?></p>
            </div>
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Sign Out
            </a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_assigned'] ?? 0; ?></div>
                <div class="stat-label">Total Assigned</div>
            </div>
            <div class="stat-card in-transit">
                <div class="stat-number"><?php echo $stats['in_transit'] ?? 0; ?></div>
                <div class="stat-label">In Transit</div>
            </div>
            <div class="stat-card completed">
                <div class="stat-number"><?php echo $stats['completed'] ?? 0; ?></div>
                <div class="stat-label">Completed</div>
            </div>
            <div class="stat-card pending">
                <div class="stat-number"><?php echo $stats['pending'] ?? 0; ?></div>
                <div class="stat-label">Pending Action</div>
            </div>
        </div>

        <div class="controls">
            <div class="filter-buttons">
                <a href="?filter=all" class="filter-btn <?php echo ($filter === 'all' ? 'active' : ''); ?>">All</a>
                <a href="?filter=assigned" class="filter-btn <?php echo ($filter === 'assigned' ? 'active' : ''); ?>">Assigned</a>
                <a href="?filter=picked_up" class="filter-btn <?php echo ($filter === 'picked_up' ? 'active' : ''); ?>">Picked Up</a>
                <a href="?filter=in_transit" class="filter-btn <?php echo ($filter === 'in_transit' ? 'active' : ''); ?>">In Transit</a>
                <a href="?filter=delivered" class="filter-btn <?php echo ($filter === 'delivered' ? 'active' : ''); ?>">Delivered</a>
                <a href="?filter=failed" class="filter-btn <?php echo ($filter === 'failed' ? 'active' : ''); ?>">Failed</a>
            </div>
            <div class="search-box">
                <form method="GET" style="display: flex; align-items: center;">
                    <input type="text" name="search" placeholder="Search order #, customer name..." value="<?php echo htmlspecialchars($search); ?>">
                    <input type="hidden" name="filter" value="<?php echo htmlspecialchars($filter); ?>">
                </form>
            </div>
        </div>

        <?php if (empty($deliveries)): ?>
            <div class="deliveries-table">
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>No deliveries found</p>
                </div>
            </div>
        <?php else: ?>
            <div class="deliveries-table">
                <table>
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Address</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Assigned Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($deliveries as $delivery): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($delivery['order_number']); ?></strong></td>
                                <td><?php echo htmlspecialchars($delivery['first_name'] . ' ' . $delivery['last_name']); ?></td>
                                <td>
                                    <small>
                                        <?php echo htmlspecialchars($delivery['street_address']); ?><br>
                                        <?php echo htmlspecialchars($delivery['city'] . ', ' . $delivery['postal_code']); ?>
                                    </small>
                                </td>
                                <td><?php echo formatCurrency($delivery['total_amount']); ?></td>
                                <td>
                                    <span class="status-badge" style="background-color: <?php echo $status_colors[$delivery['delivery_status']]; ?>">
                                        <?php echo $status_labels[$delivery['delivery_status']]; ?>
                                    </span>
                                </td>
                                <td><small><?php echo date('M d, Y', strtotime($delivery['assigned_at'])); ?></small></td>
                                <td>
                                    <button class="action-btn primary" onclick="openUpdateModal(<?php echo $delivery['assignment_id']; ?>, '<?php echo htmlspecialchars($delivery['order_number']); ?>', '<?php echo $delivery['delivery_status']; ?>')">
                                        Update
                                    </button>
                                    <button class="action-btn secondary" onclick="viewDetails(<?php echo $delivery['order_id']; ?>)">
                                        View
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <div class="modal" id="updateModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Update Delivery Status</h3>
                <button class="close-btn" onclick="closeUpdateModal()">×</button>
            </div>
            <form id="updateForm" method="POST" action="update_delivery.php">
                <input type="hidden" id="assignmentId" name="assignment_id">
                
                <div class="form-group">
                    <label>Order Number</label>
                    <input type="text" id="orderNumber" readonly style="background: #f1f5f9;">
                </div>

                <div class="form-group">
                    <label for="statusSelect">Delivery Status *</label>
                    <select id="statusSelect" name="delivery_status" required>
                        <option value="">Select a status</option>
                        <option value="assigned">Assigned</option>
                        <option value="picked_up">Picked Up</option>
                        <option value="in_transit">In Transit</option>
                        <option value="delivered">Delivered</option>
                        <option value="failed">Failed Delivery</option>
                        <option value="returned">Returned</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="failureReason" id="failureLabel" style="display: none;">Failure Reason</label>
                    <textarea id="failureReason" name="failure_reason" style="display: none;" placeholder="Explain why delivery failed..."></textarea>
                </div>

                <div class="form-group">
                    <label for="notes">Notes (Optional)</label>
                    <textarea id="notes" name="notes" placeholder="Add any additional notes..."></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="action-btn secondary" onclick="closeUpdateModal()">Cancel</button>
                    <button type="submit" class="action-btn primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script>
        function openUpdateModal(assignmentId, orderNumber, currentStatus) {
            document.getElementById('assignmentId').value = assignmentId;
            document.getElementById('orderNumber').value = orderNumber;
            document.getElementById('statusSelect').value = currentStatus;
            document.getElementById('updateModal').classList.add('active');
            updateFailureReasonField();
        }

        function closeUpdateModal() {
            document.getElementById('updateModal').classList.remove('active');
            document.getElementById('updateForm').reset();
        }

        function updateFailureReasonField() {
            const status = document.getElementById('statusSelect').value;
            const failureLabel = document.getElementById('failureLabel');
            const failureReason = document.getElementById('failureReason');
            
            if (status === 'failed' || status === 'returned') {
                failureLabel.style.display = 'block';
                failureReason.style.display = 'block';
                failureReason.required = true;
            } else {
                failureLabel.style.display = 'none';
                failureReason.style.display = 'none';
                failureReason.required = false;
            }
        }

        document.getElementById('statusSelect').addEventListener('change', updateFailureReasonField);

        function viewDetails(orderId) {
            window.location.href = 'order_details.php?order_id=' + orderId;
        }

        window.onclick = function(event) {
            const modal = document.getElementById('updateModal');
            if (event.target === modal) {
                closeUpdateModal();
            }
        };
    </script>
</body>
</html>
