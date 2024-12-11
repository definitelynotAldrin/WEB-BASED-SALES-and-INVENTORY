<?php
header('Content-Type: application/json'); // Ensure JSON response

$security_code = $_POST["security_code"];

include_once "../includes/connection.php";

$mysqli = new mysqli('localhost', 'u169343664_root', 'Campano_db00', 'u169343664_campano_db');

// Check for connection errors
if ($mysqli->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed"]);
    exit;
}

// Validate security code
$sql = "SELECT * FROM accounts WHERE security_code = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $security_code);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    echo json_encode(["success" => false, "error" => "Invalid security code"]);
    $stmt->close();
    $mysqli->close();
    exit;
}

// Check for expiration
if (strtotime($user["security_code_expiry"]) <= time()) {
    echo json_encode(["success" => false, "error" => "Security code has expired"]);
    $stmt->close();
    $mysqli->close();
    exit;
}

// Clear the security code and expiry
$sql = "UPDATE accounts
        SET security_code = NULL,
            security_code_expiry = NULL
        WHERE account_id = ?";
$update_stmt = $mysqli->prepare($sql);
if (!$update_stmt) {
    echo json_encode(["success" => false, "error" => "Failed to prepare update query"]);
    $stmt->close();
    $mysqli->close();
    exit;
}
$update_stmt->bind_param("i", $user["account_id"]);

if ($update_stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Successfully verified security code",
        "account_id" => $user["account_id"] // Return account ID if needed
    ]);
} else {
    echo json_encode(["success" => false, "error" => "Failed to verify security code"]);
}

// Close statements and connection
$stmt->close();
$update_stmt->close();
$mysqli->close();
