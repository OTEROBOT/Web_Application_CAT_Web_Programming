<?php
// Database Connection
$servername = "localhost";
$username = "its66040233110";
$password = "H5mbS4C8";
$dbname = "its66040233110";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Data from Database
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        .card {
            background: white;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>สายพันธุ์แมวยอดนิยม</h1>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="card">
                <h2><?php echo $row['name_th']; ?> (<?php echo $row['name_en']; ?>)</h2>
                <img src="images<?php echo $row['image_url']; ?>" alt="<?php echo $row['name_th']; ?>">
                <p><strong>คำอธิบาย:</strong> <?php echo $row['description']; ?></p>
                <p><strong>ลักษณะ:</strong> <?php echo $row['characteristics']; ?></p>
                <p><strong>การเลี้ยงดู:</strong> <?php echo $row['care_instructions']; ?></p>
            </div>
        <?php } ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
