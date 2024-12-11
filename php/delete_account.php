<?php
session_start();
include_once "../includes/connection.php";

header('Content-Type: application/json');

// Retrieve the posted data
$password = isset($_POST['password']) ? $_POST['password'] : '';
$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : '';

// Check if all fields have values
if (empty($password)) {
    echo json_encode(['success' => false, 'error' => 'All fields are required.']);
    exit;
}

// Initialize database connection
$conn = new mysqli('localhost', 'u169343664_root', 'Campano_db00', 'u169343664_campano_db');
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed"]);
    exit;
}

try {
    // Verify the password
    $verifyQuery = "SELECT account_password FROM accounts WHERE account_id = ?";
    $verifyStmt = $conn->prepare($verifyQuery);
    $verifyStmt->bind_param("i", $account_id);
    $verifyStmt->execute();
    $verifyResult = $verifyStmt->get_result();
    $user = $verifyResult->fetch_assoc();

    if (!$user || !password_verify($password, $user['account_password'])) {
        echo json_encode(['success' => false, 'error' => 'Current password is incorrect.']);
        $verifyStmt->close();
        $conn->close();
        exit;
    }
    $verifyStmt->close();

    // Delete the account
    $deleteQuery = "DELETE FROM accounts WHERE account_id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    if (!$deleteStmt) {
        echo json_encode(["success" => false, "error" => "Failed to prepare delete query"]);
        $conn->close();
        exit;
    }
    $deleteStmt->bind_param("i", $account_id);

    if ($deleteStmt->execute()) {
        // Check if the deleted account is the currently logged-in user
        if ($account_id == $_SESSION['account_id']) {
            // Destroy the session
            session_unset();
            session_destroy();

            // Redirect to login
            echo json_encode([
                "success" => true,
                "logout" => true,
                "message" => "Account successfully deleted. Logging out in few seconds."
            ]);
            exit;
        }

        echo json_encode([
            "success" => true,
            "message" => "Account successfully deleted"
        ]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to delete account"]);
    }
    $deleteStmt->close();

} catch (Exception $e) {
    // Handle any exceptions
    echo json_encode(['success' => false, 'error' => 'Error occurred: ' . $e->getMessage()]);
}

// Close the database connection
$conn->close();
?>
