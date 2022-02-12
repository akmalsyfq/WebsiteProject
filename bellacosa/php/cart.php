<?php
include_once("../php/dbconnectpdo.php");
session_start();

if (isset($_SESSION['sessionid'])) {
    $email = $_SESSION['user_email'];
     $user_name = $_SESSION['user_name'];
    $user_phone = $_SESSION['user_phone'];
}else{
   echo "<script>alert('Please login or register')</script>";
   echo "<script> window.location.replace('login.php')</script>";
}
$sqlcart = "SELECT * FROM cart WHERE email = '$email'";
$stmt = $conn->prepare($sqlcart);
$stmt->execute();
$number_of_rows = $stmt->rowCount();
if ($number_of_rows>0){
   if (isset($_GET['submit'])) {
    if ($_GET['submit'] == "add"){
        $code = $_GET['code'];
        $qty = $_GET['qty'];
        $cartquan = $qty + 1 ;
        $updatecart = "UPDATE `cart` SET `cartquan`= '$cartquan' WHERE email = '$email' AND code = '$code'";
        $conn->exec($updatecart);
        echo "<script>alert('Cart updated')</script>";
    }
    if ($_GET['submit'] == "remove"){
        $code = $_GET['code'];
        $qty = $_GET['qty'];
        if ($qty == 1){
            $updatecart = "DELETE FROM `cart` WHERE email = '$email' AND code = '$code'";
            $conn->exec($updatecart);
            echo "<script>alert('Book removed')</script>";
        }else{
            $cartqty = $qty - 1 ;
            $updatecart = "UPDATE `cart` SET `cartquan`= '$cartquan' WHERE email = '$email' AND code = '$code'";
            $conn->exec($updatecart);    
            echo "<script>alert('Removed')</script>";
        }
        
    }
} 
}else{
    echo "<script>alert('No item in your cart')</script>";
   echo "<script> window.location.replace('mainpage.php')</script>";
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
    
    <script src="https://kit.fontawesome.com/ac93d662e6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="script.js"></script> -->
    
    <title>Bella Cosa</title>
</head>

<body >


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
    
    <div class="w3-main w3-content w3-padding" style="max-width:1200px;">
        <div class="w3-container w3-center"><p><h1> <?php echo $user_name ?>'s Cart </h1></p></div><hr>
        <div class="w3-grid-template">
             <?php
             
             $total_payable = 0.00;
            foreach  ($rowsqty  as  $product)  {
             $name  =  $product['name'];
             $prodesc  =  $product['prodesc'];
             $quantity  =  $product['cartquan'];
             $price  =  $product['price'];
             $code = $product['code'];
             $decpri = number_format($price, 2);
             $pro_total = $quantity * $price;
             $total_payable = $pro_total + $total_payable;
             echo "<div class='w3-center w3-padding-small' id='procard_$code'><div class = 'w3-card w3-round-large'>
             <div class='w3-padding-small'><a href='productdetail.php?id=$code'><img class='w3-container w3-image' 
             src=../images/product/$code.png onerror=this.onerror=null;this.src='../images/product/products.png'></a></div>
             <b>$name</b><br>RM $price/unit<br>
             <input type='button' class='w3-button w3-red' id='button_id' value='-' onClick='removeCart($code,$price);'>
             <label id='qtyid_$code'>$quantity</label>
             <input type='button' class='w3-button w3-green' id='button_id' value='+' onClick='addCart($code,$price);'>
             <br>
            <b><label id='proprid_$code'> Price: RM $pro_total</label></b><br></div></div>";
                }
             ?>
        </div>
        <?php 
        echo "<div class='w3-container w3-padding w3-block w3-center'><p><b><label id='totalpaymentid'> Total Amount Payable: RM $total_payable</label>
        </b></p><a href='payment.php?email=$email&amount=$total_payable' class='w3-button w3-round w3-blue'> Pay Now </a> </div>";
        ?>
        
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
  <script>
 function addCart(code,price) {
	jQuery.ajax({
		type: "GET",
		url: "cartajax.php",
		data: {
			code: code,
			submit: 'add',
			price: price
		},
		cache: false,
		dataType: "json",
		success: function(response) {
			var res = JSON.parse(JSON.stringify(response));
			console.log(res.data.carttotal);
			if (res.status = "success") {
				var code = res.data.code;
			//	document.getElementById("carttotalida").innerHTML = "Cart (" + res.data.carttotal + ")";
				document.getElementById("carttotalidb").innerHTML = "Cart (" + res.data.carttotal + ")";
				document.getElementById("qtyid_" + code).innerHTML = res.data.qty;
				document.getElementById("proprid_" + code).innerHTML = "Price: RM " + res.data.price;
				document.getElementById("totalpaymentid").innerHTML = "Total Amount Payable: RM " + res.data.totalpayable;
			} else {
				alert("Failed");
			}

		}
	});
}

function removeCart(code,price) {
	jQuery.ajax({
		type: "GET",
		url: "cartajax.php",
		data: {
			code: code,
			submit: 'remove',
			price: price
		},
		cache: false,
		dataType: "json",
		success: function(response) {
			var res = JSON.parse(JSON.stringify(response));
			if (res.status = "success") {
				console.log(res.data.carttotal);
				if (res.data.carttotal == null || res.data.carttotal == 0){
				    alert("Cart empty");
				    window.location.replace("mainpage.php");
				}else{
                var code = res.data.code;
                var upqty = res.data.qty;
			//	document.getElementById("carttotalida").innerHTML = "Cart (" + res.data.carttotal + ")";
				document.getElementById("carttotalidb").innerHTML = "Cart (" + res.data.carttotal + ")";
				document.getElementById("qtyid_" + code).innerHTML = res.data.qty;
				document.getElementById("proprid_" + code).innerHTML = "Price: RM " + res.data.price;
				document.getElementById("totalpaymentid").innerHTML = "Total Amount Payable: RM " + res.data.totalpayable;
			    console.log(res.data.qty);
                console.log(upqty);
				if (upqty < 1 || upqty == 0){
				    var element = document.getElementById("procard_"+code);
				    element.parentNode.removeChild(element);
				}    
				}
				
			} else {
				alert("Failed");
			}

		}
	});
}
</script>
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