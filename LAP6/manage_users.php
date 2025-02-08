<?php
// สมมติว่าคุณมีการเชื่อมต่อฐานข้อมูลแล้ว
include 'db_connect.php';

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$query = "SELECT id, username, email, role FROM users";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการผู้ใช้</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #ffb3b3; /* สีพาสเทล */
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f4f4f4;
        }
        tr:hover {
            background-color: #e6e6e6;
        }
        a {
            text-decoration: none;
            color: #4c4c4c;
            font-weight: bold;
        }
        a:hover {
            color: #ff6666;
        }
        .btn {
            padding: 10px 15px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            background-color: #ff6666;
            color: white;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #ff4d4d;
        }
        .no-data {
            text-align: center;
            color: #888;
        }
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
        .btn-main {
            background-color: #6a89cc;
        }
        .btn-main:hover {
            background-color: #4a69bd;
        }
        .btn-logout {
            background-color: #f39c12;
        }
        .btn-logout:hover {
            background-color: #e67e22;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>จัดการผู้ใช้</h2>
        <?php
        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>ชื่อผู้ใช้</th>
                        <th>อีเมล</th>
                        <th>บทบาท</th>
                        <th>การจัดการ</th>
                    </tr>";
            
            // แสดงข้อมูลผู้ใช้
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['username']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['role']}</td>
                        <td>
                            <a href='edit_user.php?id={$row['id']}' class='btn'>แก้ไข</a> |
                            <a href='delete_user.php?id={$row['id']}' class='btn' onclick=\"return confirm('ยืนยันการลบ?');\">ลบ</a>
                        </td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-data'>ไม่พบผู้ใช้ในระบบ</p>";
        }
        ?>
        
        <!-- ปุ่ม "กลับหน้าหลัก Admin" และ "ออกจากระบบ" -->
        <div class="btn-container">
            <a href="admin_dashboard.php" class="btn btn-main">กลับหน้าหลัก Admin</a>
            <a href="logout.php" class="btn btn-logout">ออกจากระบบ</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
