<?php
header('Content-Type: application/json');
include_once "../includes/connection.php";

$query = "SELECT * FROM stocks";
$result = mysqli_query($conn, $query);

$stocks = [];
while ($row = mysqli_fetch_assoc($result)) {
    $stocks[] = $row;
}

echo json_encode($stocks);
?>
