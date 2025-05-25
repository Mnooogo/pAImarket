<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  header('Location: login.php');
  exit;
}

$pdfFolder = __DIR__ . '/pdf-orders/';
$pdfFiles = [];

if (is_dir($pdfFolder)) {
  $files = scandir($pdfFolder);
  foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
      $pdfFiles[] = $file;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>📁 PDF Archive</title>
  <style>
    body {
      font-family: sans-serif;
      background: #202c20;
      color: #fff;
      padding: 2rem;
    }
    h1 {
      text-align: center;
      color: #ffd700;
    }
    ul {
      list-style: none;
      padding: 0;
      max-width: 600px;
      margin: auto;
    }
    li {
      background: #3f5c39;
      margin: 10px 0;
      padding: 12px 20px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.4);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    a.download {
      background: #ffd700;
      color: #000;
      text-decoration: none;
      padding: 6px 12px;
      border-radius: 6px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <h1>📁 Archived Order PDFs</h1>
  <ul>
    <?php if (empty($pdfFiles)): ?>
      <li>No archived PDFs found.</li>
    <?php else: ?>
      <?php foreach ($pdfFiles as $file): ?>
        <li>
          <?= htmlspecialchars($file) ?>
          <a href="pdf-orders/<?= urlencode($file) ?>" class="download" download>📥 Download</a>
        </li>
      <?php endforeach; ?>
    <?php endif; ?>
  </ul>
</body>
</html>
