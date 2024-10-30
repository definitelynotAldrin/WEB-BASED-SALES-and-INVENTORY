<?php
include_once "../includes/connection.php";

$category = isset($_GET['category']) ? $_GET['category'] : 'all';

// Prepare the SQL query based on the selected category
if ($category === 'all') {
    $sql = "SELECT 
                moc.item_id, 
                moc.order_count, 
                mi.item_name, 
                mi.item_category,
                 mi.item_image
            FROM menu_order_count moc
            JOIN menu_items mi ON moc.item_id = mi.item_id
            ORDER BY moc.order_count DESC
            LIMIT 10"; // Adjust the limit as needed
} else {
    $sql = "SELECT 
                moc.item_id, 
                moc.order_count, 
                mi.item_name, 
                mi.item_category,
                mi.item_image 
            FROM menu_order_count moc
            JOIN menu_items mi ON moc.item_id = mi.item_id
            WHERE mi.item_category = ? 
            ORDER BY moc.order_count DESC
            LIMIT 10"; // Adjust the limit as needed
}

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the category parameter if it's not 'all'
if ($category !== 'all') {
    $stmt->bind_param("s", $category);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

$bestSellers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bestSellers[] = $row;
    }
}

// Respond with JSON
header('Content-Type: application/json');
echo json_encode($bestSellers);

$stmt->close();
$conn->close();
?>
