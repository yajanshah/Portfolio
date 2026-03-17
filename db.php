<?php
require_once 'config.php';

$isLocal = false;
$serverName = $_SERVER['SERVER_NAME'] ?? '';
if ($serverName === 'localhost' || $serverName === '127.0.0.1') {
    $isLocal = true;
}

$host = $isLocal ? $DB_HOST_LOCAL : $DB_HOST_LIVE;
$user = $isLocal ? $DB_USER_LOCAL : $DB_USER_LIVE;
$pass = $isLocal ? $DB_PASS_LOCAL : $DB_PASS_LIVE;
$dbName = $isLocal ? $DB_NAME_LOCAL : $DB_NAME_LIVE;

$conn = new mysqli($host, $user, $pass, $dbName);

if ($conn->connect_error) {
    error_log("DB connect failed: " . $conn->connect_error);
} else {
    $conn->set_charset("utf8mb4");

    if ($isLocal) {
        $createSql = "CREATE TABLE IF NOT EXISTS contacts (\n"
            . "id INT AUTO_INCREMENT PRIMARY KEY,\n"
            . "name VARCHAR(120) NOT NULL,\n"
            . "email VARCHAR(160) NOT NULL,\n"
            . "phone VARCHAR(40) DEFAULT '',\n"
            . "message TEXT,\n"
            . "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP\n"
            . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        if (!$conn->query($createSql)) {
            error_log("DB create table failed: " . $conn->error);
        }
    }
}

?>








