<?php
header('Content-Type: application/json');

$products = [];

if (file_exists('products.json')) {
  $lines = file('products.json', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($lines as $line) {
    $product = json_decode($line, true);
    if ($product) {
      $products[] = $product;
    }
  }
}

echo json_encode($products);
