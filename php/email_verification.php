<?php
// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include_once "../includes/connection.php";
date_default_timezone_set('Asia/Manila');

// Initialize the MySQLi connection
$mysqli = new mysqli("localhost", "root", "", "campano_db");

// Check for connection errors
if ($mysqli->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

// Check if required data is sent via POST
if (isset($_POST['email'], $_POST['user_role'], $_POST['username'])) {
    $email = $_POST['email'];
    $user_role = $_POST['user_role'];
    $username = $_POST['username'];

    if (empty($email) || empty($username)) {
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        exit;
    }

    // Validate the existence of the user
    $validate_sql = "SELECT * FROM accounts WHERE email = ? AND user_role = ? AND account_username = ?";
    $validate_stmt = $mysqli->prepare($validate_sql);
    if (!$validate_stmt) {
        echo json_encode(['success' => false, 'error' => 'Failed to prepare validation query']);
        exit;
    }
    $validate_stmt->bind_param("sss", $email, $user_role, $username);
    $validate_stmt->execute();
    $result = $validate_stmt->get_result();

    // If no matching record found, return error
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'error' => 'No matching user found.']);
        exit;
    }

    // Generate a token
    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    // Update the token and expiry in the database
    $update_sql = "UPDATE accounts 
                   SET reset_token_hash = ?, reset_token_expires_at = ?
                   WHERE email = ? AND user_role = ? AND account_username = ?";
    $update_stmt = $mysqli->prepare($update_sql);
    if (!$update_stmt) {
        echo json_encode(['success' => false, 'error' => 'Failed to prepare update query']);
        exit;
    }
    $update_stmt->bind_param("sssss", $token_hash, $expiry, $email, $user_role, $username);
    $update_stmt->execute();

    // Send the email
    $mail = require __DIR__ . "/../php/emailer.php";
    $mail->setFrom("noreply@example.com", "Kan-anan by the Sea");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END
    We received a password request. Click <a href="http://localhost/WEB-BASED%20SALES%20and%20INVENTORY/public/password_reset.php?token=$token">here</a> if you wish to change your password.<br>
    If you didn't make this request, ignore this message.
    END;

    try {
        $mail->send();
        echo json_encode(['success' => true, 'message' => 'Verification email sent']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => "Mailer error: {$mail->ErrorInfo}"]);
    }

    // Close the statements and connection
    $validate_stmt->close();
    $update_stmt->close();
    $mysqli->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request: Missing email or user role']);
    exit;
}
