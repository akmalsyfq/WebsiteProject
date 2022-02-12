<?php


if (isset($_POST['submit'])) {
    include_once("dbconnectpdo.php");
    $id = $_GET["id"];
    $code = $_POST["code"];
    $name = $_POST["name"];
    $prodesc = $_POST["prodesc"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    
          $sqlupdate =" UPDATE `products` SET `name`='$name',`prodesc`='$prodesc',`quantity`='$quantity',`price`='$price' WHERE code='$id'";
    try {
        $conn->exec($sqlupdate);
        if (
            file_exists($_FILES["fileToUpload"]["tmp_name"]) ||
            is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])
        ) {
            uploadImage($code);
        }
        echo "<script>alert('Successful')</script>";
        echo "<script>window.location.replace('adminpage.php?')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Failed')</script>";
        echo "<script>window.location.replace('updateproduct.php')</script>";
        }
}

function uploadImage($code)
{
    $target_dir = "../images/product/";
    $target_file = $target_dir . $code . ".png";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}


if (isset($_GET['id'])) {
    include_once("dbconnectpdo.php");
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
    
    <title>Update product</title>
</head>


<body>
 <div class="w3-bar w3-blue-gray "style="max-width:1200px;margin:auto">
        <img src="../images/heda.png" alt="shop banner ">
        <a href="logout.php" class="w3-bar-item w3-button w3-right">Logout</a>
        <a href="adminpage.php" class="w3-bar-item w3-button w3-left">Home</a>
    </div>
    <div class="w3-container  w3-padding-64 form-container"style="max-width:1200px;margin:auto">
        <div class="w3-card-4 w3-round">
            <div class="w3-container w3-pink">
                <p>Update Product</p>
            </div>
            <div class="w3-container">
            <form class="w3-container w3-padding" name="registerForm" method="post" enctype="multipart/form-data" onsubmit="return updateDialog()" >
                <div class="w3-container w3-border w3-center w3-padding">
                    <img class="w3-image w3-round w3-margin" src="../images/product/<?php echo $code ?>.png" onerror=this.onerror=null;this.src="../images/products.png" style="width:100%; max-width:600px"><br>
                    <input type="file" onchange="previewFile()" name="fileToUpload" id="fileToUpload"><br>
                </div>

                <p>
                    <label>Product Name</label>
                    <input class="w3-input w3-border w3-round" name="name" type="text" value="<?php echo $name ?>" required>
                </p>
                <p>
                    <label>Product Code</label>
                    <input class="w3-input w3-border w3-round" name="code"  type="text" value="<?php echo $code ?>"  readonly="readonly" required>
                </p>
                <p>
                    <label>Product Description</label>
                    <textarea class="w3-input w3-border" name="prodesc" rows="4" cols="50" width="100%" required><?php echo $prodesc ?> </textarea>
                </p>
<p>
                    <label>Product Quantity</label>
                    <input class="w3-input w3-border w3-round" name="quantity" type="number" value="<?php echo $quantity ?>" required>
                </p>
<p>
                    <label>Product Price</label>
                    <input class="w3-input w3-border w3-round" name="price"  type="number" value="<?php echo $price ?>" required>
                </p>

                <div class="row">
                    <input class="w3-input w3-border w3-block w3-sand w3-round" type="submit" name="submit" value="Update Product">
                </div>

            </form>
            </div>
      
        </div>
    </div>
</body>

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
</html>