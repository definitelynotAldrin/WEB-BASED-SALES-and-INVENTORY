<?php
ob_start();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['stock_name']) && isset($_POST['stock_quantity']) && isset($_POST['stock_units']) && isset($_POST['submission_time'])) {
        include_once "../includes/connection.php";

        $stockName = $_POST['stock_name'];
        $stockQuantity = $_POST['stock_quantity'];
        $stockUnit = $_POST['stock_units'];
        $submissionTime = $_POST['submission_time'];

        $data = "stock_name=" . urlencode($stockName) . "&stock_quantity=" . urlencode($stockQuantity) . "&stock_units=" . urlencode($stockUnit) . "&submission_time=" . urlencode($submissionTime);

        // Format the stock name
        $formattedName = ucfirst(strtolower($stockName));

        // Check if the stock item already exists
        $sqlCheck = "SELECT * FROM stocks WHERE stock_name = ?";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("s", $formattedName);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            // Stock item already exists
            $errorMsg = "Stock item already exists";
            header("Location: ../public/stocks_entry.php?error=$errorMsg&$data");
            exit;
        } else if (empty($stockName) || empty($stockQuantity) || empty($stockUnit)) {
            // Handle missing fields
            $errorMsg = "All fields are required";
            header("Location: ../public/stocks_entry.php?error=$errorMsg&$data");
            exit;
        } else {
            // Insert into database
            $sql = "INSERT INTO stocks (stock_name, stock_quantity, stock_unit, stock_date_added) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdss", $formattedName, $stockQuantity, $stockUnit, $submissionTime);
            $stmt->execute();
            $stmt->close();

            header("Location: ../public/stocks_entry.php?success=Stock item saved successfully");
            exit;
        }
    } else {
        $errorMsg = "Something went wrong!";
        header("Location: ../public/stocks_entry.php?error=$errorMsg");
        exit;
    }
} else {
    header("Location: ../public/stocks_entry.php");
    exit;
}

ob_end_flush();
