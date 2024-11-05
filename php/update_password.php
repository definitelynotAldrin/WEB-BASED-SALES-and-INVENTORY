<?php
// Start the session or import any necessary configurations (e.g., database connection).
session_start();
include_once "../includes/connection.php";

header('Content-Type: application/json');

// Retrieve the posted data
$current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
$retypeNew_password = isset($_POST['retypeNew_password']) ? $_POST['retypeNew_password'] : '';
$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : ''; // Assuming the account ID is passed from the form

// Check if all fields have values
if (empty($current_password) || empty($new_password) || empty($retypeNew_password)) {
    echo json_encode(['success' => false, 'error' => 'All fields are required.']);
    exit;
}

// Check if new_password and retypeNew_password match
if ($new_password !== $retypeNew_password) {
    echo json_encode(['success' => false, 'error' => 'New username and retype username do not match.']);
    exit;
}

try {
    // Prepare SQL query to verify if the current username matches the account_id
    $verifyQuery = "SELECT account_password FROM accounts WHERE account_id = ? AND account_password = ?";
    $verifyStmt = $conn->prepare($verifyQuery);
    $verifyStmt->bind_param("is", $account_id, $current_password);
    $verifyStmt->execute();
    $verifyResult = $verifyStmt->get_result();

    // Check if current username matches the one in the database
    if ($verifyResult->num_rows === 0) {
        echo json_encode(['success' => false, 'error' => 'Current password is incorrect.']);
        exit;
    }

    // Prepare SQL query to update the username
    $updateQuery = "UPDATE accounts SET account_password = ? WHERE account_id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("si", $new_password, $account_id);
    $updateStmt->execute();

    // Check if any rows were updated
    if ($updateStmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Username successfully updated!']);
    } else {
        echo json_encode(['success' => false, 'error' => 'No username was updated.']);
    }
} catch (Exception $e) {
    // Handle any exceptions
    echo json_encode(['success' => false, 'error' => 'Error occurred: ' . $e->getMessage()]);
}

// Close the database connection
$conn->close();
?>
