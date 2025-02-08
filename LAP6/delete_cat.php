<?php
session_start();
include 'db_connect.php';

if ($_SESSION['role'] !== 'admin') { 
    die("ไม่มีสิทธิ์เข้าถึง");
}

$id = intval($_GET['id']); // ป้องกัน SQL Injection

// เริ่ม Transaction เพื่อป้องกันปัญหาความผิดพลาด
$conn->begin_transaction();

try {
    // ลบข้อมูลที่เกี่ยวข้องจากตาราง likes ก่อน
    $conn->query("DELETE FROM likes WHERE cat_id = $id");

    // ลบข้อมูลจาก catbreeds
    $conn->query("DELETE FROM catbreeds WHERE id = $id");

    // Commit การลบ
    $conn->commit();
    
    // กลับไปหน้าหลัก
    header("Location: Cat_Web_App.php");
    exit();
} catch (Exception $e) {
    // กรณีเกิดข้อผิดพลาด ให้ rollback ข้อมูล
    $conn->rollback();
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}
?>
