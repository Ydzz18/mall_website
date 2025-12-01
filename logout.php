<?php
require_once 'config.php';

if (isset($_SESSION['customer_id'])) {
    logCustomerActivity(
        $_SESSION['customer_id'],
        'logout',
        'Customer logged out',
        'customers',
        $_SESSION['customer_id']
    );
}

session_start();
session_destroy();
header('Location: index.php');
exit;
?>