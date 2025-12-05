<?php
require_once '../config.php';

if (!isAdminLoggedIn()) {
    header('Location: login.php');
    exit;
}

if (!hasAdminPermission(RoleManager::PERMISSION_MANAGE_RIDERS)) {
    header('Location: index.php');
    exit;
}

$conn = getDBConnection();

$action = $_GET['action'] ?? '';
$rider_id = $_GET['rider_id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add' || $_POST['action'] === 'edit') {
            $first_name = trim($_POST['first_name'] ?? '');
            $last_name = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $vehicle_type = $_POST['vehicle_type'] ?? '';
            $vehicle_plate = trim($_POST['vehicle_plate'] ?? '');
            $status = $_POST['status'] ?? 'active';

            if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($vehicle_type)) {
                $_SESSION['error_message'] = 'Please fill in all required fields';
            } else {
                if ($_POST['action'] === 'add') {
                    $password = $_POST['password'] ?? '';
                    if (empty($password) || strlen($password) < 6) {
                        $_SESSION['error_message'] = 'Password must be at least 6 characters';
                    } else {
                        $password_hash = password_hash($password, PASSWORD_BCRYPT);
                        $stmt = $conn->prepare("
                            INSERT INTO riders (first_name, last_name, email, phone, password_hash, vehicle_type, vehicle_plate, status, is_verified)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)
                        ");
                        $stmt->bind_param("ssssssss", $first_name, $last_name, $email, $phone, $password_hash, $vehicle_type, $vehicle_plate, $status);
                        if ($stmt->execute()) {
                            $_SESSION['success_message'] = 'Rider added successfully';
                        } else {
                            if ($conn->errno === 1062) {
                                $_SESSION['error_message'] = 'Email already exists';
                            } else {
                                $_SESSION['error_message'] = 'Error adding rider';
                            }
                        }
                    }
                } else {
                    $stmt = $conn->prepare("
                        UPDATE riders 
                        SET first_name = ?, last_name = ?, email = ?, phone = ?, vehicle_type = ?, vehicle_plate = ?, status = ?
                        WHERE rider_id = ?
                    ");
                    $stmt->bind_param("sssssssi", $first_name, $last_name, $email, $phone, $vehicle_type, $vehicle_plate, $status, $rider_id);
                    if ($stmt->execute()) {
                        $_SESSION['success_message'] = 'Rider updated successfully';
                        header('Location: riders.php');
                        exit;
                    } else {
                        $_SESSION['error_message'] = 'Error updating rider';
                    }
                }
            }
        } elseif ($_POST['action'] === 'delete') {
            $stmt = $conn->prepare("DELETE FROM riders WHERE rider_id = ?");
            $stmt->bind_param("i", $rider_id);
            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Rider deleted successfully';
            } else {
                $_SESSION['error_message'] = 'Error deleting rider';
            }
            header('Location: riders.php');
            exit;
        }
    }
}

$search = $_GET['search'] ?? '';
$filter_status = $_GET['filter_status'] ?? '';

$where_clause = "";
$params = [];
$types = "";

if (!empty($search)) {
    $where_clause .= " WHERE (first_name LIKE ? OR last_name LIKE ? OR email LIKE ?)";
    $search_param = "%$search%";
    $params = [$search_param, $search_param, $search_param];
    $types = "sss";
}

if (!empty($filter_status)) {
    if (empty($where_clause)) {
        $where_clause = " WHERE status = ?";
    } else {
        $where_clause .= " AND status = ?";
    }
    $params[] = $filter_status;
    $types .= "s";
}

$query = "SELECT * FROM riders $where_clause ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$riders = [];
while ($row = $result->fetch_assoc()) {
    $riders[] = $row;
}

