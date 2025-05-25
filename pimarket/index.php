<?php 
session_start();
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

$products = [];
if (file_exists('products.json')) {
  $lines = file('products.json');
  foreach ($lines as $line) {
    $product = json_decode($line, true);
    if ($product) {
      $products[] = $product;
    }
  }
}

include 'header.php';
?>

<h1 style="color:#ffd700;margin-top: 40px;text-shadow: 0.5px 0.5px 1px #0a0a0a;">🔣 PiMarket(Demo) 🚀</h1>
<p>Local commerce, global Pi impact 🌍</p>



<div class="product-grid">
  <?php foreach ($products as $index => $product): ?>
    <div class="product-card">
      <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
      <h3><?= htmlspecialchars($product['name']) ?></h3>
      <p><?= htmlspecialchars($product['desc']) ?></p>
      <p><strong><?= number_format($product['price'], 2) ?> π</strong></p>

      <a href="single-product.php?id=<?= $index + 1 ?>" class="button">View Product</a>
      <a href="cart.php?action=add&id=<?= $index + 1 ?>" class="button">🛒 Add for Pi</a>
    </div>
  <?php endforeach; ?>
</div>

<p style="margin-top:4rem; font-size:0.9rem;">
  &copy; Stefan Spasov | <a href="https://devcodeapp.site" style="color:#ffd700; text-decoration:underline;">devcodeapp.site</a>
</p>

<div style="margin-top: 3rem;">
  <a href="dashboard.php" style="background:#ffd700; color:#000; padding:10px 20px; border-radius:6px; font-weight:bold; text-decoration:none; box-shadow:0 3px 6px rgba(0,0,0,0.3);">⬅ Back to Dashboard</a>
</div>
<?php include 'footer.php'; ?>

</body>
</html>


