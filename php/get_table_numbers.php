<?php

include_once "../includes/connection.php";

$sql = "SELECT table_number FROM table_numbers ORDER BY table_number ASC";
$result = $conn->query($sql);

$tables = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tables[] = $row['table_number'];
    }
}

echo json_encode($tables);
$conn->close();
?>