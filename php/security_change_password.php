<?php
// Start the session or import any necessary configurations (e.g., database connection).
session_start();
include_once "../includes/connection.php";

header('Content-Type: application/json');

// Retrieve the posted data
$fav_color = isset($_POST['fav_color']) ? $_POST['fav_color'] : '';
$fav_pet = isset($_POST['fav_pet']) ? $_POST['fav_pet'] : '';
$place = isset($_POST['place']) ? $_POST['place'] : '';

// Check if all fields have values
if (empty($fav_color) || empty($fav_pet) || empty($place)) {
    echo json_encode(['success' => false, 'error' => 'All fields are required.']);
    exit;
}

try {
    // Prepare SQL query to update the color, pet, and place for matching accounts
    $query = "UPDATE accounts SET favorite_color = ?, favorite_pet = ?, place = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $fav_color, $fav_pet, $place);
    $stmt->execute();
    
    // Check if any rows were updated
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Security passwords successfully updated!']);
    } else {
        echo json_encode(['success' => false, 'error' => 'No accounts were updated.']);
    }
} catch (Exception $e) {
    // Handle any exceptions
    echo json_encode(['success' => false, 'error' => 'Error occurred: ' . $e->getMessage()]);
}

// Close the database connection
$conn->close();
?>
