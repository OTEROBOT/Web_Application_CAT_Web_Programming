<?php
session_start();
include 'config.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array(); // ตรวจสอบว่า cart ถูกสร้างหรือยัง
}

if (!empty($_GET['id'])) {  // ✅ แก้จาก 'if' เป็น 'id'
    $id = $_GET['id'];

    if (empty($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 1;  // ถ้ายังไม่มีสินค้า ให้เพิ่ม 1 ชิ้น
    } else {
        $_SESSION['cart'][$id] += 1; // ถ้ามีอยู่แล้วให้เพิ่มขึ้นอีก 1
    }

    $_SESSION['message'] = 'Cart add success';
}

header('Location: ' . $base_url . '/product-list.php');
exit();
?>
