<?php
require_once 'config.php';

if (isLoggedIn()) {
    header('Location: shop.php');
    exit;
}

$error = '';
$success = '';
$token = $_GET['token'] ?? '';
$valid_token = false;
$customer_id = null;

if (empty($token)) {
    $error = 'Invalid or missing reset token.';
} else {
    $conn = getDBConnection();
    $stmt = $conn->prepare("
        SELECT customer_id FROM password_resets 
        WHERE token = ? AND expires_at > NOW()
    ");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $valid_token = true;
        $reset_data = $result->fetch_assoc();
        $customer_id = $reset_data['customer_id'];
    } else {
        $error = 'This password reset link has expired. Please request a new one.';
    }
    $conn->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid_token) {
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($password) || empty($confirm_password)) {
        $error = 'Please fill in all fields.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        $conn = getDBConnection();
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        
        $update_stmt = $conn->prepare("
            UPDATE customers SET password_hash = ? WHERE customer_id = ?
        ");
        $update_stmt->bind_param("si", $password_hash, $customer_id);
        $update_stmt->execute();
        
        $delete_stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
        $delete_stmt->bind_param("s", $token);
        $delete_stmt->execute();
        
        logCustomerActivity(
            $customer_id,
            'password_reset_completed',
            'Password has been reset successfully',
            'customers',
            $customer_id
        );
        
        $success = 'Your password has been reset successfully. You can now log in with your new password.';
        $valid_token = false;
        
        $conn->close();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        .reset-container {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .reset-box {
            background: white;
            padding: 3rem;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            border: 1px solid #e2e8f0;
        }

        .reset-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .reset-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .reset-subtitle {
            color: #64748b;
            font-size: 0.95rem;
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

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
            box-sizing: border-box;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .password-requirements {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
            padding: 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .password-requirements li {
            margin: 5px 0;
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: #1e293b;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .btn-submit:hover {
            background: #374151;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }

        .login-link {
            text-align: center;
            color: #64748b;
            font-size: 0.95rem;
        }

        .login-link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .reset-box {
                padding: 2rem;
                margin: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="reset-container">
        <div class="reset-box">
            <div class="reset-header">
                <h2>Reset Your Password</h2>
                <p class="reset-subtitle">Enter your new password below</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    ✓ <?php echo htmlspecialchars($success); ?>
                </div>
                <div class="login-link">
                    <p><a href="login.php">Return to Login</a></p>
                </div>
            <?php elseif ($valid_token): ?>
                <div class="password-requirements">
                    <strong>Password Requirements:</strong>
                    <ul style="margin: 0; padding-left: 20px;">
                        <li>At least 8 characters long</li>
                        <li>Should contain uppercase and lowercase letters</li>
                        <li>Should contain numbers and special characters</li>
                    </ul>
                </div>
                
                <form method="POST" action="" novalidate>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="Enter your new password" 
                            required
                            minlength="8"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            class="form-input" 
                            placeholder="Confirm your new password" 
                            required
                            minlength="8"
                        >
                    </div>
                    
                    <button type="submit" class="btn-submit">Reset Password</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>
