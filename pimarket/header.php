<?php
$pageClass = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PiMarket</title>

  <!-- 🌍 GTranslate -->
  <script>
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({
        pageLanguage: 'en',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
      }, 'gtranslate');
    }
  </script>
  <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

  <style>
    body {
      margin: 0;
      padding: 2rem;
      font-family: sans-serif;
      color: #fff;
    }

#gtranslate {
  position: fixed;
  top: 2px;
  right: 2px;
  z-index: 9999;
  background: #000;
  padding: 1px 6px;
  border-radius: 6px;
  box-shadow: 0 0 4px gold;
  font-size: 12px;
  height: auto;
  display: flex;
  align-items: center;
  max-width: 160px;
}

#gtranslate select {
  background: transparent;
  color: #fff;
  border: none;
  font-weight: bold;
  cursor: pointer;
  font-size: 12px;
  width: 100%;
}


    /* 🎨 Backgrounds per page */
    body.index            { background: #334f2f; }
    body.cart             { background: #4d2d2d; }
    body.login            { background: #1d2f1d; }
    body.dashboard        { background: #223344; }
    body.add-product      { background: #335544; }
    body.edit-product     { background: #2d3f2f; }
    body.checkout         { background: #2c2c3c; }
    body.view-orders      { background: #2e3d2f; }
    body.page-shop        { background: #003322; }
    body.single-product   { background: #213321; }
    body.archived-products{ background: #2b3a2f; }
    body.view-log         { background: #1e2e1b; font-family: monospace; }

    /* 🧩 Common Form Styles */
    form {
      background: rgba(0,0,0,0.1);
      padding: 2rem;
      border-radius: 10px;
      max-width: 500px;
      margin: auto;
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      border: none;
    }

    button, .button {
      background: #6c6438;
      color: #fffff;
      padding: 10px 20px;
      font-weight: bold;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
    }

    .msg {
      text-align: center;
      margin-top: 1rem;
      color: #90ee90;
    }

    .error {
      color: #ff6b6b;
      text-align: center;
    }

    /* 🧾 Dashboard */
    .section {
      background: #3f5c39;
      padding: 2rem;
      border-radius: 10px;
      max-width: 600px;
      margin: 2rem auto;
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }

    a {
      color: #fffff;
      text-decoration: underline;
      display: block;
      margin: 0.5rem 0;
      text-shadow: 0.5px 0.5px 1px #0a0a0a;
    }

    /* 🛒 Product Grid */
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1.5rem;
      padding: 1rem;
      margin: auto;
      max-width: 1400px;
    }

    .product-card {
      background: #3f5c39;
      padding: 1rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
      text-align: center;
      color: #fff;
      transition: transform 0.2s ease;
    }

    .product-card:hover {
      transform: scale(1.03);
    }

    .product-card img {
      max-width: 100%;
      height: 140px;
      object-fit: cover;
      border-radius: 8px;
    }

    /* 👤 Login Wrapper */
    .login-wrapper {
      display: flex;
      gap: 2rem;
      background: #2f442f;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.4);
      padding: 2rem;
      flex-wrap: wrap;
      max-width: 800px;
      margin: 2rem auto;
    }

    .login-form {
      flex: 1 1 300px;
      min-width: 260px;
    }

    .side-info {
      flex: 1 1 250px;
      background: #263c26;
      color: #ffd700;
      padding: 1rem;
      border-radius: 10px;
      font-size: 0.95rem;
      line-height: 1.6;
      max-width: 300px;
    }

    /* 📜 View Log */
    body.view-log pre {
      background: #3f5c39;
      padding: 1rem;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.4);
      white-space: pre-wrap;
      max-width: 900px;
      margin: 2rem auto;
    }

    /* 🧬 Single Product */
    .container {
      max-width: 800px;
      margin: auto;
      background: #3f5c39;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.5);
    }

    .container img {
      max-width: 100%;
      border-radius: 10px;
      margin-bottom: 1rem;
    }

    /* ✅ Responsive */
    @media (max-width: 768px) {
      .product-grid {
        grid-template-columns: 1fr;
      }

      .login-wrapper {
        flex-direction: column;
        padding: 1rem;
      }

      .side-info {
        text-align: center;
        max-width: 100%;
      }
    }
  </style>
</head>
<body class="<?= htmlspecialchars($pageClass) ?>">
  <div id="gtranslate"></div>
