<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/config.php'; // Make sure this connects to your DB

if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    header('Location: admin_dashboard.php');
    exit;
}

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // TEMPORARY: Plain text password check
    if ($user && $password === $user['password']) {
        if ($user['role'] === 'admin') {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header('Location: admin_dashboard.php');
            exit;
        } else {
            $msg = 'You are not authorized as admin.';
        }
    } else {
        $msg = 'Invalid admin credentials.';
    }
}
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/header.php'; ?>
<main>
    <section class="login-form" aria-label="Admin Login">
        <h2>Admin Login</h2>
        <?php if (!empty($msg)) echo '<p class="error">' . htmlspecialchars($msg) . '</p>'; ?>
        <form action="admin_login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Login</button>
        </form>
    </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/footer.php'; ?>
