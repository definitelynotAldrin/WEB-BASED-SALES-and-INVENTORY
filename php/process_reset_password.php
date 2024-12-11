<?php
header('Content-Type: application/json'); // Ensure JSON response

$token = $_POST["token"];
$password = $_POST["password"];
$repeat_password = $_POST["repeat_password"];

$token_hash = hash("sha256", $token);

include_once "../includes/connection.php";

$mysqli = new mysqli('localhost', 'u169343664_root', 'Campano_db00', 'u169343664_campano_db');

// Check for connection errors
if ($mysqli->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed"]);
    exit;
}

$sql = "SELECT * FROM accounts WHERE reset_token_hash = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    echo json_encode(["success" => false, "error" => "Invalid token"]);
    exit;
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    echo json_encode(["success" => false, "error" => "Token has expired"]);
    exit;
}

if (strlen($password) < 8) {
    echo json_encode(["success" => false, "error" => "Password must be at least 8 characters"]);
    exit;
}

if (!preg_match("/[a-z]/i", $password)) {
    echo json_encode(["success" => false, "error" => "Password must contain at least one letter"]);
    exit;
}

if (!preg_match("/[0-9]/", $password)) {
    echo json_encode(["success" => false, "error" => "Password must contain at least one number"]);
    exit;
}

if ($password !== $repeat_password) {
    echo json_encode(["success" => false, "error" => "Passwords do not match"]);
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE accounts
        SET account_password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE account_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $password_hash, $user["account_id"]);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Password updated successfully. You can now login."]);
} else {
    echo json_encode(["success" => false, "error" => "Failed to update password"]);
}
