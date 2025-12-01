<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$customer_id = $_SESSION['customer_id'];
$message = '';
$error = '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $date_of_birth = $_POST['date_of_birth'] ?: null;
    
    if (empty($first_name) || empty($last_name)) {
        $error = 'First name and last name are required.';
    } else {
        $conn = getDBConnection();
        
        $stmt = $conn->prepare("SELECT first_name, last_name, phone, date_of_birth FROM customers WHERE customer_id = ?");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $old_data = $stmt->get_result()->fetch_assoc();
        
        $stmt = $conn->prepare("UPDATE customers SET first_name = ?, last_name = ?, phone = ?, date_of_birth = ? WHERE customer_id = ?");
        $stmt->bind_param("ssssi", $first_name, $last_name, $phone, $date_of_birth, $customer_id);
        
        if ($stmt->execute()) {
            $message = 'Profile updated successfully!';
            $_SESSION['first_name'] = $first_name;
            
            logCustomerActivity(
                $customer_id,
                'profile_update',
                "Profile information updated",
                'customers',
                $customer_id,
                $old_data,
                [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'phone' => $phone,
                    'date_of_birth' => $date_of_birth
                ]
            );
        } else {
            $error = 'Failed to update profile.';
        }
        $conn->close();
    }
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = 'All password fields are required.';
    } elseif ($new_password !== $confirm_password) {
        $error = 'New passwords do not match.';
    } elseif (strlen($new_password) < 6) {
        $error = 'New password must be at least 6 characters long.';
    } else {
        $conn = getDBConnection();
        $stmt = $conn->prepare("SELECT password_hash FROM customers WHERE customer_id = ?");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if (password_verify($current_password, $user['password_hash'])) {
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE customers SET password_hash = ? WHERE customer_id = ?");
            $stmt->bind_param("si", $new_hash, $customer_id);
            
            if ($stmt->execute()) {
                $message = 'Password changed successfully!';
                
                logCustomerActivity(
                    $customer_id,
                    'password_change',
                    "Password changed successfully",
                    'customers',
                    $customer_id
                );
            } else {
                $error = 'Failed to change password.';
            }
        } else {
            $error = 'Current password is incorrect.';
        }
        $conn->close();
    }
}

// Handle address operations
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_address'])) {
    $address_type = $_POST['address_type'];
    $street_address = trim($_POST['street_address']);
    $city = trim($_POST['city']);
    $state_province = trim($_POST['state_province']);
    $postal_code = trim($_POST['postal_code']);
    $country = trim($_POST['country']);
    $is_default = isset($_POST['is_default']) ? 1 : 0;
    
    if (empty($street_address) || empty($city) || empty($state_province) || empty($postal_code) || empty($country)) {
        $error = 'All address fields are required.';
    } else {
        $conn = getDBConnection();
        
        // If setting as default, unset other defaults
        if ($is_default) {
            $stmt = $conn->prepare("UPDATE addresses SET is_default = 0 WHERE customer_id = ? AND address_type = ?");
            $stmt->bind_param("is", $customer_id, $address_type);
            $stmt->execute();
        }
        
        $stmt = $conn->prepare("INSERT INTO addresses (customer_id, address_type, is_default, street_address, city, state_province, postal_code, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isisssss", $customer_id, $address_type, $is_default, $street_address, $city, $state_province, $postal_code, $country);
        
        if ($stmt->execute()) {
            $message = 'Address added successfully!';
            $address_id = $conn->insert_id;
            
            logCustomerActivity(
                $customer_id,
                'address_add',
                "New $address_type address added: $city, $state_province",
                'addresses',
                $address_id,
                null,
                [
                    'address_type' => $address_type,
                    'city' => $city,
                    'state_province' => $state_province
                ]
            );
        } else {
            $error = 'Failed to add address.';
        }
        $conn->close();
    }
}

// Delete address
if (isset($_GET['delete_address'])) {
    $address_id = intval($_GET['delete_address']);
    $conn = getDBConnection();
    $stmt = $conn->prepare("DELETE FROM addresses WHERE address_id = ? AND customer_id = ?");
    $stmt->bind_param("ii", $address_id, $customer_id);
    $stmt->execute();
    
    logCustomerActivity(
        $customer_id,
        'address_delete',
        "Address deleted",
        'addresses',
        $address_id
    );
    
    $conn->close();
    header('Location: profile.php?message=Address deleted');
    exit;
}

