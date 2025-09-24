<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = intval($_POST['item_id'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 1);
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare('SELECT price FROM tiffin_items WHERE id = ?');
    $stmt->execute([$item_id]);
    $item = $stmt->fetch();
    if ($item) {
        $total_price = $item['price'] * $quantity;
        $stmt = $pdo->prepare('INSERT INTO orders (user_id, item_id, quantity, total_price, created_at) VALUES (?, ?, ?, ?, NOW())');
        $stmt->execute([$user_id, $item_id, $quantity, $total_price]);
        $msg = 'Order placed successfully!';
    } else {
        $msg = 'Invalid item.';
    }
} else {
    $item_id = intval($_GET['item_id'] ?? 0);
    $quantity = intval($_GET['quantity'] ?? 1);
}
?>
<main>
    <section class="order-form" aria-label="Order Tiffin">
        <h2>Order Tiffin</h2>
        <?php if (!empty($msg)) echo '<p class="success">' . htmlspecialchars($msg) . '</p>'; ?>
        <form action="order.php" method="post" onsubmit="return validateOrderForm();" aria-label="Order Form">
            <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" value="<?php echo $quantity; ?>" min="1" required aria-label="Quantity">
            <button type="submit">Place Order</button>
        </form>
    </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/footer.php'; ?>
