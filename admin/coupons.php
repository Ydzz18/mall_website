<?php
require_once '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

if (!hasAdminPermission(RoleManager::PERMISSION_MANAGE_COUPONS)) {
    header('Location: index.php');
    exit;
}

$conn = getDBConnection();
$message = '';

// Handle coupon add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coupon_code = strtoupper(trim($_POST['coupon_code']));
    $description = trim($_POST['description']);
    $discount_type = $_POST['discount_type'];
    $discount_value = floatval($_POST['discount_value']);
    $min_purchase = !empty($_POST['min_purchase_amount']) ? floatval($_POST['min_purchase_amount']) : null;
    $max_discount = !empty($_POST['max_discount_amount']) ? floatval($_POST['max_discount_amount']) : null;
    $usage_limit = !empty($_POST['usage_limit']) ? intval($_POST['usage_limit']) : null;
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    if (isset($_POST['coupon_id']) && !empty($_POST['coupon_id'])) {
        // Update existing coupon
        $coupon_id = intval($_POST['coupon_id']);
        $stmt = $conn->prepare("UPDATE coupons SET coupon_code=?, description=?, discount_type=?, discount_value=?, min_purchase_amount=?, max_discount_amount=?, usage_limit=?, start_date=?, end_date=?, is_active=? WHERE coupon_id=?");
        $stmt->bind_param("sssdddiisii", $coupon_code, $description, $discount_type, $discount_value, $min_purchase, $max_discount, $usage_limit, $start_date, $end_date, $is_active, $coupon_id);
        if ($stmt->execute()) {
            $message = 'Coupon updated successfully!';
        }
    } else {
        // Add new coupon
        $stmt = $conn->prepare("INSERT INTO coupons (coupon_code, description, discount_type, discount_value, min_purchase_amount, max_discount_amount, usage_limit, start_date, end_date, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdddissi", $coupon_code, $description, $discount_type, $discount_value, $min_purchase, $max_discount, $usage_limit, $start_date, $end_date, $is_active);
        if ($stmt->execute()) {
            $message = 'Coupon added successfully!';
        }
    }
}

// Handle coupon deletion
if (isset($_GET['delete'])) {
    $coupon_id = intval($_GET['delete']);
    $conn->query("DELETE FROM coupons WHERE coupon_id = $coupon_id");
    $message = 'Coupon deleted successfully!';
}

