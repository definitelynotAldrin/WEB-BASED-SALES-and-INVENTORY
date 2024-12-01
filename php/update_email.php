<?php
header('Content-Type: application/json'); // Ensure JSON response

$new_email = $_POST["new_email"];
$account_id = $_POST["account_id"];

include_once "../includes/connection.php";

// Initialize MySQLi connection
$mysqli = new mysqli("localhost", "root", "", "campano_db");

// Check for connection errors
if ($mysqli->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed"]);
    exit;
}

// Validate inputs
if (empty($new_email) || empty($account_id)) {
    echo json_encode(["success" => false, "error" => "Email is required."]);
    exit;
}

if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "error" => "Invalid email format"]);
    exit;
}

// Prepare SQL query
$sql = "UPDATE accounts
        SET email = ?
        WHERE account_id = ?";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    echo json_encode(["success" => false, "error" => "Failed to prepare SQL query"]);
    $mysqli->close();
    exit;
}

// Bind parameters and execute the query
$stmt->bind_param("si", $new_email, $account_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Email updated successfully."]);
} else {
    echo json_encode(["success" => false, "error" => "Failed to update email"]);
}

// Close the statement and connection
$stmt->close();
$mysqli->close();
