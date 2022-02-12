<?php
include_once("../php/dbconnectpdo.php");
session_start();

if (isset($_SESSION['sessionid'])) {
	$email = $_SESSION['user_email'];
} else {
	$response = array('status' => 'failed', 'data' => null);
	sendJsonResponse($response);
	return;
}

if ($_GET['submit'] == "add") {
    $email = $_SESSION['user_email'];
	if ($email  != "Guest") {
		$code = $_GET['code'];
		$cartquan = "1";
		$carttotal = 0;
		$stmt = $conn -> prepare("SELECT * FROM cart WHERE email = '$email' AND code = '$code'");
		$stmt -> execute();
		$number_of_rows = $stmt -> rowCount();
		$result = $stmt -> setFetchMode(PDO::FETCH_ASSOC);
		$rows = $stmt -> fetchAll();
		if ($number_of_rows > 0) {
			foreach($rows as $carts) {
				$cartquan = $carts['cartquan'];
			}
			$cartquan = $cartquan + 1;
			$updatecart = "UPDATE `cart` SET `cartqtuan`= '$cartquan' WHERE email = '$email' AND code = '$code'";
			$conn -> exec($updatecart);

		} else {
			$addcart = "INSERT INTO `cart`(`email`, `code`, `cartquan`) VALUES ('$email','$code','$cartquan')";
			try {
				$conn -> exec($addcart);

			} catch (PDOException $e) {
				$response = array('status' => 'failed', 'data' => null);
				sendJsonResponse($response);
				return;
			}
		}
		$stmtqty = $conn -> prepare("SELECT * FROM cart WHERE email = '$email'");
		$stmtqty -> execute();
		$resultqty = $stmtqty -> setFetchMode(PDO::FETCH_ASSOC);
		$rowsqty = $stmtqty -> fetchAll();
		$carttotal = 0;
		foreach($rowsqty as $carts) {
			$carttotal = $carts['cartquan'] + $carttotal;
		}
		$mycart = array();
		$mycart['carttotal'] = $carttotal;


		$response = array('status' => 'success', 'data' => $mycart);
		sendJsonResponse($response);


	} else {
		$response = array('status' => 'failed', 'data' => null);
		sendJsonResponse($response);
	}
}


function sendJsonResponse($sentArray) {
	header('Content-Type: application/json');
	echo json_encode($sentArray);
}

?>