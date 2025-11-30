<?php
require_once 'config.php';

if (isLoggedIn()) {
    header('Location: shop.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $conn = getDBConnection();
        $stmt = $conn->prepare("SELECT customer_id, password_hash, first_name FROM customers WHERE email = ? AND is_active = 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['customer_id'] = $user['customer_id'];
                $_SESSION['first_name'] = $user['first_name'];
                
                // Update last login
                $update_stmt = $conn->prepare("UPDATE customers SET last_login = NOW() WHERE customer_id = ?");
                $update_stmt->bind_param("i", $user['customer_id']);
                $update_stmt->execute();
                
                header('Location: shop.php');
                exit;
            } else {
                $error = 'Invalid email or password.';
            }
        } else {
            $error = 'Invalid email or password.';
        }
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        .login-container {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .login-box {
            background: white;
            padding: 3rem;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            border: 1px solid #e2e8f0;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
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
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-input.error {
            border-color: #dc2626;
        }

        .input-error {
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: none;
        }

        .input-error.show {
            display: block;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #374151;
        }

        .checkbox-container input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            cursor: pointer;
        }

        .forgot-link {
            color: #3b82f6;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .btn-login {
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

        .btn-login:hover:not(:disabled) {
            background: #374151;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-login:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .divider {
            text-align: center;
            position: relative;
            margin: 2rem 0;
            color: #64748b;
            font-size: 0.9rem;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e2e8f0;
        }

        .divider span {
            background: white;
            padding: 0 1rem;
            position: relative;
        }

        .social-login {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .btn-social {
            flex: 1;
            padding: 0.875rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            color: #374151;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-social:hover {
            border-color: #d1d5db;
            background: #f8fafc;
            transform: translateY(-1px);
        }

        .signup-link {
            text-align: center;
            color: #64748b;
            font-size: 0.95rem;
        }

        .signup-link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        @media (max-width: 480px) {
            .login-box {
                padding: 2rem;
                margin: 1rem;
            }

            .social-login {
                flex-direction: column;
            }

            .form-options {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h2>Welcome Back</h2>
                <p class="login-subtitle">Sign in to your account to continue shopping</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" id="loginForm" novalidate>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input" 
                           placeholder="Enter your email" required 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    <div class="input-error" id="emailError">Please enter a valid email address</div>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input" 
                           placeholder="Enter your password" required>
                    <div class="input-error" id="passwordError">Password is required</div>
                </div>
                
                <div class="form-options">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                    <a href="forgot-password.php" class="forgot-link">Forgot password?</a>
                </div>
                
                <button type="submit" class="btn-login">SIGN IN</button>
            </form>
            
            <div class="divider">
                <span>or continue with</span>
            </div>
            
            <div class="social-login">
                <button type="button" class="btn-social">
                    <span>🔴</span>
                    GOOGLE
                </button>
                <button type="button" class="btn-social">
                    <span>👤</span>
                    FACEBOOK
                </button>
            </div>
            
            <div class="signup-link">
                Don't have an account? <a href="register.php">Create one here</a>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');

            // Email validation
            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            emailInput.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    this.classList.add('error');
                    emailError.textContent = 'Email is required';
                    emailError.classList.add('show');
                } else if (!validateEmail(this.value)) {
                    this.classList.add('error');
                    emailError.textContent = 'Please enter a valid email address';
                    emailError.classList.add('show');
                } else {
                    this.classList.remove('error');
                    emailError.classList.remove('show');
                }
            });

            emailInput.addEventListener('input', function() {
                if (validateEmail(this.value)) {
                    this.classList.remove('error');
                    emailError.classList.remove('show');
                }
            });

            passwordInput.addEventListener('blur', function() {
                if (!this.value) {
                    this.classList.add('error');
                    passwordError.classList.add('show');
                } else {
                    this.classList.remove('error');
                    passwordError.classList.remove('show');
                }
            });

            passwordInput.addEventListener('input', function() {
                if (this.value) {
                    this.classList.remove('error');
                    passwordError.classList.remove('show');
                }
            });

            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Validate email
                if (!emailInput.value.trim()) {
                    emailInput.classList.add('error');
                    emailError.textContent = 'Email is required';
                    emailError.classList.add('show');
                    isValid = false;
                } else if (!validateEmail(emailInput.value)) {
                    emailInput.classList.add('error');
                    emailError.textContent = 'Please enter a valid email address';
                    emailError.classList.add('show');
                    isValid = false;
                }

                // Validate password
                if (!passwordInput.value) {
                    passwordInput.classList.add('error');
                    passwordError.classList.add('show');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>