// Get customer data
$conn = getDBConnection();
$stmt = $conn->prepare("SELECT * FROM customers WHERE customer_id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$customer = $stmt->get_result()->fetch_assoc();

// Get addresses
$stmt = $conn->prepare("SELECT * FROM addresses WHERE customer_id = ? ORDER BY is_default DESC, created_at DESC");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$addresses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$conn->close();

if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="profile-container">
        <h1>My Profile</h1>
        
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="profile-tabs">
            <button class="tab-button active" onclick="showTab('info')">Account Info</button>
            <button class="tab-button" onclick="showTab('password')">Change Password</button>
            <button class="tab-button" onclick="showTab('addresses')">Addresses</button>
        </div>
        
        <!-- Account Info Tab -->
        <div id="info" class="tab-content active">
            <div class="profile-section">
                <h2>Personal Information</h2>
                <div class="info-display">
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?php echo htmlspecialchars($customer['email']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Member Since:</span>
                        <span class="info-value"><?php echo date('F Y', strtotime($customer['created_at'])); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Last Login:</span>
                        <span class="info-value"><?php echo $customer['last_login'] ? date('M d, Y h:i A', strtotime($customer['last_login'])) : 'N/A'; ?></span>
                    </div>
                </div>
                
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name *</label>
                            <input type="text" name="first_name" required value="<?php echo htmlspecialchars($customer['first_name']); ?>">
                        </div>
                        <div class="form-group">
                            <label>Last Name *</label>
                            <input type="text" name="last_name" required value="<?php echo htmlspecialchars($customer['last_name']); ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="tel" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>">
                        </div>
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($customer['date_of_birth']); ?>">
                        </div>
                    </div>
                    
                    <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
        
        <!-- Change Password Tab -->
        <div id="password" class="tab-content">
            <div class="profile-section">
                <h2>Change Password</h2>
                <form method="POST">
                    <div class="form-group">
                        <label>Current Password *</label>
                        <input type="password" name="current_password" required>
                    </div>
                    
                    <div class="form-group">
                        <label>New Password *</label>
                        <input type="password" name="new_password" required>
                        <small>Must be at least 6 characters long</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Confirm New Password *</label>
                        <input type="password" name="confirm_password" required>
                    </div>
                    
                    <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>
        
        <!-- Addresses Tab -->
        <div id="addresses" class="tab-content">
            <div class="profile-section">
                <h2>My Addresses</h2>
                
                <div class="addresses-grid">
                    <?php foreach ($addresses as $address): ?>
                        <div class="address-card <?php echo $address['is_default'] ? 'default' : ''; ?>">
                            <?php if ($address['is_default']): ?>
                                <span class="address-badge">Default</span>
                            <?php endif; ?>
                            
                            <div class="address-type"><?php echo htmlspecialchars($address['address_type']); ?> Address</div>
                            <p>
                                <?php echo htmlspecialchars($address['street_address']); ?><br>
                                <?php echo htmlspecialchars($address['city']); ?>, <?php echo htmlspecialchars($address['state_province']); ?><br>
                                <?php echo htmlspecialchars($address['postal_code']); ?><br>
                                <?php echo htmlspecialchars($address['country']); ?>
                            </p>
                            
                            <div class="address-actions">
                                <a href="?delete_address=<?php echo $address['address_id']; ?>" 
                                   class="btn-remove" 
                                   onclick="return confirm('Delete this address?')"
                                   style="padding: 8px 15px; text-decoration: none;">Delete</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div style="margin-top: 30px;">
                    <h3>Add New Address</h3>
                    <form method="POST">
                        <div class="form-group">
                            <label>Address Type *</label>
                            <select name="address_type" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                                <option value="billing">Billing</option>
                                <option value="shipping">Shipping</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Street Address *</label>
                            <input type="text" name="street_address" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>City *</label>
                                <input type="text" name="city" required>
                            </div>
                            <div class="form-group">
                                <label>State/Province *</label>
                                <input type="text" name="state_province" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Postal Code *</label>
                                <input type="text" name="postal_code" required>
                            </div>
                            <div class="form-group">
                                <label>Country *</label>
                                <input type="text" name="country" required value="Philippines">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label style="display: flex; align-items: center; gap: 10px;">
                                <input type="checkbox" name="is_default" style="width: auto;">
                                Set as default address
                            </label>
                        </div>
                        
                        <button type="submit" name="add_address" class="btn btn-primary">Add Address</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function showTab(tabName) {
            // Hide all tabs
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.remove('active'));
            
            // Remove active from all buttons
            const buttons = document.querySelectorAll('.tab-button');
            buttons.forEach(btn => btn.classList.remove('active'));
            
            // Show selected tab
            document.getElementById(tabName).classList.add('active');
            event.target.classList.add('active');
        }
    </script>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>