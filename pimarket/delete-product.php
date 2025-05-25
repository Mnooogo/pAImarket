<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  header('Location: login.php');
  exit;
}

include 'admin-log.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$index = $id - 1;

$products = [];
if (file_exists('products.json')) {
  $lines = file('products.json');
  foreach ($lines as $line) {
    $products[] = json_decode($line, true);
  }
}

if (!isset($products[$index])) {
  echo "<html><body style='background:#334f2f; color:#fff; font-family:sans-serif; text-align:center; padding:2rem;'>";
  echo "<h2>❌ Invalid Product ID</h2>";
  echo "<p>No product found with ID: $id</p>";
  echo "<a href='index.php' style='background:#ffd700; color:#000; padding:10px 20px; border-radius:6px; font-weight:bold; text-decoration:none; box-shadow:0 3px 6px rgba(0,0,0,0.3);'>⬅ Back to Home</a>";
  echo "</body></html>";
  exit;
}

if (\$_SERVER['REQUEST_METHOD'] === 'POST') {
  // Лог преди изтриване
  log_action('Deleted product', 'ID ' . \$id . ' - ' . \$products[\$index]['name']);
  header('Location: index.php');
  exit;
}

$product = $products[$index] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirm Deletion</title>
  <style>
    body {
      font-family: sans-serif;
      background: #334f2f;
      color: #fff;
      text-align: center;
      padding: 2rem;
    }
    .container {
      background: #3f5c39;
      padding: 2rem;
      border-radius: 10px;
      max-width: 600px;
      margin: auto;
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }
    button, a.button {
      background: #ffd700;
      color: #000;
      padding: 10px 20px;
      margin: 10px;
      font-weight: bold;
      border-radius: 5px;
      border: none;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php if ($product): ?>
      <h2>Are you sure you want to delete:</h2>
      <h3><?= htmlspecialchars($product['name']) ?></h3>
      <p><?= htmlspecialchars($product['desc']) ?></p>
      <p><strong>$<?= number_format($product['price'], 2) ?></strong></p>
      <form method="post">
        <button type="submit">Yes, Delete</button>
        <a href="single-product.php?id=<?= $id ?>" class="button">Cancel</a>
      </form>
<?php if (\$message): ?>
  <div style="margin-top: 2rem;">
    <a href="index.php" style="background:#ffd700; color:#000; padding:10px 20px; border-radius:6px; font-weight:bold; text-decoration:none; box-shadow:0 3px 6px rgba(0,0,0,0.3);">🛒 To the Store</a>
  </div>
<?php endif; ?>
    <?php else: ?>
      <p>Product not found.</p>
    <?php endif; ?>
  </div>
</body>
</html>

