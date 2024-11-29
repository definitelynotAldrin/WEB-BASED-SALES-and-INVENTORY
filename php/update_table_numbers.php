<?php
include_once "../includes/connection.php";

$action = $_POST['action']; // 'add' or 'remove'

if ($action === 'add') {
    $sql = "SELECT MAX(table_number) AS max_table FROM table_numbers";
    $result = $conn->query($sql);
    $max_table = $result->fetch_assoc()['max_table'] ?? 0;
    $new_table = $max_table + 1;

    $insert_sql = "INSERT INTO table_numbers (table_number) VALUES ($new_table)";
    if ($conn->query($insert_sql) === TRUE) {
        echo "Table $new_table added.";
    } else {
        echo "Error: " . $conn->error;
    }
} elseif ($action === 'remove') {
    $sql = "SELECT MAX(table_number) AS max_table FROM table_numbers";
    $result = $conn->query($sql);
    $max_table = $result->fetch_assoc()['max_table'] ?? 0;

    if ($max_table > 0) {
        $delete_sql = "DELETE FROM table_numbers WHERE table_number = $max_table";
        if ($conn->query($delete_sql) === TRUE) {
            echo "Table $max_table removed.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "No tables to remove.";
    }
}

$conn->close();
?>
