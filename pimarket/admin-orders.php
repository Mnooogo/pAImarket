<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  header('Location: login.php');
  exit;
}

$orders = [];

if (file_exists('orders.json')) {
  $lines = file('orders.json', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($lines as $line) {
    $order = json_decode($line, true);
    if ($order) {
      $orders[] = $order;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>📦 Orders Overview</title>
  <style>
    body {
      font-family: sans-serif;
      background: #202c20;
      color: #fff;
      padding: 2rem;
    }
    h1 {
      color: #ffd700;
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 2rem;
    }
    th, td {
      border: 1px solid #444;
      padding: 10px;
      text-align: left;
      vertical-align: top;
    }
    th {
      background: #3f5c39;
    }
    tr:nth-child(even) {
      background: #2a402a;
    }
    .cart-item {
      margin-bottom: 4px;
    }
    .delete-btn {
      background:#a00;
      color:#fff;
      border:none;
      padding:6px 12px;
      border-radius:5px;
      cursor:pointer;
    }
    .delete-btn:hover {
      background:#c00;
    }
  </style>
</head>
<body>
  <h1>📦 All Orders</h1>
  
  <?php
  $availableDates = array_unique(array_map(function($o) {
    return substr($o['timestamp'], 0, 10);
  }, $orders));
  sort($availableDates);
?>


  <div style="text-align: center; margin-top: 1rem;">
    <a href="export-orders.php" target="_blank" style="background:#ffd700; color:#000; padding:10px 20px; border-radius:6px; font-weight:bold; text-decoration:none; box-shadow:0 3px 6px rgba(0,0,0,0.3);">
      📤 Export to CSV
    </a>
  </div>
<div style="text-align: center; margin-top: 1rem;">
  <label for="dateFilter" style="margin-right: 10px;">🗓️ Filter by date:</label>
  <select id="dateFilter" onchange="filterByDate()" style="padding: 8px 12px; border-radius: 5px;">
    <option value="all">All Dates</option>
    <?php foreach ($availableDates as $date): ?>
      <option value="<?= $date ?>"><?= $date ?></option>
    <?php endforeach; ?>
  </select>
</div>

<div style="text-align:center; margin-top:20px;">
  <input type="email" id="userEmail" placeholder="Enter your email" style="padding:8px; border-radius:6px; width:250px;" required>
  <button onclick="sendPDFToUser()" style="background:#ffd700; color:#000; padding:10px 20px; border-radius:6px; font-weight:bold; margin-left:10px; cursor:pointer;">
    📄 Send PDF to Email
  </button>
</div>

<div style="text-align: center; margin-top: 1rem;">
  <button onclick="exportToPDF()" style="background:#ffd700; color:#000; padding:10px 20px; border-radius:6px; font-weight:bold; cursor:pointer;">
    📄 Export PDF
  </button>
</div>

  <canvas id="ordersChart" height="80" style="margin: 40px auto; display: block; max-width: 800px;"></canvas>

  <?php if (empty($orders)): ?>
    <p style="color: #f88;">❗ No orders found.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Timestamp</th>
          <th>Client Name</th>
          <th>Email</th>
          <th>Notes</th>
          <th>Cart</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $index => $order): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($order['timestamp']) ?></td>
            <td><?= htmlspecialchars($order['name']) ?></td>
            <td><?= htmlspecialchars($order['email']) ?></td>
            <td><?= nl2br(htmlspecialchars($order['notes'])) ?></td>
            <td>
              <?php foreach ($order['cart'] as $item): ?>
                <div class="cart-item">🛒 <strong><?= htmlspecialchars($item['name']) ?></strong> × <?= intval($item['quantity']) ?></div>
              <?php endforeach; ?>
            </td>
            <td>
              <form method="post" action="delete-order.php" onsubmit="return confirm('Delete this order?');">
                <input type="hidden" name="id" value="<?= $index ?>">
                <button type="submit" class="delete-btn">❌ Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const orderDates = <?php
      $dateCounts = [];
      foreach ($orders as $o) {
        $date = substr($o['timestamp'], 0, 10);
        if (!isset($dateCounts[$date])) $dateCounts[$date] = 0;
        $dateCounts[$date]++;
      }
      echo json_encode($dateCounts);
    ?>;

    const ctx = document.getElementById('ordersChart').getContext('2d');
    const chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: Object.keys(orderDates),
        datasets: [{
          label: '📅 Orders per Day',
          data: Object.values(orderDates),
          backgroundColor: '#ffd700',
          borderColor: '#aa8800',
          borderWidth: 1
        }]
      },
      options: {
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 1
            }
          }
        }
      }
    });
    
    function filterByDate() {
  const selectedDate = document.getElementById('dateFilter').value;
  const rows = document.querySelectorAll('table tbody tr');

  rows.forEach(row => {
    const dateCell = row.children[1].textContent.trim().substring(0, 10);
    if (selectedDate === 'all' || dateCell === selectedDate) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });

  // Филтрираме и графиката
  if (selectedDate !== 'all') {
    chart.data.labels = [selectedDate];
    chart.data.datasets[0].data = [orderDates[selectedDate] || 0];
  } else {
    chart.data.labels = Object.keys(orderDates);
    chart.data.datasets[0].data = Object.values(orderDates);
  }
  chart.update();
}

  </script>
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
  async function sendPDF(recipientEmail) {
    if (!recipientEmail || !recipientEmail.includes("@")) {
      alert("❗ Please enter a valid email address.");
      return;
    }

    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF();
    const table = document.querySelector("table");

    const selectedDate = document.getElementById("dateFilter").value;
    const title = selectedDate === "all" ? "All Orders" : `Orders for ${selectedDate}`;
    const now = new Date().toLocaleString();
    const filename = `orders-${selectedDate}.pdf`;

    const hiddenRows = [];
    document.querySelectorAll("tbody tr").forEach(row => {
      if (row.style.display === "none") {
        hiddenRows.push(row);
        row.style.display = "";
      }
    });

    await html2canvas(table).then(async (canvas) => {
      const imgData = canvas.toDataURL("image/png");
      const width = pdf.internal.pageSize.getWidth();
      const height = (canvas.height * width) / canvas.width;

      pdf.setFontSize(18);
      pdf.text(title, 10, 15);
      pdf.setFontSize(11);
      pdf.setTextColor(100);
      pdf.text(`Generated on: ${now}`, 10, 23);
      pdf.addImage(imgData, "PNG", 10, 30, width - 20, height);

      const pdfBlob = pdf.output("blob");
      const formData = new FormData();
      formData.append("pdf", pdfBlob, filename);
      formData.append("email", recipientEmail);

      const response = await fetch("send-pdf.php", {
        method: "POST",
        body: formData
      });

      const result = await response.json();
      if (result.sent) {
        alert("✅ PDF was sent successfully to: " + recipientEmail);
      } else {
        alert("❌ Failed to send PDF. " + (result.error || ""));
      }

      hiddenRows.forEach(row => row.style.display = "none");
    });
  }

  // 👤 Изпращане до потребителя
  function sendPDFToUser() {
    const email = document.getElementById("userEmail").value.trim();
    sendPDF(email);
  }

  // 🛠️ Изпращане до администратора
  function exportToPDF() {
    sendPDF("gamesinfo@playforall.online");
  }
</script>


</body>

</html>
