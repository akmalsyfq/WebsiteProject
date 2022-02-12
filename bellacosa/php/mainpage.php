<?php

include_once("../php/dbconnectpdo.php");
session_start();
$email = "Guest";
$user_name = "Guest";
$userphone = "-";

if (isset($_SESSION['sessionid'])) {
    $email = $_SESSION['user_email'];
     $user_name = $_SESSION['user_name'];
    $user_phone = $_SESSION['user_phone'];
}else{
   echo "<script>alert('Please login or register')</script>";
   echo "<script> window.location.replace('login.php')</script>";
}



$carttotal =0;



$stmtqty = $conn->prepare("SELECT * FROM cart INNER JOIN products ON cart.code = products.code WHERE cart.email = '$email'");
$stmtqty->execute();
$resultqty = $stmtqty->setFetchMode(PDO::FETCH_ASSOC);
$rowsqty = $stmtqty->fetchAll();
foreach ($rowsqty as $carts) {
    $carttotal = $carts['cartquan']+$carttotal ;
}

if (isset($_GET['submit']))
{
    include_once ("../php/dbconnectpdo.php");
    
    if ($_GET['submit'] == "cart")
    {
        if ($useremail != "Guest")
        {
            $code = $_GET['code'];
            $cartquan = "1";
            $stmt = $conn->prepare("SELECT * FROM cart WHERE email = '$email' AND code = '$code'");
            $stmt->execute();
            $number_of_rows = $stmt->rowCount();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $rows = $stmt->fetchAll();
            if ($number_of_rows > 0)
            {
                foreach ($rows as $carts)
                {
                    $cartquan = $carts['cartquan'];
                }
                $cartquan = $cartquan + 1;
                $updatecart = "UPDATE `cart` SET `cartquan`= '$cartquan' WHERE email = '$email' AND code = '$code'";
                $conn->exec($updatecart);
                echo "<script>alert('Cart updated')</script>";
                echo "<script> window.location.replace('index.php')</script>";
            }
            else
            {
                $addcart = "INSERT INTO `cart`(`email`, `code`, `cartquan`) VALUES ('$email','$code','$cartquan')";
                try
                {
                    $conn->exec($addcart);
                    echo "<script>alert('Success')</script>";
                    echo "<script> window.location.replace('index.php')</script>";
                }
                catch(PDOException $e)
                {
                    echo "<script>alert('Failed')</script>";
                }
            }

        }
        else
        {
            echo "<script>alert('Please login or register')</script>";
            echo "<script> window.location.replace('login.php')</script>";
        }
    }
    $op = $_GET['submit'];
  $option = $_GET['option'];
  $search = $_GET['search'];
    if ($op == 'search') {
        if ($option == "nama") {
            $sqlproduct = "SELECT * FROM `products` WHERE name LIKE '%$search%'";
        }
        if ($option == "code") {
            $sqlproduct = "SELECT * FROM `products` WHERE code LIKE '%$search%'";
        }
    }
} else {
  $sqlproduct = "SELECT * FROM products";
}

$results_per_page = 10;
    if (isset($_GET['pageno'])) {
        $pageno = (int)$_GET['pageno'];

        $page_first_result = ($pageno - 1) * $results_per_page;
       } else {
        $pageno = 1;
        $page_first_result = ($pageno - 1) * $results_per_page;
       }

$stmt = $conn->prepare($sqlproduct);
$stmt->execute();
$number_of_result = $stmt->rowCount();
    $number_of_page = ceil($number_of_result / $results_per_page);

    $sqlproduct = $sqlproduct . " LIMIT $page_first_result , $results_per_page";

