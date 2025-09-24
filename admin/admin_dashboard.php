<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/auth.php';
require_admin();
include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/config.php';
// Orders
$order_stmt = $pdo->query('SELECT o.*, u.name AS user_name, t.name AS item_name FROM orders o JOIN users u ON o.user_id = u.id JOIN tiffin_items t ON o.item_id = t.id ORDER BY o.created_at DESC');
// Messages
$msg_stmt = $pdo->query('SELECT * FROM messages ORDER BY created_at DESC');
// Items
$item_stmt = $pdo->query('SELECT * FROM tiffin_items');
?>
<main>
    <section class="admin-dashboard" aria-label="Admin Dashboard">
        <h2>Admin Dashboard</h2>
        <h3>Orders</h3>
        <table aria-label="Orders">
            <thead>
                <tr><th>User</th><th>Item</th><th>Qty</th><th>Total</th><th>Date</th></tr>
            </thead>
            <tbody>
            <?php while ($o = $order_stmt->fetch()): ?>
            <tr>
                <td><?php echo htmlspecialchars($o['user_name']); ?></td>
                <td><?php echo htmlspecialchars($o['item_name']); ?></td>
                <td><?php echo $o['quantity']; ?></td>
                <td><?php echo number_format($o['total_price'], 2); ?></td>
                <td><?php echo $o['created_at']; ?></td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <h3>Contact Messages</h3>
        <table aria-label="Contact Messages">
            <thead>
                <tr><th>Name</th><th>Email</th><th>Message</th><th>Date</th></tr>
            </thead>
            <tbody>
            <?php while ($m = $msg_stmt->fetch()): ?>
            <tr>
                <td><?php echo htmlspecialchars($m['name']); ?></td>
                <td><?php echo htmlspecialchars($m['email']); ?></td>
                <td><?php echo htmlspecialchars($m['message']); ?></td>
                <td><?php echo $m['created_at']; ?></td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <h3>Menu Items</h3>
    <a href="admin_add_item.php" class="btn">Add Item</a>
        <table aria-label="Menu Items">
            <thead>
                <tr><th>Image</th><th>Name</th><th>Description</th><th>Price</th><th>Action</th></tr>
            </thead>
            <tbody>
            <?php while ($item = $item_stmt->fetch()): ?>
            <tr>
                <td><img src="/Tiffin_Website/uploads/<?php echo htmlspecialchars($item['image']); ?>" width="60" alt="<?php echo htmlspecialchars($item['name']); ?> image"></td>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo htmlspecialchars($item['description']); ?></td>
                <td><?php echo number_format($item['price'], 2); ?></td>
                <td><a href="admin_edit_item.php?id=<?php echo $item['id']; ?>">Edit</a></td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/footer.php'; ?>
