<?php
session_start();
include 'db_connect.php';
if ($_SESSION['role'] !== 'admin') { die("ไม่มีสิทธิ์เข้าถึง"); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name_th = $_POST['name_th'];
    $name_en = $_POST['name_en'];
    $desc = $_POST['description'];
    $char = $_POST['characteristics'];
    $care = $_POST['care_instructions'];

    // การอัปโหลดไฟล์รูปภาพ
    $target_dir = "images/"; // โฟลเดอร์สำหรับเก็บรูปภาพ
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    // บันทึกข้อมูลลงฐานข้อมูล
    $conn->query("INSERT INTO catbreeds (name_th, name_en, description, characteristics, care_instructions, image_url, is_visible) 
                  VALUES ('$name_th', '$name_en', '$desc', '$char', '$care', '$target_file', 1)");

    header("Location: Cat_Web_App.php");
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มสายพันธุ์แมว</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #F7F8F9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 900px;
        }
        h1 {
            color: #FF6F61;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 8px 0;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form-group input[type="file"] {
            border: none;
            padding: 0;
        }
        button {
            background-color: #61B6B0;
            color: #fff;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            width: 100%;
            max-width: 250px;
            margin: auto;
            display: block;
        }
        button:hover {
            background-color: #FF6F61;
            transform: scale(1.05);
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            text-decoration: none;
            color: #61B6B0;
            font-weight: bold;
            margin: 0 10px;
            transition: color 0.3s;
        }
        .back-link a:hover {
            color: #FF6F61;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>เพิ่มสายพันธุ์แมว</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" name="name_th" placeholder="ชื่อไทย" required>
            </div>
            <div class="form-group">
                <input type="text" name="name_en" placeholder="ชื่ออังกฤษ" required>
            </div>
            <div class="form-group">
                <textarea name="description" placeholder="คำอธิบาย" required></textarea>
            </div>
            <div class="form-group">
                <textarea name="characteristics" placeholder="ลักษณะ" required></textarea>
            </div>
            <div class="form-group">
                <textarea name="care_instructions" placeholder="การเลี้ยงดู" required></textarea>
            </div>
            <div class="form-group">
                <input type="file" name="image" accept="image/*" required>
            </div>
            <div class="form-group">
                <button type="submit">เพิ่มสายพันธุ์แมว</button>
            </div>
        </form>
        <div class="back-link">
            <a href="admin_dashboard.php">(กลับสู่หน้าหลัก Admin)</a>
            <a href="Cat_Web_App.php">(กลับสู่หน้าหลักแมว)</a>
        </div>
    </div>
</body>
</html>
