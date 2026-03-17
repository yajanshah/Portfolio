<?php
session_start();
require_once 'config.php';

if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: admin.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (hash_equals($ADMIN_USER, $username) && hash_equals($ADMIN_PASS, $password)) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit();
    }
    $error = 'Invalid username or password.';
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Natural Beekeeping | Admin Login</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css?v=3?v=3?v=2" />
</head>
<body>
  <header class="site-header">
    <div class="container nav-bar">
      <a class="brand" href="index.html">
        <span class="brand-icon"><img src="images/branding/icon.png?v=10" alt="Natural Beekeeping" /></span>
        <span class="brand-name">Natural Beekeeping</span>
      </a>
      <nav class="nav-links">
        <a href="index.html">Home</a>
        <a href="shop.html">Shop</a>
        <a href="services.html">Services</a>
        <a href="about.html">About</a>
        <a href="contact.php">Contact</a>
      </nav>
      <a class="btn btn-primary" href="shop.html">Shop Now</a>
    </div>
  </header>

  <section class="page-hero">
    <div class="container">
      <div class="breadcrumbs">Admin / Login</div>
      <h1>Admin Login</h1>
      <p>Use your admin credentials to access messages.</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <?php if ($error): ?>
        <div class="notice"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>
      <form method="POST" class="contact-form" style="max-width:520px;">
        <label>
          Username
          <input type="text" name="username" required />
        </label>
        <label>
          Password
          <input type="password" name="password" required />
        </label>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
  </section>

  <footer class="site-footer">
    <div class="container footer-grid">
      <div>
        <h4>About Us</h4>
        <p>Dedicated to sustainable beekeeping and producing the finest raw honey since 2015.</p>
      </div>
      <div>
        <h4>Quick Links</h4>
        <a href="shop.html">Shop Honey</a>
        <a href="services.html">Services</a>
        <a href="classes.html">Classes</a>
        <a href="about.html">About</a>
      </div>
      <div>
        <h4>Resources</h4>
        <a href="guide.html">Beekeeping Guide</a>
        <a href="blog.html">Blog</a>
        <a href="faq.html">FAQ</a>
        <a href="contact.php">Contact</a>
      </div>
      <div>
        <h4>Follow Us</h4>
        <div class="socials">
          <a href="#" aria-label="Facebook">f</a>
          <a href="#" aria-label="Instagram">i</a>
          <a href="#" aria-label="Twitter">t</a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">&copy; 2026 Natural Beekeeping. All rights reserved.</div>
  </footer>
  <script src="script.js"></script>
</body>
</html>







