<?php
// admin/super_admin.php
require_once '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

if (!hasAdminPermission(RoleManager::PERMISSION_MANAGE_ADMINS)) {
    header('Location: index.php');
    exit;
}

$conn = getDBConnection();

// Get current admin
$stmt = $conn->prepare("SELECT role FROM admin_users WHERE admin_id = ?");
$stmt->bind_param("i", $_SESSION['admin_id']);
$stmt->execute();
$current_admin = $stmt->get_result()->fetch_assoc();

$message = '';
$error = '';

// Add role column if not exists
$conn->query("ALTER TABLE admin_users ADD COLUMN IF NOT EXISTS role VARCHAR(50) DEFAULT 'admin'");

// Update existing admin to super_admin if none exists
$result = $conn->query("SELECT COUNT(*) as count FROM admin_users WHERE role = 'super_admin'");
if ($result->fetch_assoc()['count'] == 0) {
    $conn->query("UPDATE admin_users SET role = 'super_admin' WHERE admin_id = {$_SESSION['admin_id']} LIMIT 1");
}

// Handle admin creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_admin'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    if (!canCreateAdminRole($role)) {
        $error = 'You do not have permission to create this role.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO admin_users (username, email, full_name, password_hash, role, is_active) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("sssss", $username, $email, $full_name, $password_hash, $role);
        
        if ($stmt->execute()) {
            $new_admin_id = $conn->insert_id;
            
            logAdminActivity(
                $_SESSION['admin_id'],
                'admin_create',
                "New admin created: $full_name ($username) - Role: $role",
                'admin_users',
                $new_admin_id,
                null,
                ['username' => $username, 'role' => $role]
            );
            
            $message = 'Admin user created successfully!';
        } else {
            $error = 'Error creating admin user. Username or email may already exist.';
        }
    }
}

