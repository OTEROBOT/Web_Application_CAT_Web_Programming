<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include '../db.php';
try {
$stmt = $dbh->prepare("SELECT * FROM attractions WHERE id=:id");
$stmt->bindParam(':id', $_GET['id']);
$stmt->execute();

foreach ($stmt as $row) {
$attraction = array(
'id' => $row['id'],
'name' => $row['name'],
'coverimage' => $row['coverimage'],
'detail' => $row['detail'],
'latitude' => $row['latitude'],
'longitude' => $row['longitude'],
);
echo json_encode($attraction);
}

$dbh = null;
} catch (PDOException $e) {
print "Error!: " . $e->getMessage()."<br/>";
die();
}
?>