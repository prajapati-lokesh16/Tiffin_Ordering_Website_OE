<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/config.php';
$stmt = $pdo->query('SELECT * FROM tiffin_items');
?>
<main>
    <section class="menu" aria-label="Menu">
        <h2>Our Menu</h2>
        <div class="menu-grid">
            <?php while ($item = $stmt->fetch()): ?>
                <article class="menu-item" tabindex="0">
                    <img src="/Tiffin_Website/uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?> image">
                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                    <p><?php echo htmlspecialchars($item['description']); ?></p>
                    <p class="price"><?php echo number_format($item['price'], 2); ?></p>
                    <form action="order.php" method="get" aria-label="Order <?php echo htmlspecialchars($item['name']); ?>">
                        <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                        <input type="number" name="quantity" value="1" min="1" required aria-label="Quantity">
                        <button type="submit">Order</button>
                    </form>
                </article>
            <?php endwhile; ?>
        </div>
    </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/footer.php'; ?>
