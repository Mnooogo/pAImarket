<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  die("Access denied.");
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=orders-export.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['Timestamp', 'Client Name', 'Email', 'Notes', 'Cart Items']);

if (file_exists('orders.json')) {
  $lines = file('orders.json', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($lines as $line) {
    $order = json_decode($line, true);
    if ($order) {
      $cartItems = '';
      foreach ($order['cart'] as $item) {
        $cartItems .= $item['name'] . ' × ' . $item['quantity'] . '; ';
      }
      $cartItems = rtrim($cartItems, '; ');
      fputcsv($output, [
        $order['timestamp'],
        $order['name'],
        $order['email'],
        $order['notes'],
        $cartItems
      ]);
    }
  }
}

fclose($output);
exit;
