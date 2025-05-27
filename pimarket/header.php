<?php
$pageClass = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>pAImarket</title>

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



    /* 🎨 Backgrounds per page */
    body.index            { background: #334f2f; }
    body.cart             { background: #4c386d; }
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
      background: #a19b7f;
      color: #ffffff;
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
      background: #585c39;
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
      background: #273c4d;
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
    
    
.search-translate-wrap {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  gap: 10px;
  margin: 10px auto;
  max-width: 600px;
  padding: 10px;
  border-radius: 12px;
  background: linear-gradient(to right, #4b0082, #8a2be2); /* 💜 виолетово */
  box-shadow: 0 0 8px rgba(138, 43, 226, 0.4);
}

.search-translate-wrap form {
  display: flex;
  flex: 1;
  justify-content: center;
  gap: 8px;
}

.search-translate-wrap input[type="text"] {
  padding: 8px 12px;
  font-size: 15px;
  border-radius: 8px;
  border: 1px solid #ccc;
  flex: 1;
  min-width: 160px;
}

.search-translate-wrap button {
  background: #ffd700;
  color: #000;
  padding: 8px 16px;
  border: none;
  border-radius: 8px;
  font-weight: bold;
  cursor: pointer;
  box-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

/* За малки екрани – подрежда вертикално */
@media (max-width: 480px) {
  .search-translate-wrap {
    flex-direction: column;
    gap: 6px;
  }

  .search-translate-wrap form {
    width: 100%;
  }
}

.featured-banner {
  text-align: center;
  font-size: 2rem;
  margin-bottom: 1rem;
  color: #ffd700;
  text-shadow: 1px 1px 2px #000;
  background: linear-gradient(to right, #443300, #665500);
  padding: 0.5rem 1rem;
  border-radius: 12px;
  display: inline-block;
  margin: 1rem auto;
  box-shadow: 0 0 12px rgba(255, 215, 0, 0.3);
}


  </style>

 


</head>
 <div class="search-translate-wrap">
  <div id="gtranslate"></div>

  <form method="GET" action="/pimarket/index.php">
    <input type="text" name="search" placeholder="🔍 Search for a product..." />
    <button type="submit">Search</button>
  </form>
</div>

<a href="vision.html" class="button">🌱 Vision</a>


<body class="<?= htmlspecialchars($pageClass) ?>">
