<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/config.php';
if (isset($_SESSION['user_id'])) {
    header('Location: profile.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header('Location: profile.php');
        exit;
    } else {
        $msg = 'Invalid credentials.';
    }
}
?>
<main>
    <section class="login-form" aria-label="Login">
        <h2>Login</h2>
        <?php if (!empty($msg)) echo '<p class="error">' . htmlspecialchars($msg) . '</p>'; ?>
        <form action="login.php" method="post" onsubmit="return validateLoginForm();" aria-label="Login Form">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required aria-label="Email">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required aria-label="Password">
            <button type="submit">Login</button>
        </form>
    </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/footer.php'; ?>
