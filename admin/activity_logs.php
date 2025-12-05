<?php
require_once '../config.php';
require_once '../includes/ActivityLogger.php';

// Check if admin is logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

if (!hasAdminPermission(RoleManager::PERMISSION_VIEW_ACTIVITY_LOGS)) {
    header('Location: index.php');
    exit;
}

$admin_id = $_SESSION['admin_id'];
$logger = new ActivityLogger();

// Get filters
$filters = [];
if (isset($_GET['user_type']) && $_GET['user_type'] !== '') {
    $filters['user_type'] = $_GET['user_type'];
}
if (isset($_GET['action_type']) && $_GET['action_type'] !== '') {
    $filters['action_type'] = $_GET['action_type'];
}
if (isset($_GET['date_from']) && $_GET['date_from'] !== '') {
    $filters['date_from'] = $_GET['date_from'];
}
if (isset($_GET['date_to']) && $_GET['date_to'] !== '') {
    $filters['date_to'] = $_GET['date_to'];
}
if (isset($_GET['search']) && $_GET['search'] !== '') {
    $filters['search'] = $_GET['search'];
}

// Pagination
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = 50;
$filters['limit'] = $per_page;
$filters['offset'] = ($page - 1) * $per_page;

// Get logs and total count
$logs = $logger->getLogs($filters);
$total_logs = $logger->getLogCount($filters);
$total_pages = ceil($total_logs / $per_page);

// Get action types for filter
$conn = getDBConnection();
$action_types = $conn->query("SELECT DISTINCT action_type FROM activity_logs ORDER BY action_type")->fetch_all(MYSQLI_ASSOC);

// Get statistics
$stats = $logger->getStatistics(7);

