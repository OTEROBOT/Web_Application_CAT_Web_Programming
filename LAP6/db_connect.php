<?php
$servername = "localhost";
$username = "root";
$password = ""; // ปกติถ้าใช้ XAMPP จะเป็นค่าว่าง
$dbname = "cat_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
