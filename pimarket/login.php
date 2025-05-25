<?php
session_start();

$file = 'credentials.json';
$credentials = json_decode(file_get_contents($file), true);

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $credentials['username'] && $password === $credentials['password']) {
        $_SESSION['logged_in'] = true;
        $_SESSION['role'] = $credentials['role'] ?? 'user';
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid login credentials';
    }
}

include 'header.php';
?>

<div class="login-wrapper">
  <div class="login-form">
    <form method="post">
      <h2>🔐 Admin Login</h2>
      <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
  </div>

 

<?php include 'footer.php'; ?>
</body>
</html>


