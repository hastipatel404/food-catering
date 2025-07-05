<?php
$host = 'localhost';
$dbname = 'food_catering';
$user = 'root';
$pass = ''; // Default for XAMPP. If using password, add here.

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    // Set error mode to Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; // Optional debug message
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
