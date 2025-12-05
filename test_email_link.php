<?php
require_once 'config.php';

// Test URL generation
$order_id = 1;
$site_url = getSiteBaseUrl();
$order_url = $site_url . "/order_tracking.php?order_id=" . $order_id;

echo "Site URL: " . $site_url . "<br>";
echo "Order URL: " . $order_url . "<br>";
echo "<a href='" . $order_url . "'>Test Link</a>";
?>