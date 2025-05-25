<?php
function getUserIP() {
  return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
}

$allowed_ips = ['127.0.0.1', '::1', '79.100.216.51']; // добави реални IP адреси тук
if (!in_array(getUserIP(), $allowed_ips)) {
  die('Access denied (IP not allowed)');
}

if (isset($_POST['clear'])) {
  file_put_contents('admin-log.txt', '');
  header('Location: view-log.php');
  exit;
}

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  header('Location: login.php');
  exit;
}

$logs = file_exists('admin-log.txt') ? file('admin-log.txt') : [];

include 'header.php';
?>

<form method="get" style="text-align:center; margin-top:1rem;">
  <input type="text" name="q" placeholder="Search log..." style="padding:8px; width:60%; border-radius:5px; border:none;">
  <button type="submit" style="padding:8px 16px; border:none; border-radius:5px; background:#ffd700; color:#000; font-weight:bold; cursor:pointer;">🔍 Search</button>
</form>

<h1 style="text-align:center; color:#ffd700;">📜 Admin Action Log</h1>

<?php
$query = $_GET['q'] ?? '';
$filtered = $query ? array_filter($logs, function($line) use ($query) {
  return stripos($line, $query) !== false;
}) : $logs;
rsort($filtered);
?>

<pre style="background:#3f5c39; padding:1rem; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.4); white-space:pre-wrap; max-width:900px; margin:2rem auto;">
<?= implode('', $filtered); ?>
</pre>

<form method="post" onsubmit="return confirm('Are you sure you want to permanently clear the log?');" style="text-align:center; margin-top:2rem;">
  <button type="submit" name="clear" style="background:#c62828; color:#fff; padding:10px 20px; border:none; border-radius:5px; cursor:pointer; font-weight:bold;">🗑️ Clear Log</button>
</form>

<div style="text-align:center; margin-top:1rem;">
  <a href="admin-log.txt" download style="background:#ffd700; color:#000; padding:10px 20px; border:none; border-radius:5px; font-weight:bold; text-decoration:none;">⬇️ Download Log</a>
</div>
<?php include 'footer.php'; ?>

</body>
</html>

