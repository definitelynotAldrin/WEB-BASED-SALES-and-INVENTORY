<?php
header('Content-Type: application/json');

include_once "../includes/connection.php";

// Check database connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed"]);
    exit;
}

// Query to fetch all accounts
$sql = "SELECT email, account_username, account_status, account_id FROM accounts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $accounts = [];
    while ($row = $result->fetch_assoc()) {
        $accounts[] = $row;
    }
    echo json_encode(["success" => true, "data" => $accounts]);
} else {
    echo json_encode(["success" => false, "error" => "No accounts found"]);
}

$conn->close();
