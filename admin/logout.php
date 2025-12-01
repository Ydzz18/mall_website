<?php
require_once '../config.php';

if (isset($_SESSION['admin_id'])) {
    logAdminActivity(
        $_SESSION['admin_id'],
        'admin_logout',
        'Admin logged out',
        'admin_users',
        $_SESSION['admin_id']
    );
}

session_destroy();
header('Location: login.php');
exit;
?>