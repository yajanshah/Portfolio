<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/php-error.log');

session_start();
require_once 'db.php';
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php?error=1');
    exit();
}

$connOk = isset($conn) && $conn instanceof mysqli && !$conn->connect_error;
if (!$connOk) {
    error_log('Contact form DB not available.');
    header('Location: contact.php?error=db');
    exit();
}

$token = $_POST['csrf_token'] ?? '';
$sessionToken = $_SESSION['csrf_token'] ?? '';
$requireCsrf = !empty($sessionToken);
if ($requireCsrf && (!$token || !hash_equals($sessionToken, $token))) {
    header('Location: contact.php?error=token');
    exit();
}

unset($_SESSION['csrf_token'], $_SESSION['form_time']);

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: contact.php?error=validation');
    exit();
}

$name = substr($name, 0, 120);
$email = substr($email, 0, 160);
$phone = substr($phone, 0, 40);
$message = substr($message, 0, 2000);

$stmt = $conn->prepare('INSERT INTO contacts (name,email,phone,message) VALUES (?,?,?,?)');
if (!$stmt) {
    error_log('Contact insert prepare failed: ' . $conn->error);
    header('Location: contact.php?error=db');
    exit();
}
$stmt->bind_param('ssss', $name, $email, $phone, $message);
$ok = $stmt->execute();
$stmt->close();

$mailSent = false;
if ($ok) {
    $subject = 'New contact message from ' . $name;
    $body = "Name: $name\nEmail: $email\nPhone: $phone\nMessage:\n$message\n";
    $headers = 'From: ' . $SITE_FROM . "\r\n";
    $headers .= 'Reply-To: ' . $email . "\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
    $mailSent = @mail($ADMIN_EMAIL, $subject, $body, $headers);
}

if ($ok) {
    header('Location: contact.php?success=1&mail=' . ($mailSent ? '1' : '0'));
} else {
    header('Location: contact.php?error=1');
}

exit();
?>




