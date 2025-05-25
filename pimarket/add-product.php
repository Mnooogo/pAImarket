<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
ini_set('display_errors', 0);
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  header('Location: login.php');
  exit;
}

$message = ''; // 🛡️ ЗАДЪЛЖИТЕЛНО преди да се включи header.php
$piPrice = "Unavailable";

try {
  $response = file_get_contents("https://api.bitget.com/api/v2/spot/market/tickers");
  $data = json_decode($response, true);

  if (isset($data['data']) && is_array($data['data'])) {
    foreach ($data['data'] as $item) {
      if (isset($item['symbol']) && $item['symbol'] === 'PIUSDT') {
        if (isset($item['close'])) {
          $piPrice = floatval($item['close']);
        } else {
          $piPrice = "API Error: Price not available";
        }
        break;
      }
    }
  }
} catch (Exception $e) {
  $piPrice = "API Error: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $product = [
    'name' => htmlspecialchars($_POST['name']),
    'desc' => htmlspecialchars($_POST['desc']),
    'price' => floatval($_POST['price']),
    'image' => htmlspecialchars($_POST['image'])
  ];

  file_put_contents('products.json', json_encode($product) . "\n", FILE_APPEND);
  $message = '✅ Product added successfully!';
}

include 'header.php';
?>


<?php if ($message): ?>
  <div style="margin-top: 2rem;">
    <a href="index.php" style="background:#ffd700; color:#000; padding:10px 20px; border-radius:6px; font-weight:bold; text-decoration:none; box-shadow:0 3px 6px rgba(0,0,0,0.3);">🏪 To the Store</a>
  </div>
<?php endif; ?>

<h2 style="color:#ffd700">➕ Add New Product</h2>
<p style="color:#ccc; font-size:0.9em;">Current Pi price: 
  <span id="pi-usdt" style="color:<?= is_numeric($piPrice) ? '#ffd700' : '#f88'; ?>">
    <?= is_numeric($piPrice) ? $piPrice . ' USDT' : '⚠️ Price not available (API offline)' ?>
  </span>
</p>

<label>Enter price in local currency:</label>
<input type="number" id="local-price" placeholder="e.g. 15.00 BGN" step="0.01">
<label>Suggested price in π:</label>
<input type="text" id="suggested-pi" placeholder="Auto-calculated" readonly style="background:#eee;">
<button type="button" onclick="usePiPrice()" style="margin-top: 10px; background:#ffd700; color:#000; padding:8px 16px; border:none; border-radius:5px; cursor:pointer;">
  👇 Use Suggested π
</button>

<script>
const piPrice = parseFloat(<?php echo is_numeric($piPrice) ? $piPrice : '0'; ?>);
const localInput = document.getElementById("local-price");
const piOutput = document.getElementById("suggested-pi");

localInput.addEventListener("input", () => {
  const local = parseFloat(localInput.value);
  if (!isNaN(local) && piPrice && !isNaN(piPrice)) {
    const pi = (local / piPrice).toFixed(2);
    piOutput.value = pi;
  }
});

function usePiPrice() {
  const suggested = document.getElementById("suggested-pi").value;
  if (suggested) {
    document.querySelector('input[name="price"]').value = suggested;
  }
}
</script>

<form method="post">
  <input type="text" name="name" placeholder="Product Name" required />
  <textarea name="desc" placeholder="Description" required></textarea>
  <input type="number" step="0.01" name="price" placeholder="Price" required />
  <input type="text" name="image" placeholder="Image URL" required />
  <button type="submit">Add Product</button>
  <?php if ($message): ?><p class="msg"><?= $message ?></p><?php endif; ?>
</form>

