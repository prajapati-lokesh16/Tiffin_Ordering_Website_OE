<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/auth.php';
require_login();
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();
$stmt = $pdo->prepare('SELECT o.*, t.name AS item_name FROM orders o JOIN tiffin_items t ON o.item_id = t.id WHERE o.user_id = ? ORDER BY o.created_at DESC');
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();
?>
<main>
    <section class="profile" aria-label="User Profile">
        <h2>My Profile</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <h3>Order History</h3>
        <table aria-label="Order History">
            <thead>
                <tr><th>Item</th><th>Quantity</th><th>Total Price</th><th>Date</th></tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['item_name']); ?></td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td><?php echo number_format($order['total_price'], 2); ?></td>
                    <td><?php echo $order['created_at']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/footer.php'; ?>
