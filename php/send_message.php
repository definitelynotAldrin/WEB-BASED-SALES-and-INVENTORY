<?php
session_start();
include_once "../includes/connection.php"; // Adjust path as needed

header('Content-Type: application/json');

// Validate input
$username = isset($_POST['username']) ? $_POST['username'] : '';
$user_role = isset($_POST['user_role']) ? $_POST['user_role'] : '';
$text_message = isset($_POST['text_message']) ? trim($_POST['text_message']) : '';

if (empty($text_message)) {
    echo json_encode(['success' => false, 'error' => 'Message cannot be empty.']);
    exit;
}

try {
    // Insert the message into the database
    $query = "INSERT INTO messages (user_role, username, text_message, message_time, message_date) VALUES (?, ?, ?, NOW(), CURDATE())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $user_role, $username, $text_message);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Fetch the most recent messages to update the chat box
        $fetch_query = "SELECT user_role, username, text_message, CONCAT(message_date, ' ', message_time) AS timestamp FROM messages ORDER BY id DESC LIMIT 10";
        $result = $conn->query($fetch_query);

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
            'messages' => array_reverse($messages) // Display messages in chronological order
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to send message.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Error occurred: ' . $e->getMessage()]);
}

$conn->close();
?>
