<?php
$servername = "localhost";
$username = "its66040233110";
$password = "H5mbS4C8"; // ปกติถ้าใช้ XAMPP จะเป็นค่าว่าง
$dbname = "its66040233110";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตั้งค่า charset เป็น utf8mb4
$conn->set_charset("utf8mb4");
?>
