<?php
include_once "../includes/connection.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'] ?? '';
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate inputs
    if (empty($role) || empty($email) || empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'All fields arasde required.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
        exit;
    }

    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        echo json_encode(['success' => false, 'message' => 'Username must be 3-20 characters, does not have space, can only include letters, numbers, and underscores.']);
        exit;
    }
    // Password validation

    // Check for duplicate email or username
    $checkQuery = "SELECT * FROM accounts WHERE account_username = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Username already exists.']);
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert into database
    $insertQuery = "INSERT INTO accounts (account_username, account_password, user_role, email) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssss", $username, $hashedPassword, $role, $email);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Account created successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create account. Please try again.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
