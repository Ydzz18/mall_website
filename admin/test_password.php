<?php
// test_password.php
$password = 'admin123';
$hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

if (password_verify($password, $hash)) {
    echo "✅ Password verification SUCCESS!";
} else {
    echo "❌ Password verification FAILED!";
    echo "<br>Creating new hash: " . password_hash($password, PASSWORD_DEFAULT);
}
?>