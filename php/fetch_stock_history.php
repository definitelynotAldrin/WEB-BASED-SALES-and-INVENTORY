<?php
include_once "../includes/connection.php";
header('Content-Type: application/json');
date_default_timezone_set('Asia/Manila');


// Get the selected date from the AJAX request or default to today
$search_date = isset($_POST['search_item']) ? $_POST['search_item'] : date('Y-m-d');

// Prepare the SQL query
$sql = $search_date
    ? "SELECT s.stock_name, sh.previous_quantity, sh.updated_quantity, sh.updated_at, sh.last_action_type, sh.username
       FROM stock_history sh
       JOIN stocks s ON sh.stock_id = s.stock_id
       WHERE DATE(sh.updated_at) = ?"
    : "SELECT s.stock_name, sh.previous_quantity, sh.updated_quantity, sh.updated_at, sh.last_action_type, sh.username
       FROM stock_history sh
       JOIN stocks s ON sh.stock_id = s.stock_id
       WHERE DATE(sh.updated_at) = CURDATE()";

$stmt = $conn->prepare($sql);
if ($search_date) {
    $stmt->bind_param('s', $search_date);
}
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['formatted_date'] = date('M d, Y h:i A', strtotime($row['updated_at']));
        $row['updated_stock'] = $row['last_action_type'] === 'insert'
            ? $row['previous_quantity'] + $row['updated_quantity']
            : $row['updated_quantity'];
        $data[] = $row;
    }   
} else {
    $data = ['error' => 'No data found for the selected date or today.'];
}

// Return JSON response
echo json_encode($data);
$conn->close();
?>
