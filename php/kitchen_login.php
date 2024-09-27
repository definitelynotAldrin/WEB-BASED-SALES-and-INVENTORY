<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include_once "../includes/connection.php";
    
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // SQL query to retrieve the user data from the database
    $sql = "SELECT * FROM accounts WHERE account_username = ? AND account_password = ? AND account_id ='3'";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param("ss", $username, $password);
    
    // Execute the query
    $stmt->execute();
    
    // Store the result
    $result = $stmt->get_result();

    $data = "username=".$username;
    
    if(empty($username)){
    	$errorMsg = "username is required";
        header("Location: ../public/login_kitchen.php?error=$errorMsg&$data");
	    exit;
    }else if(empty($password)){
    	$errorMsg = "Password is required";
        header("Location: ../public/login_kitchen.php?error=$errorMsg&$data");
	    exit;
    }
    else{
    // Check if there's a matching record
        if ($result->num_rows == 1) {
            // Fetch the user data from the result
            $row = $result->fetch_assoc();
            
            // Set session variables
            $_SESSION['account_id'] = $row['account_id'];
            $_SESSION['account_username'] = $row['account_username'];
            $_SESSION['account_password'] = $row['account_password'];
            $_SESSION['user_role'] = $row['user_role'];
            $_SESSION['account_logged_in'] = true; // Optionally set a flag for login status
            
            // Redirect to index page or any desired page
            header("Location: ../public/kitchen_dashboard?&success=Successfully log in!");
            exit();
        } else {
            // Invalid username or password, display an error message
            $errorMsg = "Incorrect username or password";
            header("Location: ../public/login_kitchen.php?error=$errorMsg");
        }

    }
    
    // Close the prepared statement
    $stmt->close();
    
    // Close the database connection
    $conn->close();
}
?>
