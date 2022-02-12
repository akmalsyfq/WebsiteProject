<?php
include_once("../php/dbconnectpdo.php");
session_start();
if (isset($_SESSION['sessionid']))
{
    $useremail = $_SESSION['user_email'];
    $user_name = $_SESSION['user_name'];
    $user_phone = $_SESSION['user_phone'];
}else{
    echo "<script>alert('Please login or register')</script>";
    echo "<script> window.location.replace('login.php')</script>";
}

$receiptid = $_GET['receipt'];
$sqlquery = "SELECT * FROM historder INNER JOIN products ON historder.orderprocode = products.code WHERE historder.receiptid = '$receiptid'";
$stmt = $conn->prepare($sqlquery);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

$carttotal =0;
$stmtqty = $conn->prepare("SELECT * FROM cart INNER JOIN products ON cart.code = products.code WHERE cart.email = '$email'");
    $stmtqty->execute();
    $resultqty = $stmtqty->setFetchMode(PDO::FETCH_ASSOC);
    $rowsqty = $stmtqty->fetchAll();
    foreach ($rowsqty as $carts) {
        $carttotal = $carts['cartquan']+$carttotal ;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://kit.fontawesome.com/ac93d662e6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="script.js"></script>
    
    <title>Payment Detail</title>
</head>


<body>
    

<div  class="w3-bar  w3-blue-gray" style="max-width:1200px;margin:auto">
<img src="../images/heda.png" alt="shop banner ">
<nav class="navbar is-primary has-background-link-light">

    <div class="container">
      <div class="navbar-brand">
        <a href="mainpage.php" class="navbar-item has-text-black">Bella
          Cosa</a>
        <span class="navbar-burger burger" data-target="navMenu">
          <span></span>
          <span></span>
          <span></span>
        </span>
      </div>
    </div>
    <div class="navbar-end">
      <div class="navbar-item">
        <div class="navbar-menu" id="navMenu">
          <a href="myorder.php" class="navbar-item">Profile</a>
          <a href="cart.php" class="navbar-item"id="carttotalidb" >Cart(<?php echo $carttotal?>)</a>
          <a href="logout.php" class="navbar-item">Log out</a>
          </div>
      </div>
    </div>
  </nav></div>

   
    <div class="w3-main w3-content w3-padding" style="max-width:1200px;">
        
      <div class="w3-grid-template">
          
            <?php
             foreach  ($rows  as  $details)  {
             $code = $details['code'];
                $order_qty = $details['buyquan'];
                $order_paid = $details['amountpaid'];
                $name=$details['name'];
                
                $totalpaid = ($order_paid * $order_qty) + $totalpaid;
                $order_date = date_format(date_create($details['date']), 'd/m/y ');
                    echo "<div class='w3-center w3-padding-small'><div class = 'w3-card w3-round-large'>
                    <div class='w3-padding-small' style='w3'><b>$name</b><br><hr><a href='productdetail.php?id=$code'><img class='w3-container w3-image' 
                    src=../images/product/$code.png onerror=this.onerror=null;this.src='../images/product/products.png'></a></div>
                    <p><hr><i  class='fa  fa-barcode'  style='font-size:16px'></i> &nbsp&nbspcode: $code<br>";
                    echo  "<i class='fa fa-archive'  style='font-size:16px'></i> &nbsp&nbspBought:$order_qty <br>
                    <i  class='fa  fa-money'  style='font-size:16px'></i> &nbsp&nbspRM $order_paid 
<br><br>
                     </div></div>";
                    }
                    $totalpaid = number_format($totalpaid, 2, '.', '');
                      echo "</div><br><hr><div class='w3-container w3-left'><h4>Total Paid: RM $totalpaid<br>Purchase Date: $order_date<p></div>";
             ?>
            
    </div>
    </div>
   
<script type="text/javascript">
    (function () {
      var burger = document.querySelector('.burger');
      var nav = document.querySelector('#' + burger.dataset.target);

      burger.addEventListener('click', function () {
        burger.classList.toggle('is-active');
        nav.classList.toggle('is-active');
      })
    })();
  </script>

</body>

</html>