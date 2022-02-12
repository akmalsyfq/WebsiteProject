<?php

if (isset($_POST["submit"])) {
    include_once("dbconnectpdo.php");
    $code = $_POST["code"];
    $name = $_POST["name"];
    $prodesc = $_POST["prodesc"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $sqladd = "INSERT INTO `products`(`name`, `code`, `prodesc`, `quantity`, `price`) VALUES('$name', '$code', '$prodesc', '$quantity', '$price')";
    try {
        $conn->exec($sqladd);
        if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
            uploadImage($code);
        }
        echo "<script>alert('Product added successfully')</script>";
        echo "<script>window.location.replace('adminpage.php')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Failed to add product')</script>";
        echo "<script>window.location.replace('newproduct.php')</script>";
    }
}

function uploadImage($code)
{
    $target_dir = "../images/product/";
    $target_file = $target_dir . $code . ".png";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
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
    <title>Add Product</title>
</head>

<body >


    <div class="w3-bar w3-blue-gray "style="max-width:1200px;margin:auto">
        <img src="../images/heda.png" alt="shop banner ">
        <a href="logout.php" class="w3-bar-item w3-button w3-right">Logout</a>
        <a href="adminpage.php" class="w3-bar-item w3-button w3-left">Home</a>
    </div>

    <div class="w3-container w3-padding-32 form-container " style="max-width:1200px;margin:auto">
        <div class="w3-card has-background-warning">
            <div class="w3-container w3-pale-yellow">
                <p>New Product</p>
            </div>
            <form class="w3-container w3-padding" name="registerForm" action="newproduct.php" method="post" enctype="multipart/form-data" onsubmit="return confirmDialog()" >
                <div class="w3-container w3-border w3-center w3-padding">
                    <img class="w3-image w3-round w3-margin" src="../images/products.png" style="width:100%; max-width:600px"><br>
                    <input type="file" onchange="previewFile()" name="fileToUpload" id="fileToUpload"><br>
                </div>

                <p>
                    <label>Product Name</label>
                    <input class="w3-input w3-border w3-round" name="name" id="idname" type="text" required>
                </p>
                <p>
                    <label>Product Code</label>
                    <input class="w3-input w3-border w3-round" name="code"  type="number" required>
                </p>
                <p>
                    <label>Product Description</label>
                    <textarea class="w3-input w3-border" name="prodesc" rows="4" cols="50" width="100%" placeholder="Enter product details" required></textarea>
                </p>
<p>
                    <label>Product Quantity</label>
                    <input class="w3-input w3-border w3-round" name="quantity" type="number" required>
                </p>
<p>
                    <label>Product Price</label>
                    <input class="w3-input w3-border w3-round" name="price"  type="number" required>
                </p>

                <div class="row">
                    <input class="w3-input w3-border w3-block has-background-link-light  w3-round" type="submit" name="submit" value="Add Product">
                </div>

            </form>


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


</body>

</html>