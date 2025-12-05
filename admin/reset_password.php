<?php
session_start();
require_once '../config.php';

$message = '';
$error = '';
$step = 1; // Step 1: Request reset, Step 2: Verify token, Step 3: Set new password

$conn = getDBConnection();

// Handle password reset request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_reset'])) {
    $email = trim($_POST['email']);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if admin exists
        $stmt = $conn->prepare("SELECT admin_id, email, full_name FROM admin_users WHERE email = ? AND is_active = 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            
            // Generate reset token
            $reset_token = bin2hex(random_bytes(32));
            $token_expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Store token in database
            $stmt = $conn->prepare("UPDATE admin_users SET reset_token = ?, reset_token_expiry = ? WHERE admin_id = ?");
            $stmt->bind_param("ssi", $reset_token, $token_expiry, $admin['admin_id']);
            $stmt->execute();
            
            // Send email with reset link
            if (ENABLE_EMAIL_NOTIFICATIONS && GMAIL_SENDER_EMAIL !== 'your-email@gmail.com') {
                require_once '../includes/email.php';
                
                try {
                    $mail = getMailer();
                    if ($mail) {
                        $reset_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/reset_password.php?token=" . $reset_token;
                        
                        $mail->addAddress($email);
                        $mail->Subject = 'Admin Password Reset Request - ' . SITE_NAME;
                        $mail->Body = "
                        <html>
                        <body style='font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4;'>
                            <div style='max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px;'>
                                <h2 style='color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px;'>
                                    🔒 Password Reset Request
                                </h2>
                                
                                <p>Hello <strong>{$admin['full_name']}</strong>,</p>
                                
                                <p>We received a request to reset your admin password for <strong>" . SITE_NAME . "</strong>.</p>
                                
                                <div style='background: #e8f5e9; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                                    <p style='margin: 0; font-size: 14px;'>Click the button below to reset your password:</p>
                                    <div style='text-align: center; margin: 20px 0;'>
                                        <a href='$reset_link' style='display: inline-block; padding: 15px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: bold;'>
                                            Reset Password
                                        </a>
                                    </div>
                                    <p style='margin: 0; font-size: 12px; color: #666;'>Or copy and paste this link:</p>
                                    <p style='margin: 5px 0 0 0; font-size: 11px; word-break: break-all; color: #3498db;'>$reset_link</p>
                                </div>
                                
                                <div style='background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107; margin: 20px 0;'>
                                    <p style='margin: 0; font-size: 14px;'><strong>⚠️ Important Security Notes:</strong></p>
                                    <ul style='margin: 10px 0 0 20px; font-size: 13px;'>
                                        <li>This link will expire in <strong>1 hour</strong></li>
                                        <li>If you didn't request this reset, please ignore this email</li>
                                        <li>Never share this link with anyone</li>
                                    </ul>
                                </div>
                                
                                <p style='font-size: 12px; color: #7f8c8d; margin-top: 30px; border-top: 1px solid #e0e0e0; padding-top: 15px;'>
                                    This email was sent from " . SITE_NAME . " Admin Panel<br>
                                    If you have any concerns, please contact the system administrator.
                                </p>
                            </div>
                        </body>
                        </html>
                        ";
                        
                        $mail->AltBody = "Password reset requested for " . SITE_NAME . " admin panel. Visit: $reset_link (expires in 1 hour)";
                        
                        if ($mail->send()) {
                            $message = "✅ Password reset instructions have been sent to your email address. Please check your inbox.";
                            $step = 1;
                        } else {
                            $error = "Failed to send reset email. Please contact the system administrator.";
                        }
                    } else {
                        $error = "Email system not configured. Please contact the system administrator.";
                    }
                } catch (Exception $e) {
                    $error = "Email error: " . $e->getMessage();
                }
            } else {
                // If email is not configured, show token directly (for development)
                $message = "Email not configured. Reset token: <strong>$reset_token</strong><br>";
                $message .= "Use this link: <a href='reset_password.php?token=$reset_token'>Reset Password</a>";
            }
            
            // Log activity
            logAdminActivity(
                $admin['admin_id'],
                'password_reset_requested',
                "Password reset requested for admin: {$admin['full_name']}",
                'admin_users',
                $admin['admin_id']
            );
        } else {
            // Don't reveal if email exists or not (security)
            $message = "✅ If an account exists with this email, password reset instructions have been sent.";
        }
    } else {
        $error = "Please enter a valid email address.";
    }
}

// Handle token verification and password reset
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Verify token
    $stmt = $conn->prepare("
        SELECT admin_id, email, full_name, reset_token_expiry 
        FROM admin_users 
        WHERE reset_token = ? AND is_active = 1
    ");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        
        // Check if token is expired
        if (strtotime($admin['reset_token_expiry']) > time()) {
            $step = 3; // Show password reset form
            
            // Handle new password submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];
                
                // Validation
                if (strlen($new_password) < 6) {
                    $error = "Password must be at least 6 characters long.";
                } elseif ($new_password !== $confirm_password) {
                    $error = "Passwords do not match.";
                } else {
                    // Update password
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("
                        UPDATE admin_users 
                        SET password_hash = ?, reset_token = NULL, reset_token_expiry = NULL 
                        WHERE admin_id = ?
                    ");
                    $stmt->bind_param("si", $password_hash, $admin['admin_id']);
                    
                    if ($stmt->execute()) {
                        // Log activity
                        logAdminActivity(
                            $admin['admin_id'],
                            'password_reset_completed',
                            "Password was reset for admin: {$admin['full_name']}",
                            'admin_users',
                            $admin['admin_id']
                        );
                        
                        $message = "✅ Password reset successful! You can now login with your new password.";
                        $step = 4; // Success page
                    } else {
                        $error = "Failed to reset password. Please try again.";
                    }
                }
            }
        } else {
            $error = "This reset link has expired. Please request a new password reset.";
            $step = 1;
        }
    } else {
        $error = "Invalid or expired reset link. Please request a new password reset.";
        $step = 1;
    }
}

