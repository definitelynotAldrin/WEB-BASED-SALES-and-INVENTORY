<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include_once "../includes/connection.php";
    
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

    $data = "email=".$email;
    
    if(empty($email)){
    	$errorMsg = "Email is required";
        header("Location: ../public/login_service.php?error=$errorMsg&$data");
	    exit;
    }else if(empty($password)){
    	$errorMsg = "Password is required";
        header("Location: ../public/login_service.php?error=$errorMsg&$data");
	    exit;
    }
    else{
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
            header("Location: ../public/order_entry");
            exit();
        } else {
            // Invalid email or password, display an error message
            $errorMsg = "Incorrect email or password";
            header("Location: ../public/login_service.php?error=$errorMsg");
        }

    }
    
    // Close the prepared statement
    $stmt->close();
    
    // Close the database connection
    $conn->close();
}
?>
