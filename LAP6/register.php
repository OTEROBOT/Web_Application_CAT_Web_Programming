<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role']; // รับค่าบทบาทที่เลือก
    $email = trim($_POST['email']); // รับค่าอีเมลจากฟอร์ม
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // ตรวจสอบว่าชื่อผู้ใช้มีอยู่ในฐานข้อมูลแล้วหรือยัง
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "ชื่อผู้ใช้หรืออีเมลนี้ถูกใช้ไปแล้ว!";
    } else {
        // บันทึกข้อมูลผู้ใช้ใหม่ลงในฐานข้อมูล
        $stmt = $conn->prepare("INSERT INTO users (username, password, role, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashed_password, $role, $email); // เพิ่มการส่งค่า email
        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $error = "เกิดข้อผิดพลาด!";
        }
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #a1c4fd, #c2e9fb);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #6a89cc;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #4a69bd;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>สมัครสมาชิก</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="ชื่อผู้ใช้" required>
            <input type="password" name="password" placeholder="รหัสผ่าน" required>
            <input type="email" name="email" placeholder="อีเมล" required> <!-- ฟิลด์อีเมล -->
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">สมัครสมาชิก</button>
        </form>
        <p>มีบัญชีแล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
    </div>
</body>
</html>
