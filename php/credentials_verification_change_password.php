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

    $user_data = $result->fetch_assoc();
    $user_name = htmlspecialchars($user_data['account_username']); // Assuming 'discount_type' is the intended field.

    // Generate a security code
    $randomNumber = str_pad((string)mt_rand(0, 99999999999), 11, '0', STR_PAD_LEFT);
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    // Update the token and expiry in the database
    $update_sql = "UPDATE accounts 
                   SET security_code = ?, security_code_expiry = ?
                   WHERE email = ? AND user_role = ? AND account_username = ?";
    $update_stmt = $mysqli->prepare($update_sql);
    if (!$update_stmt) {
        echo json_encode(['success' => false, 'error' => 'Failed to prepare update query']);
        exit;
    }
    $update_stmt->bind_param("sssss", $randomNumber, $expiry, $email, $user_role, $username);

    if (!$update_stmt->execute()) {
        echo json_encode(['success' => false, 'error' => 'Failed to update security code.']);
        exit;
    }

    // Send the email
    $mail = require __DIR__ . "/../php/emailer.php";
    $mail->setFrom("noreply@example.com", "Kan-anan by the Sea");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END
    <strong>Your Account Security Code</strong> <br>
    Hi <strong>$user_name</strong>, <br>
    Your security code is <br>
    <strong>$randomNumber</strong><br>
    To help us confirm your identity, paste this code into the system. It can only be used once.
    END;

    function censorEmail($email) {
        $email_parts = explode("@", $email); // Split email into username and domain
        $username = $email_parts[0];
        $domain = $email_parts[1];
    
        // Keep only the first and last character of the username
        $first = substr($username, 0, 1);
        $last = substr($username, -1);
    
        // Mask the middle characters
        $masked_username = $first . str_repeat('*', strlen($username) - 2) . $last;
    
        // Reassemble the email
        return $masked_username . "@" . $domain;
    }

    try {
        $mail->send();
        echo json_encode([
            'success' => true,
            'message' => 'Verification email sent',
            'email' => censorEmail($email)
        ]);
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
