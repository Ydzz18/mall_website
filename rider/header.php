<?php
if (!isset($_SESSION['rider_id'])) {
    return;
}
?>
<header class="rider-main-header">
    <div class="rider-header-inner">
        <div class="rider-brand">
            <div class="rider-brand-mark">
                <i class="fas fa-motorcycle"></i>
            </div>
            <div class="rider-brand-text">
                <span class="rider-brand-name"><?php echo htmlspecialchars(SITE_NAME); ?></span>
                <small>Rider Portal</small>
            </div>
        </div>

        <nav class="rider-nav" aria-label="Rider navigation">
            <a href="dashboard.php"><i class="fas fa-gauge"></i> Dashboard</a>
            <a href="order_details.php"><i class="fas fa-box"></i> Orders</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>

        <div class="rider-user-box">
            <span class="rider-user-name"><?php echo htmlspecialchars($_SESSION['rider_name'] ?? 'Rider'); ?></span>
            <a href="logout.php" class="rider-logout-btn"><i class="fas fa-right-from-bracket"></i> Sign out</a>
        </div>
    </div>
</header>

<style>
.rider-main-header {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
    box-shadow: 0 10px 25px rgba(15, 23, 42, 0.18);
    border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.rider-header-inner {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0.9rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

.rider-brand {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    color: #fff;
}

.rider-brand-mark {
    width: 46px;
    height: 46px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.18);
    font-size: 1.2rem;
}

.rider-brand-text {
    display: flex;
    flex-direction: column;
    line-height: 1.1;
}

.rider-brand-name {
    font-size: 1.5rem;
    font-weight: 800;
    letter-spacing: -0.03em;
}

.rider-brand-text small {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.72rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

.rider-nav {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
    justify-content: center;
}

.rider-nav a {
    color: rgba(255, 255, 255, 0.92);
    text-decoration: none;
    font-weight: 600;
    padding: 0.7rem 1rem;
    border-radius: 10px;
    transition: all 0.2s ease;
}

.rider-nav a:hover {
    background: rgba(255, 255, 255, 0.09);
    color: white;
}

.rider-user-box {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: white;
}

.rider-user-name {
    font-weight: 700;
    opacity: 0.95;
}

.rider-logout-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    background: rgba(255, 255, 255, 0.12);
    color: white;
    text-decoration: none;
    padding: 0.7rem 1rem;
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.16);
    font-weight: 600;
}

.rider-logout-btn:hover {
    background: rgba(255, 255, 255, 0.18);
}

@media (max-width: 768px) {
    .rider-header-inner {
        flex-direction: column;
        padding: 1rem;
    }

    .rider-nav,
    .rider-user-box {
        width: 100%;
        justify-content: center;
    }

    .rider-brand {
        justify-content: center;
    }
}
</style>
