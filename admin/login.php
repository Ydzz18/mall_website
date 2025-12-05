<?php
session_start();

require_once '../config.php';

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password';
    } else {
        $conn = getDBConnection();
        
        // Check if admin exists in database
        $stmt = $conn->prepare("SELECT admin_id, username, password_hash, full_name, email, is_active, role FROM admin_users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            
            // Check if account is active
            if ($admin['is_active'] != 1) {
                $error = 'Your account has been deactivated. Please contact the system administrator.';
            }
            // Verify password
            elseif (password_verify($password, $admin['password_hash'])) {
                // Successful login
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_name'] = $admin['full_name'];
                $_SESSION['admin_email'] = $admin['email'];
                $_SESSION['admin_role'] = $admin['role'] ?? 'admin';
                
                // Update last login time
                $stmt = $conn->prepare("UPDATE admin_users SET last_login = NOW() WHERE admin_id = ?");
                $stmt->bind_param("i", $admin['admin_id']);
                $stmt->execute();
                
                // Log activity
                logAdminActivity(
                    $admin['admin_id'],
                    'admin_login',
                    "Admin logged in: {$admin['full_name']}",
                    'admin_users',
                    $admin['admin_id']
                );
                
                $conn->close();
                header('Location: index.php');
                exit;
            } else {
                $error = 'Invalid username or password';
            }
        } else {
            $error = 'Invalid username or password';
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
    <title>Admin Login - <?php echo SITE_NAME; ?></title>
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
        
        .login-container {
            background: white;
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 450px;
            width: 100%;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .login-header h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 2rem;
        }
        
        .login-header p {
            color: #7f8c8d;
            font-size: 0.9rem;
        }
        
        .admin-icon {
            font-size: 4rem;
            margin-bottom: 20px;
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
            background: #fee;
            color: #c33;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #e74c3c;
        }
        
        .btn-login {
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
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .links-container {
            text-align: center;
            margin-top: 20px;
        }
        
        .links-container a {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            display: block;
            margin: 10px 0;
        }
        
        .links-container a:hover {
            text-decoration: underline;
        }
        
        .demo-info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            border-left: 4px solid #3498db;
        }
        
        .demo-info strong {
            color: #2c3e50;
            display: block;
            margin-bottom: 5px;
        }
        
        .demo-info p {
            color: #555;
            font-size: 0.9rem;
            margin: 5px 0;
        }
        
        .demo-credentials {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 6px;
            margin-top: 10px;
            font-family: monospace;
        }
        
        @media (max-width: 640px) {
            .login-container {
                padding: 30px 20px;
            }
            
            .login-header h1 {
                font-size: 1.5rem;
            }
            
            .admin-icon {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="admin-icon">🔐</div>
            <h1>Admin Login</h1>
            <p>Administration Panel - <?php echo SITE_NAME; ?></p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="" id="loginForm">
            <div class="form-group">
                <label>Username or Email</label>
                <input type="text" 
                       name="username" 
                       required 
                       autofocus 
                       placeholder="Enter your username or email"
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" 
                       name="password" 
                       required
                       placeholder="Enter your password">
            </div>
            
            <button type="submit" class="btn-login" id="loginBtn">
                Login to Dashboard
            </button>
        </form>
        
        <div class="links-container">
            <a href="reset_password.php">🔑 Forgot Password?</a>
            <a href="../index.php">← Back to Store</a>
        </div>
        
        <div class="demo-info">
            <strong>📋 Default Admin Credentials:</strong>
            <div class="demo-credentials">
                <p><strong>Username:</strong> admin</p>
                <p><strong>Password:</strong> admin123</p>
            </div>
            <p style="margin-top: 10px; font-size: 0.85rem; color: #666;">
                ⚠️ Make sure to change the default password after first login!
            </p>
        </div>
    </div>
    
    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.disabled = true;
            btn.textContent = 'Logging in...';
        });
    </script>
</body>
</html>