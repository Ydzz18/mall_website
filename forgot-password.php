<?php
require_once 'config.php';
require_once 'includes/email.php';

if (isLoggedIn()) {
    header('Location: shop.php');
    exit;
}

$error = '';
$success = '';
$step = 'request';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['step'])) {
        $step = $_POST['step'];
    }
    
    if ($step === 'request' && isset($_POST['email'])) {
        $email = trim($_POST['email']);
        
        if (empty($email)) {
            $error = 'Please enter your email address.';
        } else {
            $conn = getDBConnection();
            $stmt = $conn->prepare("SELECT customer_id, first_name FROM customers WHERE email = ? AND is_active = 1");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $customer = $result->fetch_assoc();
                $customer_id = $customer['customer_id'];
                $customer_name = $customer['first_name'];
                
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
                
                $insert_stmt = $conn->prepare("
                    INSERT INTO password_resets (customer_id, token, expires_at, created_at)
                    VALUES (?, ?, ?, NOW())
                    ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at), created_at = NOW()
                ");
                $insert_stmt->bind_param("iss", $customer_id, $token, $expires);
                $insert_stmt->execute();
                
                $reset_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/nccc/reset-password.php?token=" . $token;
                
                $email_sent = sendPasswordResetEmail($email, $customer_name, $reset_link);
                
                if ($email_sent) {
                    $success = 'A password reset link has been sent to your email address. Please check your inbox.';
                    logCustomerActivity(
                        $customer_id,
                        'password_reset_requested',
                        'Password reset requested for email: ' . $email,
                        'customers',
                        $customer_id
                    );
                } else {
                    error_log("Password reset email failed for: $email");
                    $error = 'We encountered an error sending the reset email. Please try again later.';
                }
            } else {
                $success = 'If an account exists with that email address, you will receive a password reset link.';
            }
            
            $conn->close();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        .forgot-container {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .forgot-box {
            background: white;
            padding: 3rem;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            border: 1px solid #e2e8f0;
        }

        .forgot-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .forgot-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .forgot-subtitle {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
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

        .btn-reset {
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

        .btn-reset:hover {
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

        .back-link {
            text-align: center;
            color: #64748b;
            font-size: 0.95rem;
        }

        .back-link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .forgot-box {
                padding: 2rem;
                margin: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="forgot-container">
        <div class="forgot-box">
            <div class="forgot-header">
                <h2>Forgot Password?</h2>
                <p class="forgot-subtitle">Don't worry! We'll help you reset it. Enter your email address and we'll send you a link to create a new password.</p>
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
            <?php endif; ?>
            
            <?php if (!$success): ?>
                <form method="POST" action="" novalidate>
                    <input type="hidden" name="step" value="request">
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input" 
                            placeholder="Enter your email address" 
                            required
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                        >
                    </div>
                    
                    <button type="submit" class="btn-reset">Send Reset Link</button>
                </form>
            <?php endif; ?>
            
            <div class="back-link">
                <p>Remember your password? <a href="login.php">Sign in here</a></p>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>
