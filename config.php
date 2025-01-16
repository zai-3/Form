<?php
// config.php - Database connection
$host = 'localhost';  // Replace with your database host
$dbname = 'service_requests';  // Database name
$username = 'root';  // Database username (default for XAMPP/MAMP is 'root')
$password = '';  // Database password (default for XAMPP/MAMP is empty)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
