<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  header('Location: login.php');
  exit;
}

$archived = [];
if (file_exists('deleted-products.json')) {
  $lines = file('deleted-products.json');
  foreach ($lines as $line) {
    $archived[] = json_decode($line, true);
  }
}

include 'header.php';
?>

<h1 style="text-align:center; color:#ffd700;">🗃️ Archived Products</h1>

<?php if (isset($_GET['restored'])): ?>
  <p class="msg" style="text-align:center; color:#90ee90;">✅ Product successfully restored!</p>
<?php endif; ?>

<div class="grid">
  <?php foreach ($archived as $index => $product): ?>
    <div class="card">
      <img src="<?= htmlspecialchars($product['image']) ?>" alt="Image">
      <h3><?= htmlspecialchars($product['name']) ?></h3>
      <p><?= htmlspecialchars($product['desc']) ?></p>
      <p><strong>$<?= number_format($product['price'], 2) ?></strong></p>

      <form method="post" action="restore-product.php" style="margin-top:1rem;">
        <input type="hidden" name="index" value="<?= $index ?>">
        <button type="submit" style="margin-top:10px; padding:8px 16px; background:#ffd700; color:#000; border:none; border-radius:5px; font-weight:bold; cursor:pointer;">🔁 Restore</button>
      </form>
    </div>
  <?php endforeach; ?>
</div>

</body>
</html>

