<?php
include_once("../php/dbconnectpdo.php");
session_start();
if (isset($_SESSION['sessionid'])) {
  $email = $_SESSION['user_email'];
   $user_name = $_SESSION['user_name'];
  $user_phone = $_SESSION['user_phone'];
}
$code = $_GET['id'];
    $sqlproduct = "SELECT * FROM products WHERE code = '$code'";
    $stmt = $conn->prepare($sqlproduct);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();
 foreach  ($rows  as  $product)  {
        $id = $product['id'];
        $name  =  $product['name'];
        $prodesc  =  $product['prodesc'];
        $quantity  =  $product['quantity'];
        $price  =  $product['price'];
        $code = $product['code'];
 
    }
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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/ac93d662e6.js" crossorigin="anonymous"></script>
    
    <title>Product Detail</title>
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
      
      <div class="w3-row w3-card">
        <div class="w3-half w3-center">
            <img class="w3-image w3-margin w3-center" style="height:100%;width:100%;max-width:330px" src="../images/product/<?php echo $code?>.png">
        </div>
        <div class="w3-half w3-container">
            <?php 
            echo "<div class='w3-center w3-padding-small'><div class = 'w3-card w3-round-large'>
                    <div class='w3-padding-small' style='w3'>
                    <h1>Product Details</h1><hr><b>$name</b></a></div>
                    <p><i  class='fa  fa-barcode'  style='font-size:16px'></i> &nbsp&nbsp Product Code: $code<br><i  class='fa  fa-bars'  style='font-size:16px'></i> &nbsp&nbsp Product Details: $prodesc<br><i class='fa fa-archive'  style='font-size:16px'></i> &nbsp&nbsp$quantity in stock<br>
                    <i  class='fa  fa-money'  style='font-size:16px'></i> &nbsp&nbspRM $price 
                     <br><br>";
            ?>
        </div>
        </div>
    </div>
    </div>
  <footer class="footer has-background-primary-light">
  <div class="content has-text-centered">
    <p>
      <a aria-setsize="50">Bella Cosa</a><br>
      <i class="fab fa-facebook"></i><a href="https://www.facebook.com/akmalsyfq">Find me on facebook</a><br>
      <i class="fab fa-shopify"></i><a
        href="https://shopee.com.my/product/91037664/9126330878?smtt=0.91039142-1635165472.3">Follow me at shopee</a>
      <i class="fas fa-paper-plane"></i><a href="mailto:akmalsyfq@gmail.com">Contact me through email</a>
    </p>
    <bold>COPYRIGHT</bold><i class="far fa-copyright"></i> 2021. All rights reserved.

    </p>
  </div>
</footer>
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