// Handle admin update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_admin'])) {
    $admin_id = intval($_POST['admin_id']);
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    $role = $_POST['role'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Get old values for logging
    $stmt = $conn->prepare("SELECT username, email, full_name, role, is_active FROM admin_users WHERE admin_id = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $old_admin = $stmt->get_result()->fetch_assoc();
    
    // Don't allow changing own role or deactivating self
    if ($admin_id == $_SESSION['admin_id']) {
        $role = 'super_admin';
        $is_active = 1;
    }
    
    $stmt = $conn->prepare("UPDATE admin_users SET email=?, full_name=?, role=?, is_active=? WHERE admin_id=?");
    $stmt->bind_param("sssii", $email, $full_name, $role, $is_active, $admin_id);
    
    if ($stmt->execute()) {
        logAdminActivity(
            $_SESSION['admin_id'],
            'admin_update',
            "Admin updated: {$old_admin['username']} - Changes: role {$old_admin['role']} → $role",
            'admin_users',
            $admin_id,
            ['role' => $old_admin['role'], 'is_active' => $old_admin['is_active']],
            ['role' => $role, 'is_active' => $is_active]
        );
        
        $message = 'Admin user updated successfully!';
    } else {
        $error = 'Error updating admin user.';
    }
}

// Handle password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $admin_id = intval($_POST['admin_id']);
    $new_password = $_POST['new_password'];
    
    if (strlen($new_password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } else {
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("SELECT username FROM admin_users WHERE admin_id = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $admin_data = $stmt->get_result()->fetch_assoc();
        
        $stmt = $conn->prepare("UPDATE admin_users SET password_hash=? WHERE admin_id=?");
        $stmt->bind_param("si", $password_hash, $admin_id);
        
        if ($stmt->execute()) {
            logAdminActivity(
                $_SESSION['admin_id'],
                'admin_password_reset',
                "Password reset for admin: {$admin_data['username']}",
                'admin_users',
                $admin_id
            );
            
            $message = 'Password reset successfully!';
        } else {
            $error = 'Error resetting password.';
        }
    }
}

// Handle admin deletion
if (isset($_GET['delete'])) {
    $admin_id = intval($_GET['delete']);
    
    // Don't allow deleting self
    if ($admin_id != $_SESSION['admin_id']) {
        $stmt = $conn->prepare("SELECT username, full_name FROM admin_users WHERE admin_id = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $deleted_admin = $stmt->get_result()->fetch_assoc();
        
        $stmt = $conn->prepare("DELETE FROM admin_users WHERE admin_id = ?");
        $stmt->bind_param("i", $admin_id);
        
        if ($stmt->execute()) {
            logAdminActivity(
                $_SESSION['admin_id'],
                'admin_delete',
                "Admin deleted: {$deleted_admin['full_name']} ({$deleted_admin['username']})",
                'admin_users',
                $admin_id,
                ['username' => $deleted_admin['username'], 'full_name' => $deleted_admin['full_name']]
            );
            
            $message = 'Admin user deleted successfully!';
        } else {
            $error = 'Error deleting admin user.';
        }
    } else {
        $error = 'You cannot delete your own account!';
    }
}

// Get all admins
$admins = $conn->query("
    SELECT a.*, 
           COUNT(DISTINCT al.log_id) as total_actions,
           MAX(al.created_at) as last_activity
    FROM admin_users a
    LEFT JOIN activity_logs al ON a.admin_id = al.admin_id
    GROUP BY a.admin_id
    ORDER BY a.created_at DESC
")->fetch_all(MYSQLI_ASSOC);

// Get statistics
$stats = $conn->query("
    SELECT 
        COUNT(*) as total_admins,
        SUM(CASE WHEN role = 'super_admin' THEN 1 ELSE 0 END) as super_admins,
        SUM(CASE WHEN role = 'admin' THEN 1 ELSE 0 END) as regular_admins,
        SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active_admins,
        SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) as inactive_admins
    FROM admin_users
")->fetch_assoc();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Management - Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../logo/icon.png">
    <style>
        <?php include 'admin-styles.css'; ?>
        
        .super-admin-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            margin-left: 10px;
        }
        
        .admin-badge {
            background: #3498db;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            margin-left: 10px;
        }
        
        .moderator-badge {
            background: #27ae60;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            margin-left: 10px;
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
            border-radius: 15px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .close-modal {
            font-size: 2rem;
            cursor: pointer;
            color: #7f8c8d;
            background: none;
            border: none;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
        }
        
        .form-group input[type="checkbox"] {
            width: auto;
            margin-right: 10px;
        }
        
        .checkbox-label {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .activity-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .activity-indicator.active {
            background: #27ae60;
            box-shadow: 0 0 5px #27ae60;
        }
        
        .activity-indicator.inactive {
            background: #e74c3c;
        }
        
        .admin-stats {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        
        .admin-stat {
            background: rgba(52, 152, 219, 0.1);
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 0.9rem;
        }
        
        .admin-stat strong {
            color: #2c3e50;
            margin-left: 5px;
        }
        
        .role-select-highlight {
            border: 2px solid #667eea !important;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
        }
        
        .warning-box {
            background: #fff3cd;
            border: 2px solid #ffc107;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .warning-box h4 {
            color: #856404;
            margin-bottom: 10px;
        }
        
        .warning-box ul {
            margin-left: 20px;
            color: #856404;
            line-height: 1.8;
        }
        
        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>
        
        <main class="admin-main">
            <header class="admin-header">
                <div>
                    <h1>👑 Super Admin Management</h1>
                    <p style="color: #7f8c8d; font-size: 0.9rem; margin-top: 5px;">
                        Manage admin users and permissions
                    </p>
                </div>
                <button onclick="openCreateModal()" class="btn-admin btn-success">
                    + Create New Admin
                </button>
            </header>
            
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card blue">
                    <div class="stat-header">
                        <span class="stat-title">Total Admins</span>
                        <span class="stat-icon">👥</span>
                    </div>
                    <div class="stat-value"><?php echo number_format($stats['total_admins']); ?></div>
                </div>
                
                <div class="stat-card purple">
                    <div class="stat-header">
                        <span class="stat-title">Super Admins</span>
                        <span class="stat-icon">👑</span>
                    </div>
                    <div class="stat-value"><?php echo number_format($stats['super_admins']); ?></div>
                </div>
                
                <div class="stat-card green">
                    <div class="stat-header">
                        <span class="stat-title">Regular Admins</span>
                        <span class="stat-icon">🔧</span>
                    </div>
                    <div class="stat-value"><?php echo number_format($stats['regular_admins']); ?></div>
                </div>
                
                <div class="stat-card orange">
                    <div class="stat-header">
                        <span class="stat-title">Active / Inactive</span>
                        <span class="stat-icon">📊</span>
                    </div>
                    <div class="stat-value" style="font-size: 1.5rem;">
                        <?php echo $stats['active_admins']; ?> / <?php echo $stats['inactive_admins']; ?>
                    </div>
                </div>
            </div>
            
            <!-- Admins Table -->
            <div class="content-card">
                <h2>All Admin Users (<?php echo count($admins); ?>)</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Admin</th>
                            <th>Role</th>
                            <th>Activity</th>
                            <th>Created</th>
                            <th>Last Login</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($admins as $admin): ?>
                            <tr>
                                <td>
                                    <span class="activity-indicator <?php echo $admin['is_active'] ? 'active' : 'inactive'; ?>" 
                                          title="<?php echo $admin['is_active'] ? 'Active' : 'Inactive'; ?>">
                                    </span>
                                </td>
                                <td>
                                    <strong style="font-size: 1.05rem;">
                                        <?php echo htmlspecialchars($admin['full_name']); ?>
                                        <?php if ($admin['admin_id'] == $_SESSION['admin_id']): ?>
                                            <span style="color: #3498db; font-size: 0.8rem;">(You)</span>
                                        <?php endif; ?>
                                    </strong><br>
                                    <span style="color: #7f8c8d; font-size: 0.9rem;">
                                        👤 <?php echo htmlspecialchars($admin['username']); ?>
                                    </span><br>
                                    <span style="color: #95a5a6; font-size: 0.85rem;">
                                        📧 <?php echo htmlspecialchars($admin['email']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($admin['role'] === RoleManager::ROLE_SUPER_ADMIN): ?>
                                        <span class="super-admin-badge">👑 SUPER ADMIN</span>
                                    <?php elseif ($admin['role'] === RoleManager::ROLE_ADMIN): ?>
                                        <span class="admin-badge">🔧 ADMIN</span>
                                    <?php elseif ($admin['role'] === RoleManager::ROLE_MODERATOR): ?>
                                        <span class="moderator-badge">🛡️ MODERATOR</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="admin-stats">
                                        <div class="admin-stat">
                                            📊 <strong><?php echo number_format($admin['total_actions']); ?></strong> actions
                                        </div>
                                        <?php if ($admin['last_activity']): ?>
                                            <div class="admin-stat">
                                                🕐 Last: <?php echo date('M d, Y', strtotime($admin['last_activity'])); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php echo date('M d, Y', strtotime($admin['created_at'])); ?><br>
                                    <small style="color: #7f8c8d;">
                                        <?php echo date('h:i A', strtotime($admin['created_at'])); ?>
                                    </small>
                                </td>
                                <td>
                                    <?php if ($admin['last_login']): ?>
                                        <?php echo date('M d, Y', strtotime($admin['last_login'])); ?><br>
                                        <small style="color: #7f8c8d;">
                                            <?php echo date('h:i A', strtotime($admin['last_login'])); ?>
                                        </small>
                                    <?php else: ?>
                                        <span style="color: #95a5a6;">Never</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($admin['admin_id'] != $_SESSION['admin_id']): ?>
                                        <button onclick="editAdmin(<?php echo htmlspecialchars(json_encode($admin)); ?>)" 
                                                class="btn-admin btn-primary" style="margin-right: 5px; margin-bottom: 5px;">
                                            Edit
                                        </button>
                                        <button onclick="resetPassword(<?php echo $admin['admin_id']; ?>, '<?php echo htmlspecialchars($admin['username']); ?>')" 
                                                class="btn-admin btn-secondary" style="margin-right: 5px; margin-bottom: 5px;">
                                            Reset Password
                                        </button>
                                        <a href="?delete=<?php echo $admin['admin_id']; ?>" 
                                           class="btn-admin btn-danger"
                                           onclick="return confirm('Delete admin: <?php echo htmlspecialchars($admin['full_name']); ?>?')">
                                            Delete
                                        </a>
                                    <?php else: ?>
                                        <button onclick="editAdmin(<?php echo htmlspecialchars(json_encode($admin)); ?>)" 
                                                class="btn-admin btn-primary">
                                            Edit Profile
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <!-- Create Admin Modal -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create New Admin</h2>
                <button class="close-modal" onclick="closeCreateModal()">&times;</button>
            </div>
            
            <div class="warning-box">
                <h4>⚠️ Role Permissions</h4>
                <ul>
                    <li><strong>Super Admin:</strong> Full system access, can manage other admins and moderators</li>
                    <li><strong>Admin:</strong> Can manage products, orders, customers, and create moderators</li>
                    <li><strong>Moderator:</strong> Limited access - can view orders, manage reviews, and manage customers</li>
                </ul>
            </div>
            
            <form method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label>Username *</label>
                        <input type="text" name="username" required placeholder="admin123">
                    </div>
                    
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" required placeholder="admin@example.com">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" required placeholder="John Doe">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Password *</label>
                        <input type="password" name="password" required minlength="6" placeholder="Min 6 characters">
                    </div>
                    
                    <div class="form-group">
                        <label>Role *</label>
                        <select name="role" required class="role-select-highlight">
                            <?php if ($current_admin['role'] === RoleManager::ROLE_SUPER_ADMIN): ?>
                                <option value="<?php echo RoleManager::ROLE_ADMIN; ?>">🔧 Admin</option>
                                <option value="<?php echo RoleManager::ROLE_MODERATOR; ?>">🛡️ Moderator</option>
                            <?php elseif ($current_admin['role'] === RoleManager::ROLE_ADMIN): ?>
                                <option value="<?php echo RoleManager::ROLE_MODERATOR; ?>">🛡️ Moderator</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" name="create_admin" class="btn-admin btn-success" style="flex: 1;">
                        Create Admin
                    </button>
                    <button type="button" onclick="closeCreateModal()" class="btn-admin btn-secondary">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Edit Admin Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="editModalTitle">Edit Admin</h2>
                <button class="close-modal" onclick="closeEditModal()">&times;</button>
            </div>
            
            <form method="POST" id="editForm">
                <input type="hidden" name="admin_id" id="edit_admin_id">
                
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" id="edit_username" disabled style="background: #f5f5f5;">
                </div>
                
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" id="edit_email" required>
                </div>
                
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" id="edit_full_name" required>
                </div>
                
                <div class="form-group">
                    <label>Role *</label>
                    <select name="role" id="edit_role" required class="role-select-highlight">
                        <option value="admin">🔧 Admin</option>
                        <option value="super_admin">👑 Super Admin</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="is_active" id="edit_is_active">
                        Active Account
                    </label>
                </div>
                
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" name="update_admin" class="btn-admin btn-success" style="flex: 1;">
                        Update Admin
                    </button>
                    <button type="button" onclick="closeEditModal()" class="btn-admin btn-secondary">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Reset Password Modal -->
    <div id="passwordModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Reset Password</h2>
                <button class="close-modal" onclick="closePasswordModal()">&times;</button>
            </div>
            
            <p style="margin-bottom: 20px; color: #7f8c8d;">
                Reset password for: <strong id="reset_username"></strong>
            </p>
            
            <form method="POST" id="passwordForm">
                <input type="hidden" name="admin_id" id="reset_admin_id">
                
                <div class="form-group">
                    <label>New Password *</label>
                    <input type="password" name="new_password" required minlength="6" 
                           placeholder="Minimum 6 characters">
                </div>
                
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" name="reset_password" class="btn-admin btn-primary" style="flex: 1;">
                        Reset Password
                    </button>
                    <button type="button" onclick="closePasswordModal()" class="btn-admin btn-secondary">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function openCreateModal() {
            document.getElementById('createModal').classList.add('active');
        }
        
        function closeCreateModal() {
            document.getElementById('createModal').classList.remove('active');
        }
        
        function editAdmin(admin) {
            document.getElementById('editModalTitle').textContent = 
                admin.admin_id == <?php echo $_SESSION['admin_id']; ?> ? 'Edit Your Profile' : 'Edit Admin';
            
            document.getElementById('edit_admin_id').value = admin.admin_id;
            document.getElementById('edit_username').value = admin.username;
            document.getElementById('edit_email').value = admin.email;
            document.getElementById('edit_full_name').value = admin.full_name;
            document.getElementById('edit_role').value = admin.role;
            document.getElementById('edit_is_active').checked = admin.is_active == 1;
            
            // Disable role and active changes for own account
            if (admin.admin_id == <?php echo $_SESSION['admin_id']; ?>) {
                document.getElementById('edit_role').disabled = true;
                document.getElementById('edit_is_active').disabled = true;
            } else {
                document.getElementById('edit_role').disabled = false;
                document.getElementById('edit_is_active').disabled = false;
            }
            
            document.getElementById('editModal').classList.add('active');
        }
        
        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
        }
        
        function resetPassword(adminId, username) {
            document.getElementById('reset_admin_id').value = adminId;
            document.getElementById('reset_username').textContent = username;
            document.getElementById('passwordModal').classList.add('active');
        }
        
        function closePasswordModal() {
            document.getElementById('passwordModal').classList.remove('active');
            document.getElementById('passwordForm').reset();
        }
        
        // Close modals on outside click
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>