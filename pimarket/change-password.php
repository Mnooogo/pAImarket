<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$file = 'credentials.json';
$credentials = json_decode(file_get_contents($file), true);

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current'] ?? '';
    $new = $_POST['new'] ?? '';

    if ($current === $credentials['password']) {
        $credentials['password'] = $new;
        file_put_contents($file, json_encode($credentials));
        $message = '✅ Password changed successfully';
    } else {
        $message = '❌ Current password is incorrect';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password</title>
  <style>
    body {
      font-family: sans-serif;
      background: #334f2f;
      color: #fff;
      padding: 2rem;
      text-align: center;
    }
    form {
      background: #3f5c39;
      padding: 2rem;
      border-radius: 10px;
      max-width: 400px;
      margin: auto;
    }
    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      border: none;
    }
    button {
      background: #ffd700;
      padding: 10px 20px;
      border: none;
      color: #000;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
    }
    .message {
      margin-top: 1rem;
      color: #ffd700;
    }
  </style>
</head>
<body>
  <form method="post">
    <h2>Change Password 🔐</h2>
    <input type="password" name="current" placeholder="Current Password" required>
    <input type="password" name="new" placeholder="New Password" required>
    <button type="submit">Update</button>
    <?php if ($message): ?><p class="message"><?= $message ?></p><?php endif; ?>
  </form>
</body>
</html>
