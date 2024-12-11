<?php
header('Content-Type: application/json');

include_once "../includes/connection.php";

// Check database connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed"]);
    exit;
}

// Query to fetch all accounts
$sql = "SELECT email, account_username, account_status, date_time, account_id FROM accounts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $accounts = [];
    while ($row = $result->fetch_assoc()) {
        // Format date and time
        $dateTime = new DateTime($row['date_time']);
        $formattedDate = $dateTime->format('M d, Y'); // Example: Dec 11, 2024
        $formattedTime = $dateTime->format('g:i A');  // Example: 9:50 AM

        $accounts[] = [
            'email' => $row['email'],
            'account_username' => $row['account_username'],
            'account_status' => $row['account_status'],
            'date' => $formattedDate,
            'time' => $formattedTime,
            'account_id' => $row['account_id']
        ];
    }
    echo json_encode(["success" => true, "data" => $accounts]);
} else {
    echo json_encode(["success" => false, "error" => "No accounts found"]);
}

$conn->close();
?>
