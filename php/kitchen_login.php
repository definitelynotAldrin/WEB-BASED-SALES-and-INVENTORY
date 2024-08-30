<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include_once "../includes/connection.php"; // Assuming connection.php contains your database connection code
    
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // SQL query to retrieve the user data from the database
    $sql = "SELECT * FROM accounts WHERE account_email = ? AND account_password = ?";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param("ss", $email, $password);
    
    // Execute the query
    $stmt->execute();
    
    // Store the result
    $result = $stmt->get_result();
    
    // Check if there's a matching record
    if ($result->num_rows == 1) {
        // Fetch the user data from the result
        $row = $result->fetch_assoc();
        
        // Set session variables
        $_SESSION['account_id'] = $row['account_id'];
        $_SESSION['account_email'] = $row['account_email'];
        $_SESSION['account_password'] = $row['account_password'];
        $_SESSION['user_role'] = $row['user_role'];
        $_SESSION['account_logged_in'] = true; // Optionally set a flag for login status
        
        // Redirect to index page or any desired page
        // $_SESSION['success_message'] = "";
        header("Location: ../public/kitchen_dashboard");
        exit();
    } else {
        // Invalid email or password, display an error message
        echo "<script>alert('Invalid email or password'); window.location.href='../public/login_admin.php';</script>";
    }
    
    // Close the prepared statement
    $stmt->close();
    
    // Close the database connection
    $conn->close();
}


