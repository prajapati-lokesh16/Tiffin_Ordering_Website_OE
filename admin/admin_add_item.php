<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/auth.php';
require_admin();
include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $image = uniqid('item_', true) . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $image);
    }
    if ($name && $desc && $price && $image) {
        $stmt = $pdo->prepare('INSERT INTO tiffin_items (name, description, price, image) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $desc, $price, $image]);
        $msg = 'Item added!';
    } else {
        $msg = 'All fields required.';
    }
}
?>
<main>
    <section class="admin-add-item" aria-label="Add Menu Item">
        <h2>Add Menu Item</h2>
        <?php if (!empty($msg)) echo '<p class="success">' . htmlspecialchars($msg) . '</p>'; ?>
        <form action="admin_add_item.php" method="post" enctype="multipart/form-data" onsubmit="return validateAddItemForm();" aria-label="Add Item Form">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required aria-label="Name">
            <label for="description">Description:</label>
            <textarea name="description" id="description" required aria-label="Description"></textarea>
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" step="0.01" min="1" required aria-label="Price">
            <label for="image">Image:</label>
            <input type="file" name="image" id="image" accept="image/*" required aria-label="Image">
            <button type="submit">Add Item</button>
        </form>
    </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/footer.php'; ?>
