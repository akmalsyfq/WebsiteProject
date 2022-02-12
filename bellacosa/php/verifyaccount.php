<?php
error_reporting(0);
include_once("../php/dbconnectpdo.php");
$email = $_GET['email'];
$otp = $_GET['otp'];
$sqlverify = "SELECT * FROM users WHERE email = '$email' AND otp = '$otp'";
$stmt = $conn->prepare($sqlverify);
$stmt->execute();
$number_of_rows = $stmt->fetchColumn();

if ($number_of_rows  > 0) {
   $newotp = '1';
   $sqlupdate = "UPDATE users SET otp = '$newotp' WHERE email = '$email'";
  try {
        $conn->exec($sqlupdate);
        echo "<script>alert('Successful')</script>";
        echo "<script>window.location.replace('login.php')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Failed')</script>";
        echo "<script> window.location.replace('register.php')</script>";
    }
}else{
     echo "<script>alert('Failed')</script>";
     echo "<script> window.location.replace('register.php')</script>";
}

 
?>