// Handle export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="activity_logs_' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Date', 'User Type', 'User', 'Action Type', 'Description', 'IP Address']);
    
    foreach ($logs as $log) {
        fputcsv($output, [
            $log['created_at'],
            ucfirst($log['user_type']),
            $log['user_name'] . ' (' . $log['user_email'] . ')',
            $log['action_type'],
            $log['action_description'],
            $log['ip_address']
        ]);
    }
    
    fclose($output);
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs - Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../logo/icon.png">
    <style>
        <?php include 'admin-styles.css'; ?>

        .page-header {
            background: white;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 2rem;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .page-header p {
            color: #7f8c8d;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .stat-card h3 {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .filters-section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .filter-group input,
        .filter-group select {
            padding: 10px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 1rem;
        }

        .filter-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
        }

        .btn-success {
            background: #27ae60;
            color: white;
        }

        .logs-table {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f8f9fa;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 2px solid #e0e0e0;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        .user-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-admin {
            background: #e74c3c;
            color: white;
        }

        .badge-customer {
            background: #3498db;
            color: white;
        }

        .action-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            background: #ecf0f1;
            color: #2c3e50;
        }

        .log-description {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .log-details-btn {
            padding: 5px 10px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.85rem;
        }

        .log-details-btn:hover {
            background: #2980b9;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .page-link {
            padding: 8px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            text-decoration: none;
            color: #2c3e50;
            font-weight: 600;
        }

        .page-link:hover {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }

        .page-link.active {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }

        .page-link.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #7f8c8d;
        }

        .detail-row {
            margin-bottom: 15px;
        }

        .detail-row strong {
            display: block;
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .detail-row .value {
            color: #2c3e50;
            font-weight: 600;
        }

        .json-viewer {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            overflow-x: auto;
        }

        @media (max-width: 768px) {
            .stats-grid,
            .filters-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>
        
        <main class="admin-main">
            <div class="page-header">
                <h1>📋 Activity Logs</h1>
                <p>Monitor all activities and actions performed in the system</p>
            </div>

            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Logs Today</h3>
                    <div class="stat-value">
                        <?php
                        $today_count = $logger->getLogCount(['date_from' => date('Y-m-d')]);
                        echo number_format($today_count);
                        ?>
                    </div>
                </div>
                <div class="stat-card">
                    <h3>Total Logs (7 Days)</h3>
                    <div class="stat-value">
                        <?php
                        $week_count = $logger->getLogCount(['date_from' => date('Y-m-d', strtotime('-7 days'))]);
                        echo number_format($week_count);
                        ?>
                    </div>
                </div>
                <div class="stat-card">
                    <h3>Admin Activities</h3>
                    <div class="stat-value">
                        <?php
                        $admin_count = $logger->getLogCount(['user_type' => 'admin']);
                        echo number_format($admin_count);
                        ?>
                    </div>
                </div>
                <div class="stat-card">
                    <h3>Customer Activities</h3>
                    <div class="stat-value">
                        <?php
                        $customer_count = $logger->getLogCount(['user_type' => 'customer']);
                        echo number_format($customer_count);
                        ?>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters-section">
                <form method="GET" action="">
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label>User Type</label>
                            <select name="user_type">
                                <option value="">All Users</option>
                                <option value="admin" <?php echo isset($_GET['user_type']) && $_GET['user_type'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="customer" <?php echo isset($_GET['user_type']) && $_GET['user_type'] === 'customer' ? 'selected' : ''; ?>>Customer</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Action Type</label>
                            <select name="action_type">
                                <option value="">All Actions</option>
                                <?php foreach ($action_types as $type): ?>
                                    <option value="<?php echo htmlspecialchars($type['action_type']); ?>" 
                                            <?php echo isset($_GET['action_type']) && $_GET['action_type'] === $type['action_type'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($type['action_type']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Date From</label>
                            <input type="date" name="date_from" value="<?php echo htmlspecialchars($_GET['date_from'] ?? ''); ?>">
                        </div>
                        <div class="filter-group">
                            <label>Date To</label>
                            <input type="date" name="date_to" value="<?php echo htmlspecialchars($_GET['date_to'] ?? ''); ?>">
                        </div>
                        <div class="filter-group">
                            <label>Search</label>
                            <input type="text" name="search" placeholder="Search description or IP..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">🔍 Apply Filters</button>
                        <a href="activity_logs.php" class="btn btn-secondary">🔄 Reset</a>
                        <a href="?<?php echo http_build_query(array_merge($_GET, ['export' => 'csv'])); ?>" class="btn btn-success">📥 Export CSV</a>
                    </div>
                </form>
            </div>

            <!-- Logs Table -->
            <div class="logs-table">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Description</th>
                                <th>IP Address</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($logs)): ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 40px; color: #7f8c8d;">
                                        No activity logs found.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($logs as $log): ?>
                                    <tr>
                                        <td style="white-space: nowrap;">
                                            <?php echo date('M d, Y', strtotime($log['created_at'])); ?><br>
                                            <small style="color: #7f8c8d;"><?php echo date('h:i A', strtotime($log['created_at'])); ?></small>
                                        </td>
                                        <td>
                                            <span class="user-badge badge-<?php echo $log['user_type']; ?>">
                                                <?php echo strtoupper($log['user_type']); ?>
                                            </span><br>
                                            <strong><?php echo htmlspecialchars($log['user_name']); ?></strong><br>
                                            <small style="color: #7f8c8d;"><?php echo htmlspecialchars($log['user_email']); ?></small>
                                        </td>
                                        <td>
                                            <span class="action-badge"><?php echo htmlspecialchars($log['action_type']); ?></span>
                                        </td>
                                        <td>
                                            <div class="log-description"><?php echo htmlspecialchars($log['action_description']); ?></div>
                                            <?php if ($log['table_affected']): ?>
                                                <small style="color: #95a5a6;">
                                                    Table: <?php echo htmlspecialchars($log['table_affected']); ?>
                                                    <?php if ($log['record_id']): ?>
                                                        | ID: <?php echo $log['record_id']; ?>
                                                    <?php endif; ?>
                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td style="font-family: monospace; font-size: 0.85rem;">
                                            <?php echo htmlspecialchars($log['ip_address']); ?>
                                        </td>
                                        <td>
                                            <button class="log-details-btn" onclick="showLogDetails(<?php echo htmlspecialchars(json_encode($log)); ?>)">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>" class="page-link">← Previous</a>
                    <?php else: ?>
                        <span class="page-link disabled">← Previous</span>
                    <?php endif; ?>

                    <?php
                    $start_page = max(1, $page - 2);
                    $end_page = min($total_pages, $page + 2);
                    
                    for ($i = $start_page; $i <= $end_page; $i++):
                    ?>
                        <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>" 
                           class="page-link <?php echo $i === $page ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>" class="page-link">Next →</a>
                    <?php else: ?>
                        <span class="page-link disabled">Next →</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Log Details Modal -->
    <div id="logModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>📋 Log Details</h2>
                <button class="modal-close" onclick="closeModal()">×</button>
            </div>
            <div id="modalBody">
                <!-- Content will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        function showLogDetails(log) {
            const modal = document.getElementById('logModal');
            const modalBody = document.getElementById('modalBody');
            
            let html = `
                <div class="detail-row">
                    <strong>Log ID:</strong>
                    <div class="value">#${log.log_id}</div>
                </div>
                <div class="detail-row">
                    <strong>Date & Time:</strong>
                    <div class="value">${new Date(log.created_at).toLocaleString()}</div>
                </div>
                <div class="detail-row">
                    <strong>User Type:</strong>
                    <div class="value">${log.user_type.toUpperCase()}</div>
                </div>
                <div class="detail-row">
                    <strong>User:</strong>
                    <div class="value">${log.user_name} (${log.user_email})</div>
                </div>
                <div class="detail-row">
                    <strong>Action Type:</strong>
                    <div class="value">${log.action_type}</div>
                </div>
                <div class="detail-row">
                    <strong>Description:</strong>
                    <div class="value">${log.action_description}</div>
                </div>
            `;
            
            if (log.table_affected) {
                html += `
                    <div class="detail-row">
                        <strong>Table Affected:</strong>
                        <div class="value">${log.table_affected}</div>
                    </div>
                `;
            }
            
            if (log.record_id) {
                html += `
                    <div class="detail-row">
                        <strong>Record ID:</strong>
                        <div class="value">${log.record_id}</div>
                    </div>
                `;
            }
            
            if (log.old_values) {
                html += `
                    <div class="detail-row">
                        <strong>Old Values:</strong>
                        <div class="json-viewer">${formatJSON(log.old_values)}</div>
                    </div>
                `;
            }
            
            if (log.new_values) {
                html += `
                    <div class="detail-row">
                        <strong>New Values:</strong>
                        <div class="json-viewer">${formatJSON(log.new_values)}</div>
                    </div>
                `;
            }
            
            html += `
                <div class="detail-row">
                    <strong>IP Address:</strong>
                    <div class="value">${log.ip_address}</div>
                </div>
                <div class="detail-row">
                    <strong>User Agent:</strong>
                    <div class="value" style="word-break: break-all; font-size: 0.85rem;">${log.user_agent || 'N/A'}</div>
                </div>
            `;
            
            modalBody.innerHTML = html;
            modal.classList.add('active');
        }
        
        function closeModal() {
            document.getElementById('logModal').classList.remove('active');
        }
        
        function formatJSON(jsonString) {
            try {
                const obj = JSON.parse(jsonString);
                return JSON.stringify(obj, null, 2);
            } catch (e) {
                return jsonString;
            }
        }
        
        // Close modal when clicking outside
        document.getElementById('logModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>