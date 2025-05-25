<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['cart'])) {
  echo json_encode(["success" => false, "message" => "Invalid order data"]);
  exit;
}

$order = [
  'timestamp' => date("Y-m-d H:i:s"),
  'cart' => $data['cart'],
  'name' => htmlspecialchars($data['name']),
  'email' => htmlspecialchars($data['email']),
  'notes' => htmlspecialchars($data['notes'])
];

file_put_contents('orders.json', json_encode($order) . "\n", FILE_APPEND);

echo json_encode(["success" => true, "message" => "✅ Order received!"]);
