<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  header('Location: login.php');
  exit;
}

include 'admin-log.php';

$index = $_POST['index'] ?? null;
if ($index === null) {
  die('Invalid request');
}

$deleted = [];
if (file_exists('deleted-products.json')) {
  $lines = file('deleted-products.json');
  foreach ($lines as $line) {
    $deleted[] = json_decode($line, true);
  }
}

$product = $deleted[$index] ?? null;
if (!$product) {
  die('Product not found');
}

// Add back to products.json
file_put_contents('products.json', json_encode($product) . "\n", FILE_APPEND);

// Log restore action
log_action('Restored product', $product['name'] ?? 'unknown');

// Remove from deleted list
unset($deleted[$index]);
$deleted = array_values($deleted);

$fp = fopen('deleted-products.json', 'w');
foreach ($deleted as $item) {
  fwrite($fp, json_encode($item) . "\n");
}
fclose($fp);

header('Location: archived-products.php');
exit;
