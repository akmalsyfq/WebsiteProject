<?php
include_once("../php/dbconnectpdo.php");
session_start();

if (isset($_SESSION['sessionid'])) {
    $useremail = $_SESSION['user_email'];
}else{
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    return;
}
if (isset($_GET['submit'])) {
    $code = $_GET['code'];
    $price = $_GET['price'];
    $sqlqty = "SELECT * FROM cart WHERE email = '$useremail' AND code = '$code'";
    $stmtsqlqty = $conn->prepare($sqlqty);
    $stmtsqlqty->execute();
    $resultsqlqty = $stmtsqlqty->setFetchMode(PDO::FETCH_ASSOC);
    $rowsqlqty = $stmtsqlqty->fetchAll();
    $procurqty = 0;
    foreach ($rowsqlqty as $product) {
        $procurqty = $product['cartquan'] + $procurqty;
    }
    if ($_GET['submit'] == "add"){
        $cart_quan = $procurqty + 1 ;
        $updatecart = "UPDATE `cart` SET `cartquan`= '$cart_quan' WHERE email = '$useremail' AND code = '$code'";
        $conn->exec($updatecart);
    }
    if ($_GET['submit'] == "remove"){
        if ($procurqty == 1){
            $updatecart = "DELETE FROM `cart` WHERE email = '$useremail' AND code = '$code'";
            $conn->exec($updatecart);
        }else{
            $cart_quan = $procurqty - 1 ;
            $updatecart = "UPDATE `cart` SET `cartquan`= '$cart_quan' WHERE email = '$useremail' AND code = '$code'";
            $conn->exec($updatecart);     
        }
    }
}


$stmtqty = $conn->prepare("SELECT * FROM cart INNER JOIN products ON cart.code = products.code WHERE cart.email = '$useremail'");
$stmtqty->execute();
$rowsqty = $stmtqty->fetchAll();
$totalpayable = 0;
$carttotal =0;
foreach ($rowsqty as $carts) {
    $carttotal = $carts['cartquan'] + $carttotal;
   $propr = $carts['price'] * $carts['cartquan'];
   $totalpayable = $totalpayable + $propr;
}

$mycart = array();
$mycart['carttotal'] =$carttotal;
$mycart['code'] =$code;
$mycart['qty'] =$cart_quan;
$mycart['price'] = bcdiv($cart_quan * $price,1,2);
$mycart['totalpayable'] = bcdiv($totalpayable,1,2);


$response = array('status' => 'success', 'data' => $mycart);
sendJsonResponse($response);


function sendJsonResponse($sentArray)
{
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}
?>