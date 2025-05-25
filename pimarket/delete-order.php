<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  header('Location: login.php');
  exit;
}

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
  die('Invalid request.');
}

$idToDelete = intval($_POST['id']);

$orders = file('orders.json', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if (isset($orders[$idToDelete])) {
  unset($orders[$idToDelete]);
  file_put_contents('orders.json', implode("\n", $orders) . "\n");
}

header('Location: admin-orders.php');
exit;
