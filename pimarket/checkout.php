<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $cart = $_SESSION['cart'] ?? [];

    $products = [
      1 => ["name" => "Product 1", "price" => 49.00],
      2 => ["name" => "Product 2", "price" => 20.00],
      3 => ["name" => "Product 3", "price" => 123.00]
    ];

    $orderDetails = "Order from: $name\nEmail: $email\nAddress: $address\n\n";
    $total = 0;

    foreach ($cart as $id => $qty) {
        $product = $products[$id];
        $line = $product['price'] * $qty;
        $total += $line;
        $orderDetails .= "- {$product['name']} x $qty = $" . number_format($line, 2) . "\n";
    }
    $orderDetails .= "\nTotal: $" . number_format($total, 2);

    // Изпращане по имейл
    mail("mnooogopi@devcodeapp.site", "New PiMarket Order", $orderDetails);

    // Запис в CSV
    $file = fopen("orders.csv", "a");
    fputcsv($file, [date("Y-m-d H:i:s"), $name, $email, $address, str_replace("\n", " | ", $orderDetails)]);
    fclose($file);

    // Изчистване на количката
    $_SESSION['cart'] = [];
}

include 'header.php';
?>

<div class="message">
  <h1>Thank You for Your Order 🎉</h1>
  <p>Your order has been received and is being processed.</p>
  <p>You will receive confirmation at: <strong><?php echo $email; ?></strong></p>
  <pre style="text-align:left; background:#223a21; padding:1rem; border-radius:8px; color:#ffd700;"><?php echo $orderDetails; ?></pre>
  <a href="index.php" class="button">← Back to Home</a>
</div>

</body>
</html>

