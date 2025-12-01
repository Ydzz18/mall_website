<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);

    // Server-side validation
    if (empty($email) || empty($password) || empty($first_name) || empty($last_name)) {
        $error = 'Please fill in all required fields.';
    } elseif (!preg_match("/^[a-zA-Z\s'-]+$/", $first_name)) {
        $error = 'First name should only contain letters.';
    } elseif (!preg_match("/^[a-zA-Z\s'-]+$/", $last_name)) {
        $error = 'Last name should only contain letters.';
    } elseif (!empty($phone) && !preg_match("/^[0-9+\-\s()]+$/", $phone)) {
        $error = 'Phone number should only contain numbers and valid characters.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long.';
    } else {
        $conn = getDBConnection();
        
        // Check if email already exists
        $stmt = $conn->prepare("SELECT customer_id FROM customers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = 'Email already registered.';
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO customers (email, password_hash, first_name, last_name, phone) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $email, $password_hash, $first_name, $last_name, $phone);
            
            if ($stmt->execute()) {
                // Send welcome email if enabled
                if (ENABLE_EMAIL_NOTIFICATIONS) {
                    require_once 'includes/email.php';
                    
                    $email_sent = sendWelcomeEmail(
                        $email,
                        $first_name . ' ' . $last_name
                    );
                    
                    if ($email_sent) {
                        error_log("Welcome email sent to $email");
                    }
                }
                
                // Redirect to login
                header('Location: login.php?registered=1');
                exit;
            } else {
                $error = 'Registration failed. Please try again.';
            }
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
    <title>Register - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        .register-container {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .register-box {
            background: white;
            padding: 3rem;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 480px;
            border: 1px solid #e2e8f0;
        }

        .register-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .register-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .register-subtitle {
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

        .form-group label::after {
            content: ' *';
            color: #dc2626;
        }

        .form-group label.optional::after {
            content: '';
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

        .form-input.success {
            border-color: #16a34a;
        }

        .input-error, .input-success {
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: none;
        }

        .input-error {
            color: #dc2626;
        }

        .input-success {
            color: #16a34a;
        }

        .input-error.show, .input-success.show {
            display: block;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .password-strength-meter {
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-bar.weak {
            width: 33%;
            background: #dc2626;
        }

        .strength-bar.medium {
            width: 66%;
            background: #f59e0b;
        }

        .strength-bar.strong {
            width: 100%;
            background: #16a34a;
        }

        .password-strength-text {
            font-size: 0.8rem;
            margin-top: 0.25rem;
            font-weight: 600;
        }

        .password-strength-text.weak {
            color: #dc2626;
        }

        .password-strength-text.medium {
            color: #f59e0b;
        }

        .password-strength-text.strong {
            color: #16a34a;
        }

        .password-requirements {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 0.5rem;
            padding: 0.75rem;
            background: #f8fafc;
            border-radius: 6px;
            display: none;
        }

        .password-requirements.show {
            display: block;
        }

        .password-requirements ul {
            margin: 0.5rem 0 0 1.2rem;
            padding: 0;
        }

        .password-requirements li {
            margin-bottom: 0.25rem;
        }

        .password-requirements li.valid {
            color: #16a34a;
        }

        .password-requirements li.invalid {
            color: #dc2626;
        }

        .form-options {
            margin: 1.5rem 0;
        }

        .checkbox-container {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #374151;
            margin-bottom: 1rem;
        }

        .checkbox-container input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 0.2rem;
            flex-shrink: 0;
        }

        .checkbox-container a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }

        .checkbox-container a:hover {
            text-decoration: underline;
        }

        .btn-register {
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

        .btn-register:hover:not(:disabled) {
            background: #374151;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-register:disabled {
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

        .social-register {
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

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-success a {
            color: #16a34a;
            text-decoration: none;
            font-weight: 600;
        }

        .alert-success a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .register-box {
                padding: 2rem;
                margin: 1rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .social-register {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="register-container">
        <div class="register-box">
            <div class="register-header">
                <h2>Create Account</h2>
                <p class="register-subtitle">Join our community and start shopping today</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert-success">
                    <?php echo htmlspecialchars($success); ?> <a href="login.php">Login here</a>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" id="registerForm" novalidate>
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-input" 
                               placeholder="Enter your first name" required 
                               value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>">
                        <div class="input-error" id="firstNameError">Please enter a valid first name (letters only)</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-input" 
                               placeholder="Enter your last name" required 
                               value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>">
                        <div class="input-error" id="lastNameError">Please enter a valid last name (letters only)</div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input" 
                           placeholder="Enter your email" required 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    <div class="input-error" id="emailError">Please enter a valid email address</div>
                </div>
                
                <div class="form-group">
                    <label for="phone" class="optional">Phone Number</label>
                    <input type="tel" id="phone" name="phone" class="form-input" 
                           placeholder="Enter your phone number"
                           value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                    <div class="input-error" id="phoneError">Please enter a valid phone number (numbers only)</div>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input" 
                           placeholder="Create password" required>
                    <div class="password-strength-meter">
                        <div class="strength-bar" id="strengthBar"></div>
                    </div>
                    <div class="password-strength-text" id="strengthText"></div>
                    <div class="password-requirements" id="passwordRequirements">
                        <strong>Password must contain:</strong>
                        <ul>
                            <li id="req-length" class="invalid">At least 8 characters</li>
                            <li id="req-uppercase" class="invalid">At least one uppercase letter</li>
                            <li id="req-lowercase" class="invalid">At least one lowercase letter</li>
                            <li id="req-number" class="invalid">At least one number</li>
                            <li id="req-special" class="invalid">At least one special character (!@#$%^&*)</li>
                        </ul>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-input" 
                           placeholder="Confirm password" required>
                    <div class="input-error" id="confirmPasswordError">Passwords do not match</div>
                    <div class="input-success" id="confirmPasswordSuccess">Passwords match!</div>
                </div>
                
                <div class="form-options">
                    <label class="checkbox-container">
                        <input type="checkbox" name="newsletter" checked>
                        Send me special offers and updates
                    </label>
                    <label class="checkbox-container">
                        <input type="checkbox" name="terms" id="terms" required>
                        I agree to the <a href="terms.php">Terms of Service</a> and <a href="privacy.php">Privacy Policy</a>
                    </label>
                </div>
                
                <button type="submit" class="btn-register">CREATE ACCOUNT</button>
            </form>
            
            <div class="divider">
                <span>or sign up with</span>
            </div>
            
            <div class="social-register">
                <button type="button" class="btn-social">
                    <span>🔴</span>
                    GOOGLE
                </button>
                <button type="button" class="btn-social">
                    <span>👤</span>
                    FACEBOOK
                </button>
            </div>
            
            <div class="login-link">
                Already have an account? <a href="login.php">Sign in here</a>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const firstNameInput = document.getElementById('first_name');
            const lastNameInput = document.getElementById('last_name');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm_password');
            const termsCheckbox = document.getElementById('terms');

            // Validation patterns
            const namePattern = /^[a-zA-Z\s'-]+$/;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phonePattern = /^[0-9+\-\s()]+$/;

            // Name validation (letters only)
            function validateName(input, errorElement) {
                const value = input.value.trim();
                if (!value) {
                    input.classList.add('error');
                    input.classList.remove('success');
                    errorElement.textContent = 'This field is required';
                    errorElement.classList.add('show');
                    return false;
                } else if (!namePattern.test(value)) {
                    input.classList.add('error');
                    input.classList.remove('success');
                    errorElement.textContent = 'Only letters, spaces, hyphens and apostrophes are allowed';
                    errorElement.classList.add('show');
                    return false;
                } else {
                    input.classList.remove('error');
                    input.classList.add('success');
                    errorElement.classList.remove('show');
                    return true;
                }
            }

            // Restrict input to letters only for names
            function restrictToLetters(e) {
                const char = String.fromCharCode(e.which || e.keyCode);
                if (!/[a-zA-Z\s'-]/.test(char)) {
                    e.preventDefault();
                }
            }

            firstNameInput.addEventListener('keypress', restrictToLetters);
            lastNameInput.addEventListener('keypress', restrictToLetters);

            firstNameInput.addEventListener('blur', function() {
                validateName(this, document.getElementById('firstNameError'));
            });

            lastNameInput.addEventListener('blur', function() {
                validateName(this, document.getElementById('lastNameError'));
            });

            // Email validation
            emailInput.addEventListener('blur', function() {
                const value = this.value.trim();
                const errorElement = document.getElementById('emailError');
                if (!value) {
                    this.classList.add('error');
                    this.classList.remove('success');
                    errorElement.textContent = 'Email is required';
                    errorElement.classList.add('show');
                } else if (!emailPattern.test(value)) {
                    this.classList.add('error');
                    this.classList.remove('success');
                    errorElement.textContent = 'Please enter a valid email address';
                    errorElement.classList.add('show');
                } else {
                    this.classList.remove('error');
                    this.classList.add('success');
                    errorElement.classList.remove('show');
                }
            });

            // Phone validation (numbers only)
            function restrictToNumbers(e) {
                const char = String.fromCharCode(e.which || e.keyCode);
                if (!/[0-9+\-\s()]/.test(char)) {
                    e.preventDefault();
                }
            }

            phoneInput.addEventListener('keypress', restrictToNumbers);

            phoneInput.addEventListener('blur', function() {
                const value = this.value.trim();
                const errorElement = document.getElementById('phoneError');
                if (value && !phonePattern.test(value)) {
                    this.classList.add('error');
                    this.classList.remove('success');
                    errorElement.textContent = 'Please enter a valid phone number';
                    errorElement.classList.add('show');
                } else if (value) {
                    this.classList.remove('error');
                    this.classList.add('success');
                    errorElement.classList.remove('show');
                } else {
                    this.classList.remove('error', 'success');
                    errorElement.classList.remove('show');
                }
            });

            // Password strength checker
            function checkPasswordStrength(password) {
                const requirements = {
                    length: password.length >= 8,
                    uppercase: /[A-Z]/.test(password),
                    lowercase: /[a-z]/.test(password),
                    number: /[0-9]/.test(password),
                    special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
                };

                // Update requirement indicators
                document.getElementById('req-length').className = requirements.length ? 'valid' : 'invalid';
                document.getElementById('req-uppercase').className = requirements.uppercase ? 'valid' : 'invalid';
                document.getElementById('req-lowercase').className = requirements.lowercase ? 'valid' : 'invalid';
                document.getElementById('req-number').className = requirements.number ? 'valid' : 'invalid';
                document.getElementById('req-special').className = requirements.special ? 'valid' : 'invalid';

                const metRequirements = Object.values(requirements).filter(Boolean).length;
                const strengthBar = document.getElementById('strengthBar');
                const strengthText = document.getElementById('strengthText');

                strengthBar.className = 'strength-bar';
                strengthText.className = 'password-strength-text';

                if (metRequirements <= 2) {
                    strengthBar.classList.add('weak');
                    strengthText.classList.add('weak');
                    strengthText.textContent = 'Weak password';
                    return 'weak';
                } else if (metRequirements <= 4) {
                    strengthBar.classList.add('medium');
                    strengthText.classList.add('medium');
                    strengthText.textContent = 'Medium strength password';
                    return 'medium';
                } else {
                    strengthBar.classList.add('strong');
                    strengthText.classList.add('strong');
                    strengthText.textContent = 'Strong password';
                    return 'strong';
                }
            }

            passwordInput.addEventListener('focus', function() {
                document.getElementById('passwordRequirements').classList.add('show');
            });

            passwordInput.addEventListener('input', function() {
                if (this.value) {
                    checkPasswordStrength(this.value);
                } else {
                    document.getElementById('strengthBar').className = 'strength-bar';
                    document.getElementById('strengthText').textContent = '';
                }
                checkPasswordMatch();
            });

            // Password match checker
            function checkPasswordMatch() {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                const errorElement = document.getElementById('confirmPasswordError');
                const successElement = document.getElementById('confirmPasswordSuccess');

                if (confirmPassword) {
                    if (password === confirmPassword) {
                        confirmPasswordInput.classList.remove('error');
                        confirmPasswordInput.classList.add('success');
                        errorElement.classList.remove('show');
                        successElement.classList.add('show');
                    } else {
                        confirmPasswordInput.classList.add('error');
                        confirmPasswordInput.classList.remove('success');
                        errorElement.classList.add('show');
                        successElement.classList.remove('show');
                    }
                }
            }

            confirmPasswordInput.addEventListener('input', checkPasswordMatch);

            // Form submission validation
            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Validate first name
                if (!validateName(firstNameInput, document.getElementById('firstNameError'))) {
                    isValid = false;
                }

                // Validate last name
                if (!validateName(lastNameInput, document.getElementById('lastNameError'))) {
                    isValid = false;
                }

                // Validate email
                const emailValue = emailInput.value.trim();
                const emailError = document.getElementById('emailError');
                if (!emailValue) {
                    emailInput.classList.add('error');
                    emailError.textContent = 'Email is required';
                    emailError.classList.add('show');
                    isValid = false;
                } else if (!emailPattern.test(emailValue)) {
                    emailInput.classList.add('error');
                    emailError.textContent = 'Please enter a valid email address';
                    emailError.classList.add('show');
                    isValid = false;
                }

                // Validate phone if provided
                const phoneValue = phoneInput.value.trim();
                if (phoneValue && !phonePattern.test(phoneValue)) {
                    phoneInput.classList.add('error');
                    document.getElementById('phoneError').classList.add('show');
                    isValid = false;
                }

                // Validate password
                if (!passwordInput.value) {
                    passwordInput.classList.add('error');
                    alert('Password is required');
                    isValid = false;
                } else if (passwordInput.value.length < 8) {
                    alert('Password must be at least 8 characters long');
                    isValid = false;
                }

                // Validate password match
                if (passwordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordInput.classList.add('error');
                    document.getElementById('confirmPasswordError').classList.add('show');
                    alert('Passwords do not match');
                    isValid = false;
                }

                // Validate terms checkbox
                if (!termsCheckbox.checked) {
                    alert('Please agree to the Terms of Service and Privacy Policy');
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