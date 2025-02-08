<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';

// ดึงข้อมูลการไลค์ของผู้ใช้
$user_id = $_SESSION['user_id'];
$sql = "SELECT catbreeds.name_th, catbreeds.name_en, catbreeds.image_url FROM likes 
        JOIN catbreeds ON likes.cat_id = catbreeds.id 
        WHERE likes.user_id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>หน้าหลักผู้ใช้</title>
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
            text-align: center;
            margin-bottom: 20px;
        }
        .nav a {
            background-color: #B6E0D9;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .nav a:hover {
            background-color: #FF9B9B;
        }
        .liked-cats {
            margin-top: 30px;
            text-align: center;
        }
        .liked-cats h2 {
            color: #FF9B9B;
            margin-bottom: 20px;
        }
        .liked-cats .cat-card {
            display: inline-block;
            width: 200px;
            margin: 10px;
            text-align: center;
            background-color: #fff;
            padding: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .liked-cats img {
            max-width: 100%;
            border-radius: 10px;
        }
        .logout {
            text-align: center;
            margin-top: 20px;
        }
        .logout a {
            background-color: #B6E0D9;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .logout a:hover {
            background-color: #FF9B9B;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ยินดีต้อนรับ <?php echo $_SESSION['username']; ?> (User)</h1>
        <div class="nav">
            <a href="Cat_Web_App.php">กลับสู่หน้าหลักแมว</a>
        </div>

        <div class="liked-cats">
            <h2>แมวที่คุณกดไลค์</h2>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="cat-card">
                    <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name_th']; ?>">
                    <h3><?php echo $row['name_th']; ?> (<?php echo $row['name_en']; ?>)</h3>
                </div>
            <?php } ?>
        </div>

        <div class="logout">
            <a href="logout.php">ออกจากระบบ</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
