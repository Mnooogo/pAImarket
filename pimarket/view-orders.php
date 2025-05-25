<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  header('Location: login.php');
  exit;
}

$orders = [];
if (file_exists('orders.json')) {
  $lines = file('orders.json');
  foreach ($lines as $line) {
    $orders[] = json_decode($line, true);
  }
}

include 'header.php';
?>

<h1>📦 All Orders</h1>
<?php if (empty($orders)): ?>
  <p>No orders found.</p>
<?php else: ?>
  <table>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Email</th>
      <th>Address</th>
      <th>Items</th>
    </tr>
    <?php foreach ($orders as $i => $order): ?>
      <tr>
        <td><?= $i + 1 ?></td>
        <td><?= htmlspecialchars($order['name']) ?></td>
        <td><?= htmlspecialchars($order['email']) ?></td>
        <td><?= nl2br(htmlspecialchars($order['address'])) ?></td>
        <td>
          <ul>
            <?php foreach ($order['items'] as $item): ?>
              <li><?= htmlspecialchars($item['name']) ?> x <?= $item['qty'] ?></li>
            <?php endforeach; ?>
          </ul>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>

<a href="dashboard.php" class="button">⬅ Back to Dashboard</a>
<?php include 'footer.php'; ?>

</body>
</html>

