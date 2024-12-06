<?php
include_once "../includes/connection.php";
header('Content-Type: application/json');

$category = isset($_GET['category']) ? $_GET['category'] : 'all';

$sql = "SELECT * FROM menu_items";
if ($category !== 'all') {
    $sql .= " WHERE item_category = ?";
}

$stmt = $conn->prepare($sql);
if ($category !== 'all') {
    $stmt->bind_param("s", $category);
}
$stmt->execute();
$result = $stmt->get_result();

$menuItems = [];
while ($row = $result->fetch_assoc()) {
    $menuItems[] = $row;
}

echo json_encode(['success' => true, 'data' => $menuItems]);

$stmt->close();
$conn->close();
