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
$sqlpayment = "SELECT * FROM payment WHERE payown = '$useremail' ORDER BY paydate DESC";
$stmt = $conn->prepare($sqlpayment);
$stmt->execute();
$number_of_rows = $stmt->rowCount();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

  $carttotal =0;



    $stmtqty = $conn->prepare("SELECT * FROM cart INNER JOIN products ON cart.code = products.code WHERE cart.email = '$useremail'");
    $stmtqty->execute();
    $resultqty = $stmtqty->setFetchMode(PDO::FETCH_ASSOC);
    $rowsqty = $stmtqty->fetchAll();
    foreach ($rowsqty as $carts) {
        $carttotal = $carts['cartquan']+$carttotal ;
    }

?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/ac93d662e6.js" crossorigin="anonymous"></script>
    
    <title>Profile Detail</title>
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
  </nav>
</div>
         
    
 <div class="w3-main w3-content w3-padding" style="max-width:1200px; ">
      
     
         <?php  echo "<br><div class='w3-container w3-center'><h2>Order History</h2><p>Name: $user_name <br>Phone: (+60)$user_phone<br><p></div>";?><hr>
      
        <?php 
            $totalpaid = 0.0;
               $count = 0;
                foreach ($rows as $payments){
                    $paymentid = $payments['payid'];
                    $paymentreceipt = $payments['payreceipt'];
                    $paymentpaid = number_format($payments['paypaid'], 2, '.', '');
                    $totalpaid = $paymentpaid + $totalpaid;
                    //$count++;
                    $paymentdate = date_format(date_create($payments['paydate']),"d/m/Y ");
                     echo "<div class='w3-left w3-padding-small'><div class = 'w3-card w3-round-large w3-padding'>
                    <div class='w3-container w3-center w3-padding-small'><b>Receipt ID: $paymentreceipt</b></div><br>
                    Amount Paid: RM $paymentpaid<br>Date: $paymentdate<br>
                    <div class='w3-button w3-blue w3-round w3-block'><a style='text-decoration: none;' href='paymentdetail.php?receipt=$paymentreceipt'>Details</a></div>
                    </div></div>";
                }
                $totalpaid = number_format($totalpaid, 2, '.', '');
                $totalpaid = number_format($totalpaid, 2, '.', '');
            
            ?>
         
        <div class=" w3-container w3-center w3-padding" >
            
               <?php
        echo "<br><div class='w3-container w3-center'><hr><p>Total Paid: RM $totalpaid<p></div>";?>
               
               
               
               
               
               
    </div>

    
        </div>  
<footer class="footer has-background-primary-light" >
  <div class="content has-text-centered">
    <p>
      <a aria-setsize="50">Bella Cosa</a><br>
      <i class="fab fa-facebook"></i><a href="https://www.facebook.com/akmalsyfq">Find me on facebook</a><br>
      <i class="fab fa-shopify"></i><a
        href="https://shopee.com.my/product/91037664/9126330878?smtt=0.91039142-1635165472.3">Follow me at shopee</a>
      <i class="fas fa-paper-plane"></i><a href="mailto:akmalsyfq@gmail.com">Contact me through email</a>
    </p>
    <bold>COPYRIGHT</bold><i class="far fa-copyright"></i> 2021. All rights reserved.     
   </body>
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
</html>