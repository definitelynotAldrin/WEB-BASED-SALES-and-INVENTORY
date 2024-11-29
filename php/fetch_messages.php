<?php
session_start();
include_once "../includes/connection.php"; // Adjust path to your database connection file

header('Content-Type: application/json');

try {
    // Fetch the latest 10 messages
    $query = "SELECT user_role, username, text_message, CONCAT(message_date, ' ', message_time) AS timestamp 
              FROM messages 
              ORDER BY id DESC";
    $result = $conn->query($query);

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = [
            'user_role' => htmlspecialchars($row['user_role']),
            'username' => htmlspecialchars($row['username']),
            'text_message' => htmlspecialchars($row['text_message']),
            'timestamp' => $row['timestamp']
        ];
    }

    echo json_encode([
        'success' => true,
        'messages' => array_reverse($messages) // Reverse to show oldest messages at the top
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Error occurred: ' . $e->getMessage()]);
}

$conn->close();
?>
