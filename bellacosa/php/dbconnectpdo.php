<?php
$servername = "localhost";
$username = "ppdkpcom_akmal";
$password = "pw9z*IxM9o.S";
$dbname = "ppdkpcom_bellacosashopdb";

try {
   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
?>