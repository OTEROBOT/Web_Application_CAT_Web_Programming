<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>หน้าหลักผู้ดูแลระบบ</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #F7F8F9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #FF9B9B;
            text-align: center;
        }
        .nav {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .nav a {
            background-color: #B6E0D9;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 25px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .nav a:hover {
            background-color: #FF9B9B;
        }
        .logout {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ยินดีต้อนรับ <?php echo $_SESSION['username']; ?> (Admin)</h1>
        <div class="nav">
            <a href="manage_users.php">จัดการผู้ใช้</a>
            <a href="add_cat.php">เพิ่มสายพันธุ์แมว</a>
            <a href="Cat_Web_App.php">ไปหน้าหลักแมว</a>
        </div>
        <div class="logout">
            <a href="logout.php">ออกจากระบบ</a>
        </div>
    </div>
</body>
</html>
