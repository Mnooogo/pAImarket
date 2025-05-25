<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$role = $_SESSION['role'] ?? 'user';

include 'header.php';
?>

<div class="section">
  <h2>Welcome, <?= htmlspecialchars($role) ?>!</h2>
  <p>You are logged in as <strong><?= htmlspecialchars($role) ?></strong>.</p>

  <ul>
    <li><a href="view-orders.php">📦 View Orders</a></li>
    <?php if ($role === 'admin'): ?>
      <li><a href="change-password.php">🔐 Change Password</a></li>
      <li><a href="view-orders.php">🗑️ Manage/Delete Orders</a></li>
      <li><a href="add-product.php" target="_blank">➕ Add New Product</a></li>
      <li><a href="view-log.php">📜 View Admin Log</a></li>
    <?php endif; ?>
    <li><a href="logout.php">🚪 Logout</a></li>
  </ul>
</div>
<?php include 'footer.php'; ?>

</body>
</html>

