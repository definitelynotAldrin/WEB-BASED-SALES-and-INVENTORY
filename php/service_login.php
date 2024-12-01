<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include_once "../includes/connection.php";

    // Retrieve form data
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';

    // Data to preserve the username in case of an error
    $data = "username=" . urlencode($username);

    // Input validation
    if (empty($username)) {
        $errorMsg = "Username is required";
        header("Location: ../public/login_service.php?error=$errorMsg&$data");
        exit();
    } else if (empty($password)) {
        $errorMsg = "Password is required";
        header("Location: ../public/login_service.php?error=$errorMsg&$data");
        exit();
    }

    // SQL query to retrieve the user data from the database
    $sql = "SELECT * FROM accounts WHERE account_username = ? AND user_role = 'user_service' AND account_status = 'active'";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("s", $username);

    // Execute the query
    $stmt->execute();

    // Store the result
    $result = $stmt->get_result();

    // Check if there's a matching record
    if ($result->num_rows == 1) {
        // Fetch the user data from the result
        $row = $result->fetch_assoc();

        // Verify the entered password against the stored hash
        if (password_verify($password, $row['account_password'])) {
            // Set session variables
            $_SESSION['account_id'] = $row['account_id'];
            $_SESSION['account_username'] = $row['account_username'];
            $_SESSION['user_role'] = $row['user_role'];
            $_SESSION['account_logged_in'] = true; // Optionally set a flag for login status

            // Redirect to index page or any desired page
            header("Location: ../public/order_entry.php?success=Successfully logged in.");
            exit();
        } else {
            // Invalid password
            $errorMsg = "Incorrect username or password";
            header("Location: ../public/login_service.php?error=$errorMsg&$data");
            exit();
        }
    } else {
        // Invalid username
        $errorMsg = "Incorrect username or password";
        header("Location: ../public/login_service.php?error=$errorMsg&$data");
        exit();
    }

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $conn->close();
}
?>
