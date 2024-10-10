<?php 
	session_start();
    include_once "../includes/connection.php";

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$sql = "SELECT * FROM order_details WHERE customer_id = '$id'";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		$response = [];

		if ($row) {
			$response = $row;
			$response['status'] = 'success';  // Add 'status' as 'success' when a row is found
		} else {
			$sql = "SELECT * FROM order_details WHERE status = 0";
			$query = $conn->query($sql);
			$row = $query->fetch_assoc();

			if ($row) {
				$response = $row;
				$response['status'] = 'success';  // Another row was found, still 'success'
			} else {
				$response['status'] = 'failed';  // No rows found, set status as 'failed'
			}
		}

		echo json_encode($response);
	}
?>