$edit_rider = null;
if ($action === 'edit' && $rider_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM riders WHERE rider_id = ?");
    $stmt->bind_param("i", $rider_id);
    $stmt->execute();
    $edit_rider = $stmt->get_result()->fetch_assoc();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Riders - Admin</title>
    <link rel="stylesheet" href="../admin/admin-styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .riders-container {
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

        .btn-primary {
            background: #3b82f6;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #2563eb;
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

        .riders-table {
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

        .status-badge.active {
            background: #34d399;
        }

        .status-badge.inactive {
            background: #f87171;
        }

        .status-badge.suspended {
            background: #fb923c;
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

        .btn-edit {
            background: #3b82f6;
            color: white;
        }

        .btn-edit:hover {
            background: #2563eb;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
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

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            font-size: 0.95rem;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3b82f6;
        }

        .form-group.required label::after {
            content: ' *';
            color: #ef4444;
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
        }

        .btn-cancel:hover {
            background: #cbd5e1;
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
            <div class="riders-container">
        <div class="page-header">
            <h1><i class="fas fa-motorcycle"></i> Manage Riders</h1>
            <button class="btn-primary" onclick="openAddModal()">
                <i class="fas fa-plus"></i> Add Rider
            </button>
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
                    <input type="text" name="search" placeholder="Search by name or email..." value="<?php echo htmlspecialchars($search); ?>">
                </form>
            </div>
            <select class="filter-select" onchange="location.href='?filter_status=' + this.value">
                <option value="">All Status</option>
                <option value="active" <?php echo ($filter_status === 'active' ? 'selected' : ''); ?>>Active</option>
                <option value="inactive" <?php echo ($filter_status === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                <option value="suspended" <?php echo ($filter_status === 'suspended' ? 'selected' : ''); ?>>Suspended</option>
            </select>
        </div>

        <?php if (empty($riders)): ?>
            <div class="riders-table">
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>No riders found</p>
                </div>
            </div>
        <?php else: ?>
            <div class="riders-table">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Vehicle</th>
                            <th>Status</th>
                            <th>Deliveries</th>
                            <th>Rating</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riders as $rider): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($rider['first_name'] . ' ' . $rider['last_name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($rider['email']); ?></td>
                                <td><?php echo htmlspecialchars($rider['phone']); ?></td>
                                <td><?php echo htmlspecialchars(ucfirst($rider['vehicle_type'])); ?></td>
                                <td>
                                    <span class="status-badge <?php echo $rider['status']; ?>">
                                        <?php echo ucfirst($rider['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo $rider['completed_deliveries'] . ' / ' . $rider['total_deliveries']; ?></td>
                                <td>
                                    <?php if ($rider['total_deliveries'] > 0): ?>
                                        <span style="color: #f59e0b;">★</span> <?php echo number_format($rider['rating'], 1); ?>
                                    <?php else: ?>
                                        <span style="color: #cbd5e1;">No ratings</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <button class="btn-small btn-edit" onclick="openEditModal(<?php echo $rider['rider_id']; ?>, '<?php echo htmlspecialchars($rider['first_name']); ?>', '<?php echo htmlspecialchars($rider['last_name']); ?>', '<?php echo htmlspecialchars($rider['email']); ?>', '<?php echo htmlspecialchars($rider['phone']); ?>', '<?php echo $rider['vehicle_type']; ?>', '<?php echo htmlspecialchars($rider['vehicle_plate'] ?? ''); ?>', '<?php echo $rider['status']; ?>')">
                                            Edit
                                        </button>
                                        <button class="btn-small btn-delete" onclick="if(confirm('Delete this rider?')) { document.getElementById('deleteForm').action = 'riders.php'; document.getElementById('deleterId').value = <?php echo $rider['rider_id']; ?>; document.getElementById('deleteForm').submit(); }">
                                            Delete
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

    <div class="modal" id="riderModal">
        <div class="modal-content">
            <div class="modal-header" id="modalTitle">Add New Rider</div>
            <form id="riderForm" method="POST">
                <input type="hidden" id="action" name="action" value="add">
                <input type="hidden" id="riderId" name="rider_id" value="">

                <div class="form-group required">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="first_name" required>
                </div>

                <div class="form-group required">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="last_name" required>
                </div>

                <div class="form-group required">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group required">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>

                <div class="form-group required" id="passwordGroup">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group required">
                    <label for="vehicleType">Vehicle Type</label>
                    <select id="vehicleType" name="vehicle_type" required>
                        <option value="">Select vehicle</option>
                        <option value="motorcycle">Motorcycle</option>
                        <option value="bicycle">Bicycle</option>
                        <option value="car">Car</option>
                        <option value="truck">Truck</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="vehiclePlate">Plate Number</label>
                    <input type="text" id="vehiclePlate" name="vehicle_plate">
                </div>

                <div class="form-group required">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-small btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-small btn-primary">Save Rider</button>
                </div>
            </form>
        </div>
    </div>

    <form id="deleteForm" method="POST" style="display: none;">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" id="deleterId" name="rider_id">
    </form>

    <script>
        function openAddModal() {
            document.getElementById('action').value = 'add';
            document.getElementById('modalTitle').textContent = 'Add New Rider';
            document.getElementById('riderForm').reset();
            document.getElementById('passwordGroup').style.display = 'block';
            document.getElementById('password').required = true;
            document.getElementById('riderModal').classList.add('active');
        }

        function openEditModal(riderId, firstName, lastName, email, phone, vehicleType, vehiclePlate, status) {
            document.getElementById('action').value = 'edit';
            document.getElementById('modalTitle').textContent = 'Edit Rider';
            document.getElementById('riderId').value = riderId;
            document.getElementById('firstName').value = firstName;
            document.getElementById('lastName').value = lastName;
            document.getElementById('email').value = email;
            document.getElementById('phone').value = phone;
            document.getElementById('vehicleType').value = vehicleType;
            document.getElementById('vehiclePlate').value = vehiclePlate;
            document.getElementById('status').value = status;
            document.getElementById('passwordGroup').style.display = 'none';
            document.getElementById('password').required = false;
            document.getElementById('riderModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('riderModal').classList.remove('active');
        }

        window.onclick = function(event) {
            const modal = document.getElementById('riderModal');
            if (event.target === modal) {
                closeModal();
            }
        };
    </script>
        </main>
    </div>
</body>
</html>
