<?php
session_start();
include 'config.php';

if (!empty($_GET['id'])) {
    // ดึงข้อมูลสินค้าที่ต้องการลบ
    $query_product = mysqli_query($conn, "SELECT * FROM products WHERE id='{$_GET['id']}'");
    $result = mysqli_fetch_assoc($query_product);

    if ($result && !empty($result['profile_image'])) {
        $image_path = 'upload_image/' . $result['profile_image'];

        // เช็คว่าไฟล์มีอยู่ก่อนทำการลบ
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    // ลบสินค้าออกจากฐานข้อมูล
    $query = mysqli_query($conn, "DELETE FROM products WHERE id='{$_GET['id']}'") or die('Query failed: ' . mysqli_error($conn));
    mysqli_close($conn);

    if ($query) {
        $_SESSION['message'] = 'Product Deleted successfully';
    } else {
        $_SESSION['message'] = 'Product could not be deleted!';
    }

    header('Location: ' . $base_url . '/index.php');
    exit;
}
?>
