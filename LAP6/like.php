<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("กรุณาเข้าสู่ระบบ");
}

$cat_id = $_POST['cat_id'];
$user_id = $_SESSION['user_id'];

// ตรวจสอบก่อนว่าไลค์นี้เคยบันทึกไว้หรือยัง
$sql_check = "SELECT * FROM likes WHERE user_id = $user_id AND cat_id = $cat_id";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows == 0) {
    // เพิ่มการไลค์เข้าไปในฐานข้อมูล
    $conn->query("INSERT INTO likes (user_id, cat_id) VALUES ($user_id, $cat_id)");
}

header("Location: Cat_Web_App.php");
?>
