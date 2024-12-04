<?php
session_start();
include_once "../includes/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = $_POST['new_username'] ?? '';
    $password = $_POST['password'] ?? '';
    $account_id = $_POST['account_id'] ?? '';

    // Validate inputs
    if (empty($newUsername) || empty($password)) {
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        exit;
    }

    // Validate username format
    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $newUsername)) {
        echo json_encode(['success' => false, 'error' => 'Username must be 3-20 characters and can only include letters, numbers, and underscores.']);
        exit;
    }

    // Check if username is already taken
    $query = "SELECT account_id FROM accounts WHERE account_username = ?";
    $stmt_check = $conn->prepare($query);
    $stmt_check->bind_param("s", $newUsername);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'Username is already taken.']);
        $stmt_check->close(); // Close the statement
        exit;
    }
    $stmt_check->close(); // Close the statement after use

    // Verify user's current password
    $query = "SELECT account_password FROM accounts WHERE account_id = ?";
    $stmt_verify = $conn->prepare($query);
    $stmt_verify->bind_param("i", $account_id);
    $stmt_verify->execute();
    $stmt_verify->bind_result($hashedPassword);
    $stmt_verify->fetch();
    $stmt_verify->close(); // Close the statement

    if (!password_verify($password, $hashedPassword)) {
        echo json_encode(['success' => false, 'error' => 'Incorrect password.']);
        exit;
    }

    // Update username
    $query = "UPDATE accounts SET account_username = ? WHERE account_id = ?";
    $stmt_update = $conn->prepare($query);
    $stmt_update->bind_param("si", $newUsername, $account_id);

    if ($stmt_update->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update username.']);
    }

    $stmt_update->close(); // Close the statement
    $conn->close(); // Close the connection
}

