<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete_query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('ลบผู้ใช้สำเร็จ'); window.location='manage_users.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการลบ');</script>";
    }
}
$conn->close();
?>
