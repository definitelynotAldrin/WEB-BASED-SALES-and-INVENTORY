<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "../includes/connection.php";
date_default_timezone_set('Asia/Manila');

$mysqli = new mysqli("localhost", "root", "", "campano_db");

if ($mysqli->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

if (isset($_POST['account_id'], $_POST['username'])) {
    $account_id = $_POST['account_id'];
    $username = trim($_POST['username']);

    if (!is_numeric($account_id) || empty($username)) {
        echo json_encode(['success' => false, 'error' => 'Invalid account ID or username']);
        exit;
    }

    $validate_sql = "SELECT * FROM accounts WHERE account_id = ?";
    $validate_stmt = $mysqli->prepare($validate_sql);
    if (!$validate_stmt) {
        echo json_encode(['success' => false, 'error' => 'Failed to prepare validation query']);
        exit;
    }
    $validate_stmt->bind_param("i", $account_id);
    $validate_stmt->execute();
    $result = $validate_stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'error' => 'User not found.']);
        exit;
    }

    $user_data = $result->fetch_assoc();
    $email = htmlspecialchars($user_data['email']);

    $randomNumber = str_pad((string)random_int(0, 99999999999), 11, '0', STR_PAD_LEFT);
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    $update_sql = "UPDATE accounts SET security_code = ?, security_code_expiry = ? WHERE account_id = ?";
    $update_stmt = $mysqli->prepare($update_sql);
    if (!$update_stmt) {
        echo json_encode(['success' => false, 'error' => 'Failed to prepare update query']);
        exit;
    }
    $update_stmt->bind_param("ssi", $randomNumber, $expiry, $account_id);

    if (!$update_stmt->execute()) {
        echo json_encode(['success' => false, 'error' => 'Failed to update security code.']);
        exit;
    }

    $mail = require __DIR__ . "/../php/emailer.php";
    $mail->setFrom("noreply@example.com", "Kan-anan by the Sea");
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = "Account Deletion";
    $mail->Body = <<<END
        <strong>Your Account Security Code</strong><br>
        Hi, account username <strong>$username</strong> is trying to request a security code for account deletion.<br>
        Your security code is:<br>
        <strong>$randomNumber</strong><br>
        To confirm your identity, paste this code into the system. It can only be used once.<br>
        Ignore this message if none of your accounts are requesting it.
    END;

    function censorEmail($email) {
        $email_parts = explode("@", $email);
        $username = $email_parts[0];
        $domain = $email_parts[1];

        if (strlen($username) <= 2) {
            return str_repeat('*', strlen($username)) . "@" . $domain;
        }

        $first = substr($username, 0, 1);
        $last = substr($username, -1);
        return $first . str_repeat('*', strlen($username) - 2) . $last . "@" . $domain;
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
    } finally {
        $validate_stmt->close();
        $update_stmt->close();
        $mysqli->close();
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request: Missing account ID or username']);
    exit;
}
