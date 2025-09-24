<?php
require_once __DIR__ . '/config.php';

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: /public/login.php');
        exit;
    }
}

function require_admin() {
    if (!is_admin()) {
        echo '<main><section class="error"><h2>Access Denied</h2><p>You do not have permission to access the admin dashboard.</p></section></main>';
    include __DIR__ . '/footer.php';
        exit;
    }
}
