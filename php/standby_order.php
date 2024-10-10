<?php
session_start();

include_once "../includes/connection.php";
if(isset($_POST['standByOrder'])){


    $customer_id = $_POST['customer_id'];
    $customer_name = $_POST['customer_name'];
    $note = $_POST['customer_note'];


    $sql = "SELECT * FROM order_details WHERE status = 0";
    $query = $conn->query($sql);

    // Check if there are items in the cart
    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            // Fetch cart data
        
        
            // Assuming price is stored in the cart

            // Step 2: Insert each item into the sales table
            $update_sql = "UPDATE order_details set customer_id = '$customer_id', customer_name = '$customer_name', note = '$note', status = 1 WHERE status = 0";

            if ($conn->query($update_sql) !== TRUE) {
                // If an error occurs during insertion, redirect with an error message
                header('location: ../public/order_entry.php?failed!');
                exit();
            }
        }
        header('location: ../public/order_entry.php?success');

    } else {
        // If the cart is empty, redirect with an empty cart message
        header('location: ../public/order_entry.php?empty!');
    } 

}



if(isset($_POST['re-order'])){

    
    $customer_id = $_POST['customer_id'];
    $customer_name = $_POST['customer_name'];
    $note = $_POST['customer_note'];


    $sql = "SELECT * FROM order_details WHERE status = 0";
    $query = $conn->query($sql);

    // Check if there are items in the cart
    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            // Fetch cart data
        
        
            // Assuming price is stored in the cart

            // Step 2: Insert each item into the sales table
            $update_sql = "UPDATE order_details set customer_id = '$customer_id', customer_name = '$customer_name', note = '$note', status = 1 WHERE status = 0";

            if ($conn->query($update_sql) !== TRUE) {
                // If an error occurs during insertion, redirect with an error message
                header('location: ../public/order_entry.php?failed!');
                exit();
            }
        }
        header('location: ../public/order_entry.php?success');

    } else {
        // If the cart is empty, redirect with an empty cart message
        header('location: ../public/order_entry.php?empty!');
    } 

}
?>