$stmt = $conn->prepare($sqlproduct);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

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
<div class="w3-top" >
        
    </div>
    <div class="w3-main w3-content w3-padding " style="max-width:1200px;">
    <div class="w3-container w3-card w3-padding w3-row w3-round" style="width:100%">
    <h4>Product Search</h4>
        <form action="mainpage.php">
          <div class="w3-row" style='font-size:16px' >
                <div class="w3-threequarter w3-container">
                    <p><input class="w3-input w3-block w3-round w3-border" type="search" id="idsearch" name="search" placeholder="Search" /></p>
                </div>
                <div class="w3-rest w3-container">
                    <p><select class="w3-input w3-block w3-round w3-border" name="option" id="srcid">
                            <option value="nama">By Product Name</option>
                            <option value="code">By Product Code</option>
                            
                        </select>
                    <p>
                </div>
             </div>
             <br>
            <div class="w3-container">
                <p><button class="w3-button w3-light-gray w3-round w3-right" type="submit" name="submit" value="search">Search</button></p>
          </div>

        </form>
    </div>
    <hr>
        
        <div class="w3-grid-template">
        <?php
             foreach  ($rows  as  $product)  {
             $name  =  $product['name'];
             $prodesc  =  $product['prodesc'];
             $quantity  =  $product['quantity'];
             $price  =  $product['price'];
             $code = $product['code'];
             $decpri = number_format($price, 2);
                    echo "<div class='w3-center w3-padding-small'><div class = 'w3-card w3-round-large'>
                    <div class='w3-padding-small' style='w3'><b>$name</b><br><hr><a href='productdetail.php?id=$code'><img class='w3-container w3-image' 
                    src=../images/product/$code.png onerror=this.onerror=null;this.src='../images/product/products.png'></a></div>
                    <p><hr><i  class='fa  fa-barcode'  style='font-size:16px'></i> &nbsp&nbspcode: $code<br>";
                    echo  "<i class='fa fa-archive'  style='font-size:16px'></i> &nbsp&nbsp$quantity in stock<br>
                    <i  class='fa  fa-money'  style='font-size:16px'></i> &nbsp&nbspRM $decpri <hr>
                    <input type='button' class='w3-button w3-pale-red w3-round' id='button_id' value='Add to Cart' onClick='addCart($code);'><br><br>
                     </div></div>";
                    }
             ?>
        </div>
        <hr>
    </div>
    <?php
        $num = 1;
        if ($pageno == 1) {
            $num = 1;
        } else if ($pageno == 2) {
            $num = ($num) + 10;
        } else {
            $num = $pageno * 10 - 9;
        }
        echo "<div class='row-pages'>";
        echo "<center>";
        for ($page = 1; $page <= $number_of_page; $page++) {
            echo '<a href = "mainpage.php?pageno=' . $page . '">&nbsp&nbsp' . $page . ' </a>';
        }
        echo " ( "."Current page: " . $pageno . " )";
        echo "</center>";
        echo "</div>";
        ?>
<body>
    <div class="w3-main w3-content w3-padding " style="max-width:1200px;">
<footer class="footer has-background-primary-light">
  <div class="content has-text-centered" >
    <p>
      <a aria-setsize="50">Bella Cosa</a><br>
      <i class="fab fa-facebook"></i><a href="https://www.facebook.com/akmalsyfq">Find me on facebook</a><br>
      <i class="fab fa-shopify"></i><a
        href="https://shopee.com.my/product/91037664/9126330878?smtt=0.91039142-1635165472.3">Follow me at shopee</a>
      <i class="fas fa-paper-plane"></i><a href="mailto:akmalsyfq@gmail.com">Contact me through email</a>
    </p>
    <bold>COPYRIGHT</bold><i class="far fa-copyright"></i> 2021. All rights reserved.

    </p>
  </div></div>
</footer>
<script>
 function addCart(code) {
	jQuery.ajax({
		type: "GET",
		url: "updatecartajax.php",
		data: {
			code: code,
			submit: 'add',
		},
		cache: false,
		dataType: "json",
		success: function(response) {
		    var res = JSON.parse(JSON.stringify(response));
		    console.log(res.status);
			if (res.status == "success") {
			    console.log(res.data.carttotal);
				document.getElementById("carttotalidb").innerHTML = "Cart (" + res.data.carttotal + ")";
				alert("Success");
			}
			if (res.status == "failed") {
			    alert("Please login/register account");
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