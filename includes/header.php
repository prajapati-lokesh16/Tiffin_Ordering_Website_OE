<?php
if (session_status() === PHP_SESSION_NONE) session_start();
// Set base URL for XAMPP
$base = '/Tiffin_Website';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Tiffin Ordering</title>
    <link rel="stylesheet" href="<?php echo $base; ?>/css/style.css">
    <script src="<?php echo $base; ?>/js/validation.js" defer></script>
</head>
<body>
<nav class="navbar" role="navigation" aria-label="Main Navigation">
    <a href="<?php echo $base; ?>/public/index.php">Home</a>
    <a href="<?php echo $base; ?>/public/menu.php">Menu</a>
    <a href="<?php echo $base; ?>/public/order.php">Order</a>
    <a href="<?php echo $base; ?>/public/contact.php">Contact</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="<?php echo $base; ?>/public/profile.php">Profile</a>
        <a href="<?php echo $base; ?>/public/logout.php">Logout</a>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="<?php echo $base; ?>/admin/admin_dashboard.php">Admin</a>
        <?php endif; ?>
    <?php else: ?>
        <a href="<?php echo $base; ?>/public/login.php">Login</a>
        <a href="<?php echo $base; ?>/public/signup.php">Signup</a>
    <?php endif; ?>
</nav>
