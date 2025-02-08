<?php
session_start();
include 'db_connect.php'; // เพิ่มบรรทัดนี้เพื่อลิงก์ไปยังไฟล์เชื่อมต่อฐานข้อมูล

// ตรวจสอบบทบาทของผู้ใช้
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$isUser = isset($_SESSION['role']) && $_SESSION['role'] === 'user';

// ดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT * FROM catbreeds WHERE is_visible = 1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แมวยอดนิยม</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; text-align: center; margin: 0; padding: 0; }
        .container { width: 80%; margin: auto; overflow: hidden; padding-top: 20px; }
        .card { background: white; padding: 20px; margin: 20px 0; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 10px; text-align: left; }
        img { max-width: 100%; height: auto; border-radius: 10px; margin-bottom: 10px; }
        .admin-controls { margin-top: 10px; }
        button, a {
            background-color: #B6E0D9;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            margin: 5px;
            transition: background-color 0.3s;
        }
        button:hover, a:hover {
            background-color: #FF9B9B;
        }
        .header-links {
            margin-bottom: 20px;
        }
        .header-links a {
            font-weight: bold;
            margin: 0 10px;
            color: #FF9B9B;
            text-decoration: none;
        }
        .header-links a:hover {
            color: #333;
        }
        .back-link {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #FF9B9B;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .back-link:hover {
            background-color: #B6E0D9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>สายพันธุ์แมวยอดนิยม</h1>
        
        <div class="header-links">
            <?php if (!isset($_SESSION['user_id'])) { ?>
                <a href="login.php">เข้าสู่ระบบ</a> | <a href="register.php">สมัครสมาชิก</a>
            <?php } else { ?>
                <a href="logout.php">ออกจากระบบ</a>
            <?php } ?>

            <?php if ($isAdmin) { echo "<span>คุณเป็นผู้ดูแลระบบ</span><a href='add_cat.php'>เพิ่มสายพันธุ์แมว</a><a href='admin_dashboard.php'>กลับหน้าหลัก Admin</a>"; } ?>
        </div>

        <!-- เพิ่มลิงก์กลับไปที่ user_dashboard.php -->
        <?php if ($isUser) { ?>
            <a href="user_dashboard.php" class="back-link">กลับไปหน้าหลักผู้ใช้</a>
        <?php } ?>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="card">
                <h2><?php echo $row['name_th']; ?> (<?php echo $row['name_en']; ?>)</h2>
                <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name_th']; ?>">
                <p><strong>คำอธิบาย:</strong> <?php echo $row['description']; ?></p>
                <p><strong>ลักษณะ:</strong> <?php echo $row['characteristics']; ?></p>
                <p><strong>การเลี้ยงดู:</strong> <?php echo $row['care_instructions']; ?></p>

                <?php if ($isUser) { ?>
                    <form action="like.php" method="post">
                        <input type="hidden" name="cat_id" value="<?php echo $row['id']; ?>">
                        <button type="submit">ถูกใจ ❤️</button>
                    </form>
                <?php } ?>

                <?php if ($isAdmin) { ?>
                    <div class="admin-controls">
                        <a href="edit_cat.php?id=<?php echo $row['id']; ?>" class="button">แก้ไข</a>
                        <a href="delete_cat.php?id=<?php echo $row['id']; ?>" class="button" onclick="return confirm('ยืนยันการลบ?');">ลบ</a>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
