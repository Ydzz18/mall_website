<header class="main-header">
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <a href="index.php"><img src="logo/icon.png" alt=""><?php echo SITE_NAME; ?></a>
            </div>
            
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="track_order.php">Track Order</a></li>
                    <?php 
                    if (isLoggedIn()): 
                        require_once 'includes/notifications.php';
                        $unread_count = getUnreadNotificationCount($_SESSION['customer_id']);
                    ?>
                        <li><a href="cart.php">Cart</a></li>
                        <li><a href="orders.php">My Orders</a></li>
                        <li style="position: relative;">
                            <a href="notifications.php">
                                🔔 Notifications
                                <?php if ($unread_count > 0): ?>
                                    <span style="position: absolute; top: 0; right: 0; background: #ef4444; color: white; border-radius: 50%; width: 20px; height: 20px; font-size: 0.7rem; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                        <?php echo $unread_count; ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            
            <?php if (isLoggedIn()): 
                $user = getCurrentUser(); ?>
                <div class="user-info" id="userInfoNotification">
                    <span class="welcome-text">Welcome,</span>
                    <span class="user-name"><?php echo htmlspecialchars($user['first_name']); ?>!</span>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const userInfo = document.getElementById('userInfoNotification');
                        if (userInfo) {
                            setTimeout(function() {
                                userInfo.style.opacity = '0';
                                setTimeout(function() {
                                    userInfo.style.display = 'none';
                                }, 300);
                            }, 5000);
                        }
                    });
                </script>
            <?php endif; ?>
        </div>
    </div>
</header>

<style>
.main-header {
    background: white;
    padding: 1rem 0;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
    position: sticky;
    top: 0;
    z-index: 1000;
    border-bottom: 1px solid #f1f5f9;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.logo a {
    font-size: 1.8rem;
    font-weight: 800;
    color: #1e293b;
    text-decoration: none;
    letter-spacing: -0.02em;
    transition: all 0.3s ease;
}

.logo a:hover {
    color: #3b82f6;
    transform: translateY(-1px);
}

.logo img {
    height: 40px;
    width: auto;
    vertical-align: middle;
    margin-right: 0.5rem;
}

.main-nav ul {
    display: flex;
    list-style: none;
    gap: 0.5rem;
    margin: 0;
    padding: 0;
}

.main-nav a {
    color: #64748b;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    position: relative;
}

.main-nav a:hover {
    color: #1e293b;
    background: #f8fafc;
    transform: translateY(-1px);
}

.main-nav a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background: #3b82f6;
    transition: all 0.3s ease;
    transform: translateX(-50%);
}

.main-nav a:hover::after {
    width: 70%;
}

@keyframes slideInRight {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.2rem;
    background: #f8fafc;
    border-radius: 8px;
    font-size: 0.9rem;
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 2000;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    animation: slideInRight 0.3s ease-out;
    opacity: 1;
    transition: opacity 0.3s ease;
}

.welcome-text {
    color: #64748b;
}

.user-name {
    color: #1e293b;
    font-weight: 600;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        gap: 1rem;
    }
    
    .main-nav ul {
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.25rem;
    }
    
    .main-nav a {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    
    .logo a {
        font-size: 1.5rem;
    }
}

@media (max-width: 480px) {
    .main-nav ul {
        gap: 0.5rem;
    }
    
    .main-nav a {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
    }
    
    .user-info {
        flex-direction: column;
        gap: 0.25rem;
        text-align: center;
        padding: 0.5rem 1rem;
    }
}
</style>