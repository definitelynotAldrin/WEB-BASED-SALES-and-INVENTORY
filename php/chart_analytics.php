<?php

include_once "../includes/connection.php";
date_default_timezone_set('Asia/Manila');

// Get parameters
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$period = isset($_GET['period']) ? $_GET['period'] : 'annually';

$sales_data = [];
if ($period === 'annually') {
    $query = "SELECT 
                SUM(CASE WHEN payment_status = 'paid' THEN total_amount ELSE 0 END) AS total_sales, 
                SUM(CASE WHEN payment_status = 'credit' THEN total_amount ELSE 0 END) AS total_collectibles 
              FROM payments 
              WHERE YEAR(payment_date) = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $year);
} elseif ($period === 'monthly') {
    $query = "SELECT 
                MONTH(payment_date) AS month, 
                DATE_FORMAT(payment_date, '%b') AS month_name,  /* Adds the abbreviated month name */
                SUM(CASE WHEN payment_status = 'paid' THEN total_amount ELSE 0 END) AS total_sales, 
                SUM(CASE WHEN payment_status = 'credit' THEN total_amount ELSE 0 END) AS total_collectibles 
              FROM payments 
              WHERE YEAR(payment_date) = ? 
              GROUP BY MONTH(payment_date)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $year);
} else { // Weekly
    // $query = "SELECT 
    //         WEEK(payment_date, 1) AS week, 
    //         MONTHNAME(payment_date) AS month_name, 
    //         SUM(CASE WHEN payment_status = 'paid' THEN total_amount ELSE 0 END) AS total_sales, 
    //         SUM(CASE WHEN payment_status = 'credit' THEN total_amount ELSE 0 END) AS total_collectibles 
    //       FROM payments 
    //       WHERE YEAR(payment_date) = ? 
    //       GROUP BY WEEK(payment_date, 1), MONTH(payment_date)";
    // $stmt = $conn->prepare($query);
    // $stmt->bind_param("i", $year);

    $query = "SELECT 
            CONCAT(MONTHNAME(payment_date), ' (Week ', FLOOR((DAY(payment_date) - 1) / 7) + 1, ')') AS week_label, 
            MONTHNAME(payment_date) AS month_name, 
            SUM(CASE WHEN payment_status = 'paid' THEN total_amount ELSE 0 END) AS total_sales, 
            SUM(CASE WHEN payment_status = 'credit' THEN total_amount ELSE 0 END) AS total_collectibles 
          FROM payments 
          WHERE YEAR(payment_date) = ? 
          GROUP BY MONTH(payment_date), FLOOR((DAY(payment_date) - 1) / 7)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $year);


}

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $sales_data[] = $row;
}

$stmt->close();
$conn->close();

// Return JSON data
header('Content-Type: application/json');
echo json_encode($sales_data);
?>
