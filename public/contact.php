<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($name && $email && $message) {
        $stmt = $pdo->prepare('INSERT INTO messages (name, email, message, created_at) VALUES (?, ?, ?, NOW())');
        $stmt->execute([$name, $email, $message]);
        $msg = 'Message sent!';
    } else {
        $msg = 'All fields are required.';
    }
}
?>
<main>
    <section class="contact-form" aria-label="Contact Us">
        <h2>Contact Us</h2>
        <?php if (!empty($msg)) echo '<p class="success">' . htmlspecialchars($msg) . '</p>'; ?>
        <form action="contact.php" method="post" onsubmit="return validateContactForm();" aria-label="Contact Form">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required aria-label="Name">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required aria-label="Email">
            <label for="message">Message:</label>
            <textarea name="message" id="message" required aria-label="Message"></textarea>
            <button type="submit">Send</button>
        </form>
    </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/footer.php'; ?>
