<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}
$_SESSION['form_time'] = time();

$success = isset($_GET['success']);
$error = $_GET['error'] ?? '';
$mailStatus = $_GET['mail'] ?? '';

$errorMessage = '';
if ($error) {
    if ($error === 'token') {
        $errorMessage = 'Session expired. Please refresh the page and try again.';
    } elseif ($error === 'validation') {
        $errorMessage = 'Please check your name and email and try again.';
    } elseif ($error === 'db') {
        $errorMessage = 'Database error. Please try again later.';
    } else {
        $errorMessage = 'We could not send your message. Please try again.';
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Natural Beekeeping | Contact</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css?v=13" />
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
        <a href="contact.php" class="active">Contact</a>
      </nav>
      <a class="btn btn-primary" href="shop.html">Shop Now</a>
    </div>
  </header>

  <?php if ($success): ?>
    <section class="section">
      <div class="container">
        <div class="notice notice-dismissible">
          <span>Message sent successfully.<?php if ($mailStatus === '0') { echo ' Saved, but email could not be sent.'; } ?></span>
          <button class="notice-close" type="button" aria-label="Dismiss">×</button>
        </div>
      </div>
    </section>
  <?php elseif ($errorMessage): ?>
    <section class="section">
      <div class="container">
        <div class="notice notice-dismissible">
          <span><?php echo htmlspecialchars($errorMessage); ?></span>
          <button class="notice-close" type="button" aria-label="Dismiss">×</button>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <section class="page-hero">
    <div class="container">
      <div class="breadcrumbs">Home / Contact</div>
      <h1>Get In Touch</h1>
      <p>Have questions about our honey or beekeeping services? We would love to hear from you.</p>
    </div>
  </section>

  <section class="section">
    <div class="container contact-grid">
      <form action="save_contact.php" method="POST" class="contact-form">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>" />
        <label>
          Name
          <input type="text" name="name" placeholder="Your name" required />
        </label>
        <label>
          Email
          <input type="email" name="email" placeholder="your@email.com" required />
        </label>
        <label>
          Phone
          <input type="text" name="phone" placeholder="(555) 123-4567" />
        </label>
        <label>
          Message
          <textarea name="message" rows="6" placeholder="Tell us what you're interested in..."></textarea>
        </label>
        <button type="submit" class="btn btn-primary">Send Message</button>
      </form>
      <div class="contact-info">
        <h3>Contact Information</h3>
        <div class="info-item">
          <span class="icon-circle">E</span>
          <div>
            <strong>Email</strong>
            <div>info@beekeeping.com</div>
          </div>
        </div>
        <div class="info-item">
          <span class="icon-circle">P</span>
          <div>
            <strong>Phone</strong>
            <div>(555) 123-4567</div>
          </div>
        </div>
        <div class="info-item">
          <span class="icon-circle">L</span>
          <div>
            <strong>Location</strong>
            <div>Republic of Karelia<br />Russia</div>
          </div>
        </div>
        <div class="visit-card">
          <h4>Visit Our Apiary</h4>
          <p>Tours available by appointment. Experience the fascinating world of bees up close.</p>
          <a class="btn btn-outline" href="https://www.openstreetmap.org/?mlat=63.8&mlon=34.3#map=7/63.8/34.3" target="_blank" rel="noopener noreferrer">Open Map</a>
        </div>
      </div>
    </div>
  </section>

  <section class="section alt">
    <div class="container two-col">
      <div>
        <h2>Hours & Support</h2>
        <p>We respond to all messages within two business days.</p>
        <div class="timeline">
          <div class="timeline-item">
            <span>Customer Support</span>
            <p>Mon-Fri: 9:00 AM - 5:00 PM</p>
          </div>
          <div class="timeline-item">
            <span>Apiary Tours</span>
            <p>Sat: 10:00 AM - 2:00 PM (appointment only)</p>
          </div>
          <div class="timeline-item">
            <span>Wholesale Inquiries</span>
            <p>Custom scheduling available by request.</p>
          </div>
        </div>
      </div>
      <div class="map-shell">
        <div class="map-embed-card">
          <iframe
            class="map-embed"
            title="Natural Beekeeping location map"
            src="https://www.openstreetmap.org/export/embed.html?bbox=29.5%2C61.2%2C39.8%2C67.8&layer=mapnik&marker=63.8%2C34.3"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            allowfullscreen>
          </iframe>
        </div>
      </div>
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
  <script>
    (function () {
      var closeButtons = document.querySelectorAll('.notice-close');
      closeButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
          var notice = btn.closest('.notice');
          if (notice) notice.remove();
          if (window.history && window.history.replaceState) {
            var cleanUrl = window.location.pathname;
            window.history.replaceState({}, document.title, cleanUrl);
          }
        });
      });
      if (window.history && window.history.replaceState) {
        var url = window.location.pathname;
        if (window.location.search) {
          window.history.replaceState({}, document.title, url);
        }
      }
    })();
  </script>
</body>
</html>











