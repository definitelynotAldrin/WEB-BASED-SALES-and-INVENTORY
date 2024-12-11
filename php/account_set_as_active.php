<?php
header('Content-Type: application/json'); // Ensure JSON response

$account_id = $_POST["account_id"];

include_once "../includes/connection.php";

// Initialize MySQLi connection
$mysqli = new mysqli('localhost', 'u169343664_root', 'Campano_db00', 'u169343664_campano_db');

// Check for connection errors
if ($mysqli->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed"]);
    exit;
}


// Prepare SQL query
$sql = "UPDATE accounts
        SET account_status = 'active'
        WHERE account_id = ?";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    echo json_encode(["success" => false, "error" => "Failed to prepare SQL query"]);
    $mysqli->close();
    exit;
}

// Bind parameters and execute the query
$stmt->bind_param("i", $account_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Account set as active successfully."]);
} else {
    echo json_encode(["success" => false, "error" => "Failed to update account"]);
}

// Close the statement and connection
$stmt->close();
$mysqli->close();
