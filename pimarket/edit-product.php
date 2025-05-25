<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  header('Location: login.php');
  exit;
}

include 'admin-log.php';

$id = $_GET['id'] ?? 0;
$index = $id - 1;
$products = [];
if (file_exists('products.json')) {
  $lines = file('products.json');
  foreach ($lines as $line) {
    $products[] = json_decode($line, true);
  }
}

if (!isset($products[$index])) {
  die('Invalid product ID.');
}

$product = $products[$index];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $products[$index] = [
    'name' => htmlspecialchars($_POST['name']),
    'desc' => htmlspecialchars($_POST['desc']),
    'price' => floatval($_POST['price']),
    'image' => htmlspecialchars($_POST['image'])
  ];

  $fp = fopen('products.json', 'w');
  foreach ($products as $item) {
    fwrite($fp, json_encode($item) . "\n");
  }
  fclose($fp);

  log_action('Edited product', $products[$index]['name']);

  $message = '✅ Product updated!';
  $product = $products[$index];
}

include 'header.php';
?>

<form method="post">
  <h2>Edit Product ✏️</h2>
  <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
  <textarea name="desc" rows="3" required><?= htmlspecialchars($product['desc']) ?></textarea>
  <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>
  <input type="text" name="image" value="<?= htmlspecialchars($product['image']) ?>" required>
  <button type="submit">Update Product</button>
  <?php if ($message): ?><p class="msg"><?= $message ?></p><?php endif; ?>
</form>
<?php include 'footer.php'; ?>

</body>
</html>
