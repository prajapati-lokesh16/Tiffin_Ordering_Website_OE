<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/auth.php';
require_admin();
include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/config.php';
$id = intval($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM tiffin_items WHERE id = ?');
$stmt->execute([$id]);
$item = $stmt->fetch();
if (!$item) {
    echo '<p>Item not found.</p>';
    include '../includes/footer.php';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $image = $item['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image = uniqid('item_', true) . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $image);
    }
    if ($name && $desc && $price) {
        $stmt = $pdo->prepare('UPDATE tiffin_items SET name=?, description=?, price=?, image=? WHERE id=?');
        $stmt->execute([$name, $desc, $price, $image, $id]);
        $msg = 'Item updated!';
    } else {
        $msg = 'All fields required.';
    }
}
?>
<main>
    <section class="admin-edit-item" aria-label="Edit Menu Item">
        <h2>Edit Menu Item</h2>
        <?php if (!empty($msg)) echo '<p class="success">' . htmlspecialchars($msg) . '</p>'; ?>
        <form action="admin_edit_item.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data" onsubmit="return validateEditItemForm();" aria-label="Edit Item Form">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($item['name']); ?>" required aria-label="Name">
            <label for="description">Description:</label>
            <textarea name="description" id="description" required aria-label="Description"><?php echo htmlspecialchars($item['description']); ?></textarea>
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" step="0.01" min="1" value="<?php echo $item['price']; ?>" required aria-label="Price">
            <label for="image">Image:</label>
            <input type="file" name="image" id="image" accept="image/*" aria-label="Image">
            <img src="/Tiffin_Website/uploads/<?php echo htmlspecialchars($item['image']); ?>" width="100" alt="<?php echo htmlspecialchars($item['name']); ?> image">
            <button type="submit">Update Item</button>
        </form>
    </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Tiffin_Website/includes/footer.php'; ?>
