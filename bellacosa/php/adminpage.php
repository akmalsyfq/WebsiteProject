<?php

include_once("../php/dbconnectpdo.php");

if (isset($_GET['button'])) {
  $op = $_GET['button'];
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
    <script src="../js/script.js"></script>
    
    <title>Bella Cosa</title>
</head>

<body >
    
  
  

<div  class="w3-bar  w3-blue-gray" style="max-width:1200px;margin:auto">
<img src="../images/heda.png" alt="shop banner ">
<a  href="logout.php"  class="w3-bar-item  w3-button  w3-right">Logout</a>


<a  href="adminpage.php"  class="w3-bar-item  w3-button  w3-left">Home</a>
<a  href="newproduct.php"  class="w3-bar-item  w3-button  w3-left">Add Product</a>
</div>
<div class="w3-top" >
        
    </div>
    <div class="w3-main w3-content w3-padding " style="max-width:1200px;">
    <div class="w3-container w3-card w3-padding w3-row w3-round" style="width:100%">
    <h4>Product Search</h4>
        <form action="adminpage.php">
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
                <p><button class="w3-button w3-light-gray w3-round w3-right" type="submit" name="button" value="search">Search</button></p>
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
             $pcode = $product['code'];
             $decpri = number_format($price, 2);
                    echo "<div class='w3-center w3-padding-small'><div class = 'w3-card w3-round-large'>
                    <div class='w3-padding-small' style='w3'><b>$name</b><br><hr><img class='w3-container w3-image' 
                    src=../images/product/$pcode.png onerror=this.onerror=null;this.src='../images/product/products.png'></a></div>
                    <p><hr><i  class='fa  fa-barcode'  style='font-size:16px'></i> &nbsp&nbspCode: $pcode<br>";
                    echo  "<i class='fa fa-archive'  style='font-size:16px'></i> &nbsp&nbsp$quantity in stock<br>
                    <i  class='fa  fa-money'  style='font-size:16px'></i> &nbsp&nbspRM $decpri</p><hr>";
                    
                    echo "<table class='w3-table'><tr>
            <td class='w3-center'><a href=updateproduct.php?id=$pcode>
            <i class='fa fa-edit' style='font-size:32px' onClick=
            'return updateDialog()' style='text-decoration:none'></i></a></td>
            <td class='w3-center'><a href='adminpage.php?id=$pcode'>
            <i class='fa fa-trash-o' style='font-size:32px' onClick=
            'return deleteDialog($pcode)' style='text-decoration:none'></i></a></td>
            </tr></table>";
           echo" </div></div>";
                    
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
            echo '<a href = "adminpage.php?pageno=' . $page . '">&nbsp&nbsp' . $page . ' </a>';
        }
        echo " ( "."Current page: " . $pageno . " )";
        echo "</center>";
        echo "</div>";
        ?>
<body>
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
  
</body>

</html>