<?php
require_once '../config.php';

if (!isAdminLoggedIn()) {
    header('Location: login.php');
    exit;
}

if (!hasAdminPermission(RoleManager::PERMISSION_MANAGE_DELIVERIES)) {
    header('Location: index.php');
    exit;
}

$conn = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'assign') {
            $order_id = $_POST['order_id'] ?? 0;
            $rider_id = $_POST['rider_id'] ?? 0;

            if (!empty($order_id) && !empty($rider_id)) {
                $check_stmt = $conn->prepare("SELECT assignment_id FROM delivery_assignments WHERE order_id = ?");
                $check_stmt->bind_param("i", $order_id);
                $check_stmt->execute();
                $check_result = $check_stmt->get_result();

                if ($check_result->num_rows > 0) {
                    $update_stmt = $conn->prepare("
                        UPDATE delivery_assignments 
                        SET rider_id = ?, delivery_status = 'assigned', assigned_at = NOW()
                        WHERE order_id = ?
                    ");
                    $update_stmt->bind_param("ii", $rider_id, $order_id);
                    if ($update_stmt->execute()) {
                        $_SESSION['success_message'] = 'Rider assigned successfully';
                    } else {
                        $_SESSION['error_message'] = 'Error assigning rider';
                    }
                } else {
                    $insert_stmt = $conn->prepare("
                        INSERT INTO delivery_assignments (order_id, rider_id, delivery_status, assigned_at)
                        VALUES (?, ?, 'assigned', NOW())
                    ");
                    $insert_stmt->bind_param("ii", $order_id, $rider_id);
                    if ($insert_stmt->execute()) {
                        $_SESSION['success_message'] = 'Delivery assignment created';
                    } else {
                        $_SESSION['error_message'] = 'Error creating delivery assignment';
                    }
                }
            }
        }
    }
}

$filter_status = $_GET['filter_status'] ?? '';
$search = $_GET['search'] ?? '';

$where_clause = "WHERE o.order_status IN ('pending', 'processing', 'shipped')";
$params = [];
$types = "";

if (!empty($filter_status)) {
    $where_clause .= " AND COALESCE(da.delivery_status, 'pending_assignment') = ?";
    $params[] = $filter_status;
    $types = "s";
}

if (!empty($search)) {
    $where_clause .= " AND (o.order_number LIKE ? OR c.first_name LIKE ? OR c.last_name LIKE ?)";
    $search_param = "%$search%";
    $params = array_merge($params, [$search_param, $search_param, $search_param]);
    $types = empty($types) ? "sss" : $types . "sss";
}

$query = "
    SELECT 
        o.order_id,
        o.order_number,
        o.total_amount,
        o.order_status,
        o.created_at,
        c.first_name,
        c.last_name,
        c.email,
        a.city,
        da.assignment_id,
        da.delivery_status,
        da.assigned_at,
        r.first_name as rider_first_name,
        r.last_name as rider_last_name,
        r.vehicle_type,
        r.vehicle_plate
    FROM orders o
    JOIN customers c ON o.customer_id = c.customer_id
    JOIN addresses a ON o.shipping_address_id = a.address_id
    LEFT JOIN delivery_assignments da ON o.order_id = da.order_id
    LEFT JOIN riders r ON da.rider_id = r.rider_id
    $where_clause
    ORDER BY o.created_at DESC
";

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$deliveries = [];
while ($row = $result->fetch_assoc()) {
    $deliveries[] = $row;
}

