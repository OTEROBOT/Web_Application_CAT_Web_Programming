<?php
session_start();
include 'db_connect.php';
if ($_SESSION['role'] !== 'admin') { die("ไม่มีสิทธิ์เข้าถึง"); }

$id = $_GET['id'];
$cat = $conn->query("SELECT * FROM catbreeds WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name_th = $_POST['name_th'];
    $name_en = $_POST['name_en'];
    $desc = $_POST['description'];
    $char = $_POST['characteristics'];
    $care = $_POST['care_instructions'];

    // การอัปเดตรูปภาพ
    if ($_FILES['cat_image']['name']) {
        $image = $_FILES['cat_image']['name'];
        $image_tmp = $_FILES['cat_image']['tmp_name'];
        $image_size = $_FILES['cat_image']['size'];
        $image_error = $_FILES['cat_image']['error'];
        
        // ตรวจสอบความถูกต้องของไฟล์
        if ($image_error === 0) {
            $image_ext = pathinfo($image, PATHINFO_EXTENSION);
            $image_ext = strtolower($image_ext);
            $allowed = array('jpg', 'jpeg', 'png');
            if (in_array($image_ext, $allowed) && $image_size <= 2000000) { // จำกัดขนาดไฟล์ไม่เกิน 2MB
                $image_new_name = uniqid('', true) . '.' . $image_ext;
                $image_upload_path = 'uploads/' . $image_new_name;
                move_uploaded_file($image_tmp, $image_upload_path);
                // อัปเดตข้อมูลรูปภาพในฐานข้อมูล
                $conn->query("UPDATE catbreeds SET name_th='$name_th', name_en='$name_en', description='$desc', characteristics='$char', care_instructions='$care', image='$image_new_name' WHERE id=$id");
            }
        }
    } else {
        // หากไม่มีการเลือกไฟล์ จะไม่มีการอัปเดตรูปภาพ
        $conn->query("UPDATE catbreeds SET name_th='$name_th', name_en='$name_en', description='$desc', characteristics='$char', care_instructions='$care' WHERE id=$id");
    }

    header("Location: Cat_Web_App.php");
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลสายพันธุ์แมว</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #F7F8F9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            background-color: #FFF;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #FF9B9B;
            font-size: 2rem;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 5px 0;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        .form-group textarea {
            height: 150px;
        }
        .form-group input:focus, .form-group textarea:focus {
            border-color: #FF9B9B;
            outline: none;
        }
        button {
            background-color: #B6E0D9;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 1.1rem;
        }
        button:hover {
            background-color: #FF9B9B;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #FF9B9B;
            text-decoration: none;
            font-weight: bold;
            margin-right: 10px;
        }
        .back-link a:hover {
            color: #333;
        }
        .image-preview {
            text-align: center;
            margin-bottom: 20px;
        }
        .image-preview img {
            width: 150px;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>แก้ไขข้อมูลสายพันธุ์แมว</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" name="name_th" value="<?php echo $cat['name_th']; ?>" placeholder="ชื่อไทย" required>
            </div>
            <div class="form-group">
                <input type="text" name="name_en" value="<?php echo $cat['name_en']; ?>" placeholder="ชื่ออังกฤษ" required>
            </div>
            <div class="form-group">
                <textarea name="description" placeholder="คำอธิบาย" required><?php echo $cat['description']; ?></textarea>
            </div>
            <div class="form-group">
                <textarea name="characteristics" placeholder="ลักษณะ" required><?php echo $cat['characteristics']; ?></textarea>
            </div>
            <div class="form-group">
                <textarea name="care_instructions" placeholder="การเลี้ยงดู" required><?php echo $cat['care_instructions']; ?></textarea>
            </div>
            <div class="form-group">
                <input type="file" name="cat_image" accept="image/*">
            </div>
            <div class="back-link">
                <button type="submit">อัปเดตข้อมูล</button>
            </div>
        </form>
        <div class="back-link">
            <a href="admin_dashboard.php">(กลับสู่หน้าหลัก Admin)</a>
            <a href="Cat_Web_App.php">(กลับสู่หน้าหลักแมว)</a>
        </div>
    </div>
</body>
</html>
