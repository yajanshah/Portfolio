<?php
session_start();
require_once 'db.php';
require_once 'config.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

$result = $conn->query("SELECT id, name, email, phone, message, created_at FROM contacts ORDER BY created_at DESC");
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Natural Beekeeping | Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css?v=10" />
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
      <a class="btn btn-primary" href="admin.php?logout=1">Logout</a>
    </div>
  </header>

  <section class="page-hero">
    <div class="container">
      <div class="breadcrumbs">Admin / Messages</div>
      <h1>Contact Messages</h1>
      <p>View all contact form submissions in one place.</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <table class="table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Message</th>
            
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="5">No messages yet.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
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








