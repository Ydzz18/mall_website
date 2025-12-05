<?php
require_once '../config.php';

if (isset($_SESSION['rider_id'])) {
    $rider_id = $_SESSION['rider_id'];
    
    logCustomerActivity(
        $rider_id,
        'rider_logout',
        'Rider logged out',
        'riders',
        $rider_id
    );
}

session_destroy();
header('Location: login.php');
exit;
?>
