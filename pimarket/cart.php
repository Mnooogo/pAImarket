<?php
session_start();

// Зареждане на продуктите от файла
$products = [];
if (file_exists('products.json')) {
  $lines = file('products.json');
  foreach ($lines as $line) {
    $products[] = json_decode($line, true);
  }
}

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';
if ($action === 'add' && isset($products[$id - 1])) {
  $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
  header("Location: cart.php");
  exit;
} elseif ($action === 'remove' && isset($_SESSION['cart'][$id])) {
  if ($_SESSION['cart'][$id] > 1) {
    $_SESSION['cart'][$id]--;
  } else {
    unset($_SESSION['cart'][$id]);
  }
  header("Location: cart.php");
  exit;
} elseif ($action === 'empty') {
  $_SESSION['cart'] = [];
  header("Location: cart.php");
  exit;
}

$total = 0;

include 'header.php';
?>

<?php $itemCount = array_sum($_SESSION['cart']); ?>
<h1>Your Cart 🛒</h1>
<p>🧺 <?= $itemCount ?> item<?= $itemCount !== 1 ? 's' : '' ?> in your cart</p>

<?php if (empty($_SESSION['cart'])): ?>
  <p>Your cart is empty.</p>
<?php else: ?>
  <table>
    <tr>
      <th>Product</th>
      <th>Qty</th>
      <th>Price</th>
      <th>Total</th>
      <th>Action</th>
    </tr>
    <?php foreach ($_SESSION['cart'] as $id => $qty): 
      $index = $id - 1;
      if (!isset($products[$index])) continue;
      $product = $products[$index];
      $line = $product['price'] * $qty;
      $total += $line;
    ?>
    <tr>
      <td><?= htmlspecialchars($product['name']) ?></td>
      <td><?= $qty ?></td>
      <td><?= number_format($product['price'], 2) ?> π</td>
      <td><?= number_format($line, 2) ?> π</td>
      <td>
        <a href="?action=remove&id=<?= $id ?>" class="button">Remove</a>
        <a href="?action=add&id=<?= $id ?>" class="button" style="background:#4caf50; color:#fff;">+1</a>
      </td>
    </tr>
    <?php endforeach; ?>
    <tr>
      <th colspan="3">Total:</th>
      <th colspan="2"><?= number_format($total, 2) ?> π</th>
    </tr>
  </table>

  <form class="checkout" action="checkout.php" method="post">
    <h2 style="color:#ffd700">Checkout Form 🗒️</h2>
    <label for="name">Full Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="address">Shipping Address:</label>
    <textarea id="address" name="address" rows="3" required></textarea>

    <label for="notes">Special Instructions:</label>
    <textarea id="notes" name="notes" rows="3" placeholder="e.g. Leave at front door, call before delivery..."></textarea>

    <button type="submit">Place Order</button>
  </form>
<?php endif; ?>

<a href="?action=empty" class="button" style="background:#c62828; color:#fff;">🧹 Empty Cart</a>
<a href="index.php" class="button">← Continue Shopping</a>

</body>
</html>