$riders_query = "SELECT rider_id, CONCAT(first_name, ' ', last_name) as name, status FROM riders WHERE status = 'active' ORDER BY first_name";
$riders_stmt = $conn->prepare($riders_query);
$riders_stmt->execute();
$riders_result = $riders_stmt->get_result();
$riders = [];
while ($row = $riders_result->fetch_assoc()) {
    $riders[] = $row;
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
    <title>Manage Deliveries - Admin</title>
    <link rel="icon" type="image/png" href="../logo/favicon.png?v=1">
    <link rel="stylesheet" href="../admin/admin-styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .deliveries-container {
            padding: 2rem;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 1rem;
        }

        .page-header h1 {
            font-size: 1.8rem;
            color: #1e293b;
        }

        .controls {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .search-box {
            flex: 1;
            min-width: 250px;
        }

        .search-box input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            font-size: 0.95rem;
        }

        .search-box input:focus {
            outline: none;
            border-color: #3b82f6;
        }

        .filter-select {
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            font-size: 0.95rem;
            cursor: pointer;
        }

        .filter-select:focus {
            outline: none;
            border-color: #3b82f6;
        }

        .deliveries-table {
            background: white;
            border-radius: 8px;
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
            font-size: 0.9rem;
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
            padding: 0.4rem 0.8rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            color: white;
        }

        .order-badge {
            background: #f3f4f6;
            color: #1f2937;
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .action-btns {
            display: flex;
            gap: 0.5rem;
        }

        .btn-small {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-assign {
            background: #3b82f6;
            color: white;
        }

        .btn-assign:hover {
            background: #2563eb;
        }

        .btn-view {
            background: #6366f1;
            color: white;
        }

        .btn-view:hover {
            background: #4f46e5;
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
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #1e293b;
        }

        .order-info-modal {
            background: #f1f5f9;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .info-label {
            color: #64748b;
            font-weight: 600;
        }

        .info-value {
            color: #1e293b;
            font-weight: 500;
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

        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            font-size: 0.95rem;
        }

        .form-group select:focus {
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

        .btn-cancel {
            background: #e2e8f0;
            color: #374151;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #cbd5e1;
        }

        .btn-submit {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background: #2563eb;
        }

        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            color: #047857;
        }

        .alert-error {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #dc2626;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #64748b;
        }

        .empty-state i {
            font-size: 2rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .controls {
                flex-direction: column;
            }

            table {
                font-size: 0.9rem;
            }

            th, td {
                padding: 0.75rem 0.5rem;
            }

            .action-btns {
                flex-direction: column;
            }

            .btn-small {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>
        
        <main class="admin-main">
            <div class="deliveries-container">
        <div class="page-header">
            <h1><i class="fas fa-truck"></i> Manage Deliveries</h1>
        </div>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php echo htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <div class="controls">
            <div class="search-box">
                <form method="GET" style="display: flex;">
                    <input type="text" name="search" placeholder="Search by order #, customer name..." value="<?php echo htmlspecialchars($search); ?>">
                </form>
            </div>
            <select class="filter-select" onchange="location.href='?filter_status=' + this.value">
                <option value="">All Status</option>
                <option value="pending_assignment" <?php echo ($filter_status === 'pending_assignment' ? 'selected' : ''); ?>>Pending Assignment</option>
                <option value="assigned" <?php echo ($filter_status === 'assigned' ? 'selected' : ''); ?>>Assigned</option>
                <option value="picked_up" <?php echo ($filter_status === 'picked_up' ? 'selected' : ''); ?>>Picked Up</option>
                <option value="in_transit" <?php echo ($filter_status === 'in_transit' ? 'selected' : ''); ?>>In Transit</option>
                <option value="delivered" <?php echo ($filter_status === 'delivered' ? 'selected' : ''); ?>>Delivered</option>
            </select>
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
                            <th>City</th>
                            <th>Amount</th>
                            <th>Delivery Status</th>
                            <th>Assigned Rider</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($deliveries as $delivery): ?>
                            <tr>
                                <td>
                                    <span class="order-badge"><?php echo htmlspecialchars($delivery['order_number']); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($delivery['first_name'] . ' ' . $delivery['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($delivery['city']); ?></td>
                                <td><strong><?php echo formatCurrency($delivery['total_amount']); ?></strong></td>
                                <td>
                                    <span class="status-badge" style="background-color: <?php echo $status_colors[$delivery['delivery_status'] ?? 'pending_assignment']; ?>">
                                        <?php echo $status_labels[$delivery['delivery_status'] ?? 'pending_assignment']; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($delivery['rider_first_name'])): ?>
                                        <small>
                                            <?php echo htmlspecialchars($delivery['rider_first_name'] . ' ' . $delivery['rider_last_name']); ?><br>
                                            <span style="color: #64748b;"><?php echo htmlspecialchars($delivery['vehicle_plate']); ?></span>
                                        </small>
                                    <?php else: ?>
                                        <span style="color: #f87171;">Unassigned</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <button class="btn-small btn-assign" onclick="openAssignModal(<?php echo $delivery['order_id']; ?>, '<?php echo htmlspecialchars($delivery['order_number']); ?>', '<?php echo htmlspecialchars($delivery['first_name'] . ' ' . $delivery['last_name']); ?>')">
                                            Assign
                                        </button>
                                        <button class="btn-small btn-view" onclick="window.location.href='../admin/order_details.php?order_id=<?php echo $delivery['order_id']; ?>'">
                                            View
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <div class="modal" id="assignModal">
        <div class="modal-content">
            <div class="modal-header">Assign Rider to Delivery</div>
            <form id="assignForm" method="POST">
                <input type="hidden" name="action" value="assign">
                <input type="hidden" id="orderId" name="order_id">

                <div class="order-info-modal">
                    <div class="info-row">
                        <span class="info-label">Order Number</span>
                        <span class="info-value" id="orderNumber"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Customer</span>
                        <span class="info-value" id="customerName"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="riderId">Select Rider *</label>
                    <select id="riderId" name="rider_id" required>
                        <option value="">-- Select a Rider --</option>
                        <?php foreach ($riders as $rider): ?>
                            <option value="<?php echo $rider['rider_id']; ?>">
                                <?php echo htmlspecialchars($rider['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeAssignModal()">Cancel</button>
                    <button type="submit" class="btn-submit">Assign Rider</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAssignModal(orderId, orderNumber, customerName) {
            document.getElementById('orderId').value = orderId;
            document.getElementById('orderNumber').textContent = orderNumber;
            document.getElementById('customerName').textContent = customerName;
            document.getElementById('assignModal').classList.add('active');
        }

        function closeAssignModal() {
            document.getElementById('assignModal').classList.remove('active');
        }

        window.onclick = function(event) {
            const modal = document.getElementById('assignModal');
            if (event.target === modal) {
                closeAssignModal();
            }
        };
    </script>
        </main>
    </div>
</body>
</html>
