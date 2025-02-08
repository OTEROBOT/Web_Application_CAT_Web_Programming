<?php
// เชื่อมต่อฐานข้อมูล
include 'db_connect.php';

// ตรวจสอบว่ามีการส่งค่า id มาหรือไม่
if (!isset($_GET['id'])) {
    echo "ไม่มีข้อมูลผู้ใช้ที่ต้องการแก้ไข";
    exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "ไม่พบผู้ใช้ในระบบ";
    exit();
}

// เมื่อกดปุ่มอัปเดต
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $update_query = "UPDATE users SET username=?, email=?, role=? WHERE id=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssi", $username, $email, $role, $id);

    if ($stmt->execute()) {
        echo "<script>alert('อัปเดตข้อมูลสำเร็จ!'); window.location.href='manage_users.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดต');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>แก้ไขผู้ใช้</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #ffe6f2; /* พื้นหลังสีพาสเทลโทนแมว */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fffaf5;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            color: #ff85a2;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            text-align: left;
            font-weight: bold;
            color: #6b4f4f;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid #ffccd5;
            border-radius: 8px;
            font-size: 16px;
        }
        .btn {
            background-color: #ff85a2;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            margin-top: 10px; /* เพิ่มระยะห่าง */
            display: block; /* ทำให้ปุ่มเป็นบล็อกอยู่คนละบรรทัด */
        }
        .btn:hover {
            background-color: #ff6699;
        }
        .btn-cancel {
            background-color: #b8b8b8;
            text-decoration: none;
        }
        .btn-cancel:hover {
            background-color: #999;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>แก้ไขข้อมูลผู้ใช้</h2>
    <form method="POST">
        <label>ชื่อผู้ใช้:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

        <label>อีเมล:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label>บทบาท:</label>
        <select name="role" required>
            <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
        </select>

        <button type="submit" class="btn">อัปเดตข้อมูล</button>
        <a href="manage_users.php" class="btn btn-cancel">ยกเลิก</a>
    </form>
</div>

</body>
</html>
