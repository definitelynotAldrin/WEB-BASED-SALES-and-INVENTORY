<?php
header('Content-Type: application/json'); // Ensure JSON response

$current_password = $_POST["current_password"];
$password = $_POST["new_password"];
$account_id = $_POST["account_id"];

include_once "../includes/connection.php";

$mysqli = new mysqli('localhost', 'u169343664_root', 'Campano_db00', 'u169343664_campano_db');

// Check for connection errors
if ($mysqli->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed"]);
    exit;
}

// Fetch the user's current password
$sql = "SELECT account_password FROM accounts WHERE account_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $account_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "error" => "Account not found"]);
    exit;
}

$user = $result->fetch_assoc();

// Verify the current password
if (!password_verify($current_password, $user["account_password"])) {
    echo json_encode(["success" => false, "error" => "Current password doesn't match"]);
    exit;
}

// Hash the new password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Update the password in the database
$sql = "UPDATE accounts
        SET account_password = ?,
            security_code = NULL,
            security_code_expiry = NULL
        WHERE account_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("si", $password_hash, $account_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Password updated successfully"]);
} else {
    echo json_encode(["success" => false, "error" => "Failed to update password"]);
}

$mysqli->close();
?>
