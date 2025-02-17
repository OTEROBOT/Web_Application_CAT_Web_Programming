<?php
session_start();
include 'config.php';

// รับค่าจากฟอร์ม
$product_name = trim($_POST['product_name']);
$price = ($_POST['price'] ?: 0);
$detail = trim($_POST['detail']);
$image_name = $_FILES['profile_image']['name'];
$image_tmp = $_FILES['profile_image']['tmp_name'];
$folder = 'upload_image/';
$image_location = $folder . $image_name;

if (empty($product_name) || empty($price)) {
    $_SESSION['message'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    header('Location: ' . $base_url . '/product-form.php');
    exit;
}

// ตรวจสอบการอัปโหลดไฟล์
if (!empty($image_name)) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_type = mime_content_type($image_tmp);

    if (!in_array($file_type, $allowed_types)) {
        $_SESSION['message'] = 'ไฟล์ที่อัปโหลดไม่ใช่ประเภทภาพที่รองรับ';
        header('Location: ' . $base_url . '/product-form.php');
        exit;
    }

    // ตรวจสอบขนาดไฟล์ (ขนาดไม่เกิน 2MB)
    if ($_FILES['profile_image']['size'] > 2 * 1024 * 1024) {
        $_SESSION['message'] = 'ขนาดไฟล์ไม่เกิน 2MB';
        header('Location: ' . $base_url . '/product-form.php');
        exit;
    }
}

if (empty($_POST['id'])) {
    // ใช้ prepared statement ป้องกัน SQL Injection
    $query = $conn->prepare("INSERT INTO products (product_name, price, profile_image, detail) VALUES (?, ?, ?, ?)");
    $query->bind_param("siss", $product_name, $price, $image_name, $detail);
    $query->execute();
} else {
    $query_product = $conn->prepare("SELECT * FROM products WHERE id=?");
    $query_product->bind_param("i", $_POST['id']);
    $query_product->execute();
    $result = $query_product->get_result()->fetch_assoc();

    if (empty($image_name)) {
        $image_name = $result['profile_image'];
    } else {
        // ลบไฟล์เก่าก่อน
        @unlink($folder . $result['profile_image']);
    }

    // ใช้ prepared statement สำหรับการอัปเดต
    $query = $conn->prepare("UPDATE products SET product_name=?, price=?, profile_image=?, detail=? WHERE id=?");
    $query->bind_param("sissi", $product_name, $price, $image_name, $detail, $_POST['id']);
    $query->execute();
}

if ($query) {
    // การย้ายไฟล์หลังจากอัปเดตฐานข้อมูล
    if (!empty($image_name)) {
        move_uploaded_file($image_tmp, $image_location);
    }

    $_SESSION['message'] = 'Product Saved successfully';
    header('Location: ' . $base_url . '/index.php');
} else {
    $_SESSION['message'] = 'Product could not be saved!';
    header('Location: ' . $base_url . '/index.php');
}

// ปิดการเชื่อมต่อ
$conn->close();
?>
