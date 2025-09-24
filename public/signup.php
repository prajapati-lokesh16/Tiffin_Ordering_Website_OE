<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/config.php';
if (isset($_SESSION['user_id'])) {
    header('Location: profile.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';
    if ($name && $email && $password && $password === $confirm) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $msg = 'Email already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, "user")');
            $stmt->execute([$name, $email, $hash]);
            $msg = 'Signup successful! Please login.';
        }
    } else {
        $msg = 'Please fill all fields and match passwords.';
    }
}
?>
<main>
    <section class="signup-form" aria-label="Signup">
        <h2>Signup</h2>
        <?php if (!empty($msg)) echo '<p class="error">' . htmlspecialchars($msg) . '</p>'; ?>
        <form action="signup.php" method="post" onsubmit="return validateSignupForm();" aria-label="Signup Form">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required aria-label="Name">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required aria-label="Email">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required aria-label="Password">
            <label for="confirm">Confirm Password:</label>
            <input type="password" name="confirm" id="confirm" required aria-label="Confirm Password">
            <button type="submit">Signup</button>
        </form>
    </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/footer.php'; ?>
