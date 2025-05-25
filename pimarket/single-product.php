<?php
session_start();
$id = $_GET['id'] ?? 0;

$products = [];
if (file_exists('products.json')) {
  $lines = file('products.json');
  foreach ($lines as $line) {
    $products[] = json_decode($line, true);
  }
}

$product = $products[$id - 1] ?? null;

include 'header.php';
?>

<div class="container">
  <?php if ($product): ?>
    <h1><?= htmlspecialchars($product['name']) ?></h1>
    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    <p><?= htmlspecialchars($product['desc']) ?></p>
    <p><strong>Price:</strong> <?= number_format($product['price'], 2) ?> π</p>
    <a href="cart.php?action=add&id=<?= $id ?>" class="button">🛒 Add for Pi</a>

    <p style="margin-top: 2rem;">
      <a href="edit-product.php?id=<?= $id ?>" class="button">✏️ Edit Product</a>
      <a href="delete-product.php?id=<?= $id ?>" class="button" onclick="return confirm('Are you sure you want to delete this product?');">🗑️ Delete</a>
    </p>
  <?php else: ?>
    <h2>Product Not Found</h2>
    <p>The product you are looking for does not exist.</p>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>


