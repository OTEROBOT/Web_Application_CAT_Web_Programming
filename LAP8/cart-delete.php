<?php
session_start();
include 'config.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array(); // ตรวจสอบว่า cart ถูกสร้างหรือยัง
}

if (!empty($_GET['id'])) {  
    $id = $_GET['id'];
    unset($_SESSION['cart'][$id]); // ✅ แก้พิมพ์ผิดจาก "unsset" เป็น "unset"
    
    $_SESSION['message'] = 'Cart delete success';
}

header('Location: ' . $base_url . '/cart.php'); // ✅ เปลี่ยนไปหน้า cart.php
exit();
?>