// Get all coupons
$coupons = $conn->query("
    SELECT c.*,
           COUNT(oc.order_coupon_id) as times_used,
           SUM(oc.discount_applied) as total_discount
    FROM coupons c
    LEFT JOIN order_coupons oc ON c.coupon_id = oc.coupon_id
    GROUP BY c.coupon_id
    ORDER BY c.created_at DESC
")->fetch_all(MYSQLI_ASSOC);

// Get coupon for editing
$edit_coupon = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM coupons WHERE coupon_id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $edit_coupon = $stmt->get_result()->fetch_assoc();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coupons Management - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../logo/icon.png">
    <style>
        <?php include 'admin-styles.css'; ?>
        
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
        
        .modal.active { display: flex; }
        
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
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
        }
        
        .coupon-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: bold;
            font-family: monospace;
            font-size: 1.1rem;
        }
        
        .coupon-status {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .coupon-status.active { background: #d4edda; color: #155724; }
        .coupon-status.inactive { background: #f8d7da; color: #721c24; }
        .coupon-status.expired { background: #e2e3e5; color: #383d41; }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>
        
        <main class="admin-main">
            <header class="admin-header">
                <h1>Coupons Management</h1>
                <button onclick="openModal()" class="btn-admin btn-success">+ Add New Coupon</button>
            </header>
            
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <div class="content-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Coupon Code</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Discount</th>
                            <th>Min Purchase</th>
                            <th>Usage</th>
                            <th>Valid Period</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($coupons as $coupon): 
                            $now = date('Y-m-d');
                            $status = !$coupon['is_active'] ? 'inactive' : 
                                     ($now > $coupon['end_date'] ? 'expired' : 'active');
                            $status_text = !$coupon['is_active'] ? 'Inactive' : 
                                          ($now > $coupon['end_date'] ? 'Expired' : 'Active');
                        ?>
                            <tr>
                                <td>
                                    <span class="coupon-badge"><?php echo htmlspecialchars($coupon['coupon_code']); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($coupon['description']); ?></td>
                                <td><?php echo ucfirst(str_replace('_', ' ', $coupon['discount_type'])); ?></td>
                                <td>
                                    <strong>
                                        <?php 
                                        if ($coupon['discount_type'] === 'percentage') {
                                            echo $coupon['discount_value'] . '%';
                                        } else {
                                            echo '$' . number_format($coupon['discount_value'], 2);
                                        }
                                        ?>
                                    </strong>
                                </td>
                                <td>
                                    <?php echo $coupon['min_purchase_amount'] ? '$' . number_format($coupon['min_purchase_amount'], 2) : '-'; ?>
                                </td>
                                <td>
                                    <?php echo $coupon['times_used']; ?> / 
                                    <?php echo $coupon['usage_limit'] ?: '∞'; ?>
                                    <br>
                                    <small style="color: #27ae60;">
                                        Saved: <?php echo formatCurrency($coupon['total_discount'] ?: 0); ?>
                                    </small>
                                </td>
                                <td>
                                    <?php echo date('M d, Y', strtotime($coupon['start_date'])); ?><br>
                                    <small>to <?php echo date('M d, Y', strtotime($coupon['end_date'])); ?></small>
                                </td>
                                <td>
                                    <span class="coupon-status <?php echo $status; ?>">
                                        <?php echo $status_text; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="?edit=<?php echo $coupon['coupon_id']; ?>" class="btn-admin btn-primary" style="margin-right: 5px;">Edit</a>
                                    <a href="?delete=<?php echo $coupon['coupon_id']; ?>" 
                                       class="btn-admin btn-danger"
                                       onclick="return confirm('Delete this coupon?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <!-- Add/Edit Coupon Modal -->
    <div id="couponModal" class="modal <?php echo $edit_coupon ? 'active' : ''; ?>">
        <div class="modal-content">
            <div class="modal-header">
                <h2><?php echo $edit_coupon ? 'Edit Coupon' : 'Add New Coupon'; ?></h2>
                <span class="close-modal" onclick="closeModal()">&times;</span>
            </div>
            
            <form method="POST">
                <?php if ($edit_coupon): ?>
                    <input type="hidden" name="coupon_id" value="<?php echo $edit_coupon['coupon_id']; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label>Coupon Code *</label>
                    <input type="text" name="coupon_code" required 
                           value="<?php echo $edit_coupon ? htmlspecialchars($edit_coupon['coupon_code']) : ''; ?>"
                           style="text-transform: uppercase;">
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="2"><?php echo $edit_coupon ? htmlspecialchars($edit_coupon['description']) : ''; ?></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Discount Type *</label>
                        <select name="discount_type" required>
                            <option value="percentage" <?php echo ($edit_coupon && $edit_coupon['discount_type'] === 'percentage') ? 'selected' : ''; ?>>Percentage</option>
                            <option value="fixed_amount" <?php echo ($edit_coupon && $edit_coupon['discount_type'] === 'fixed_amount') ? 'selected' : ''; ?>>Fixed Amount</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Discount Value *</label>
                        <input type="number" step="0.01" name="discount_value" required 
                               value="<?php echo $edit_coupon ? $edit_coupon['discount_value'] : ''; ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Min Purchase Amount</label>
                        <input type="number" step="0.01" name="min_purchase_amount" 
                               value="<?php echo $edit_coupon ? $edit_coupon['min_purchase_amount'] : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Max Discount Amount</label>
                        <input type="number" step="0.01" name="max_discount_amount" 
                               value="<?php echo $edit_coupon ? $edit_coupon['max_discount_amount'] : ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Usage Limit (leave empty for unlimited)</label>
                    <input type="number" name="usage_limit" 
                           value="<?php echo $edit_coupon ? $edit_coupon['usage_limit'] : ''; ?>">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Start Date *</label>
                        <input type="date" name="start_date" required 
                               value="<?php echo $edit_coupon ? $edit_coupon['start_date'] : date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>End Date *</label>
                        <input type="date" name="end_date" required 
                               value="<?php echo $edit_coupon ? $edit_coupon['end_date'] : ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" name="is_active" style="width: auto;"
                               <?php echo (!$edit_coupon || $edit_coupon['is_active']) ? 'checked' : ''; ?>>
                        Active
                    </label>
                </div>
                
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn-admin btn-success" style="flex: 1;">
                        <?php echo $edit_coupon ? 'Update Coupon' : 'Add Coupon'; ?>
                    </button>
                    <button type="button" onclick="closeModal()" class="btn-admin btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function openModal() {
            document.getElementById('couponModal').classList.add('active');
        }
        
        function closeModal() {
            document.getElementById('couponModal').classList.remove('active');
            if (!<?php echo $edit_coupon ? 'true' : 'false'; ?>) {
                window.location.href = 'coupons.php';
            }
        }
        
        document.getElementById('couponModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
</body>
</html>