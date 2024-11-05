<?php
// Start the session or import any necessary configurations (e.g., database connection).
session_start();
include_once "../includes/connection.php";

header('Content-Type: application/json');

// Retrieve the posted data
$fav_color = isset($_POST['fav_color']) ? $_POST['fav_color'] : '';
$fav_pet = isset($_POST['fav_pet']) ? $_POST['fav_pet'] : '';
$place = isset($_POST['place']) ? $_POST['place'] : '';
$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : '';

// Replace with the user_id or session variable that identifies the current user
// For example, if you use a logged-in user's account_id stored in the session, use that
// Example: $account_id = $_SESSION['account_id'];

// Assume the username or account_id is provided through a secure way
// For example, you can add another hidden input in the AJAX code with account_id

try {
    // Prepare SQL query to find the account with matching security answers
    $query = "SELECT account_password FROM accounts 
              WHERE favorite_color = ? AND favorite_pet = ? AND place = ? AND account_id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $fav_color, $fav_pet, $place, $account_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if a matching account was found
    if ($result->num_rows === 1) {
        // Fetch the account's password
        $row = $result->fetch_assoc();
        $account_password = $row['account_password'];

        // Return the password as a success response (for demonstration purposes)
        echo json_encode(['success' => true, 'password' => $account_password]);
    } else {
        // If no account matches, send an error response
        echo json_encode(['success' => false, 'error' => 'Invalid security passwords.']);
    }
} catch (Exception $e) {
    // Handle any exceptions
    echo json_encode(['success' => false, 'error' => 'Error occurred: ' . $e->getMessage()]);
}

// Close the database connection
$conn->close();
?>