// Add reset_token columns if they don't exist
$conn->query("
    ALTER TABLE admin_users 
    ADD COLUMN IF NOT EXISTS reset_token VARCHAR(64) DEFAULT NULL,
    ADD COLUMN IF NOT EXISTS reset_token_expiry DATETIME DEFAULT NULL
");

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Password Reset - <?php echo SITE_NAME; ?></title>
    <link rel="icon" type="image/png" href="../logo/icon.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .reset-container {
            background: white;
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 500px;
            width: 100%;
        }
        
        .reset-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .reset-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }
        
        .reset-header h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 1.8rem;
        }
        
        .reset-header p {
            color: #7f8c8d;
            font-size: 0.9rem;
            line-height: 1.6;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
        }
        
        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left-color: #28a745;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left-color: #dc3545;
        }
        
        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-left-color: #17a2b8;
        }
        
        .btn-reset {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn-reset:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .back-link a:hover {
            text-decoration: underline;
        }
        
        .password-requirements {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.85rem;
            color: #666;
        }
        
        .password-requirements ul {
            margin: 10px 0 0 20px;
        }
        
        .password-requirements li {
            margin: 5px 0;
        }
        
        .success-box {
            background: #d4edda;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #28a745;
        }
        
        .success-box h2 {
            color: #155724;
            margin-bottom: 15px;
        }
        
        .success-box p {
            color: #155724;
            margin-bottom: 20px;
        }
        
        .btn-login {
            display: inline-block;
            padding: 12px 30px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        
        @media (max-width: 640px) {
            .reset-container {
                padding: 30px 20px;
            }
            
            .reset-header h1 {
                font-size: 1.5rem;
            }
            
            .reset-icon {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <?php if ($step === 1): ?>
            <!-- Step 1: Request Reset -->
            <div class="reset-header">
                <div class="reset-icon">🔐</div>
                <h1>Reset Admin Password</h1>
                <p>Enter your email address and we'll send you instructions to reset your password.</p>
            </div>
            
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" 
                           name="email" 
                           required 
                           autofocus 
                           placeholder="admin@example.com"
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>
                
                <button type="submit" name="request_reset" class="btn-reset">
                    📧 Send Reset Instructions
                </button>
            </form>
            
            <div class="back-link">
                <a href="login.php">← Back to Login</a>
            </div>
            
        <?php elseif ($step === 3): ?>
            <!-- Step 3: Set New Password -->
            <div class="reset-header">
                <div class="reset-icon">🔑</div>
                <h1>Set New Password</h1>
                <p>Create a strong password for your admin account.</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <div class="password-requirements">
                <strong>Password Requirements:</strong>
                <ul>
                    <li>Minimum 6 characters (8+ recommended)</li>
                    <li>Use a mix of letters, numbers, and symbols</li>
                    <li>Avoid common words or patterns</li>
                    <li>Don't reuse old passwords</li>
                </ul>
            </div>
            
            <form method="POST" action="" id="resetForm">
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" 
                           name="new_password" 
                           id="new_password"
                           required 
                           autofocus 
                           minlength="6"
                           placeholder="Enter new password">
                </div>
                
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" 
                           name="confirm_password" 
                           id="confirm_password"
                           required 
                           minlength="6"
                           placeholder="Confirm new password">
                </div>
                
                <button type="submit" name="reset_password" class="btn-reset" id="submitBtn">
                    🔒 Reset Password
                </button>
            </form>
            
            <script>
                document.getElementById('resetForm').addEventListener('submit', function(e) {
                    const newPassword = document.getElementById('new_password').value;
                    const confirmPassword = document.getElementById('confirm_password').value;
                    
                    if (newPassword !== confirmPassword) {
                        e.preventDefault();
                        alert('Passwords do not match. Please try again.');
                        return false;
                    }
                    
                    if (newPassword.length < 6) {
                        e.preventDefault();
                        alert('Password must be at least 6 characters long.');
                        return false;
                    }
                    
                    document.getElementById('submitBtn').disabled = true;
                    document.getElementById('submitBtn').textContent = 'Resetting...';
                });
            </script>
            
        <?php elseif ($step === 4): ?>
            <!-- Step 4: Success -->
            <div class="success-box">
                <div style="font-size: 4rem; margin-bottom: 20px;">✅</div>
                <h2>Password Reset Successful!</h2>
                <p>Your admin password has been successfully reset. You can now log in with your new password.</p>
                <a href="login.php" class="btn-login">Go to Login Page</a>
            </div>
            
        <?php endif; ?>
    </div>
</body>
</html>