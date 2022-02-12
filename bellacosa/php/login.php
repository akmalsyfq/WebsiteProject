<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '/home/ppdkpcom/public_html/PHPMailer/src/Exception.php';
require '/home/ppdkpcom/public_html/PHPMailer/src/PHPMailer.php';
require '/home/ppdkpcom/public_html/PHPMailer/src/SMTP.php';

include '../php/dbconnectpdo.php';
if (isset($_POST["submit"])) {

  //  $user_name;
    $email = $_POST["email"];
    $password = sha1($_POST["password"]);
    $otp = '1';
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = '$email' AND  password = '$password'AND otp='$otp'");
    $stmt->execute();
    $number_of_rows = $stmt->rowCount();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();
    if ($number_of_rows  > 0) {
        if ($email == 'admin@shop.com'){
        echo "<script>alert('Login Success');</script>";
        echo "<script> window.location.replace('adminpage.php')</script>";
    }
        else {
            foreach ($rows as $user)
        {
            $user_name = $user['user_name'];
            $user_phone = $user['user_phone'];
           }
        session_start();
        $_SESSION["sessionid"] = session_id();
        $_SESSION["user_email"] = $email;
        $_SESSION["user_name"] = $user_name;
        $_SESSION["user_phone"] = $user_phone;
        echo "<script>alert('Login Success');</script>";
            echo "<script> window.location.replace('mainpage.php')</script>";

        }
    } else {
        echo "<script>alert('Login Failed');</script>";
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
    <title>Login</title>
</head>

<body onload="loadCookies()">


<div class="w3-bar w3-blue-gray" style="max-width:1200px;margin:auto">
    <img src="../images/heda.png" alt="shop banner " >
        <a href="index.php" class="w3-bar-item w3-button w3-left">Home</a>
    </div>    

    <div class="w3-container w3-padding-64 form-container"style="max-width:1200px;margin:auto" >
        <div class="w3-card-4 w3-round ">
            <div class="w3-container w3-light-blue w3-center">
                <h2>Login</h2>
            </div>
            <form name="loginForm" class="w3-container " action="login.php" method="post">
                <p>
                    <label class="w3-text-blue"><b>Email</b></label>
                    <i class="fa fa-envelope icon"></i>
                    <input class="w3-input w3-border w3-round" name="email" type="email" id="idemail" required>
                </p>
                <p>
                    <label class="w3-text-blue"><b>Password</b></label>
                    <i class="fa fa-lock" ></i>
                    <input class="w3-input w3-border w3-round" name="password" type="password" id="idpass" required>
                </p>
                <p>
                    <input class="w3-check" type="checkbox" id="idremember" name="remember" onclick="rememberMe()">
                    <label>Remember Me</label>
                </p>
                <p><div class="w3-container ">
                    <button class="w3-btn w3-round w3-pale-red w3-block" name="submit">Login</button>
                    </div>
                </p>
            </form>
            <p><a href="register.php" style="text-decoration:none;">Dont have an account? Create here.</a><br>
               <a href="" style="text-decoration:none;" onclick="">Forgot your account. Click here.</a>
               </p>
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

    <div id="cookieNotice" class="w3-right w3-block" style="display: none;">
        <div class="w3-blue">
            <h4>Cookie Consent</h4>
            <p>This website uses cookies or similar technologies, to enhance your
                browsing experience and provide personalized recommendations.
                By continuing to use our website, you agree to our
                <a style="color:#115cfa;" href="/privacy-policy">Privacy Policy</a>
            </p>
            <div class="w3-button">
                <button onclick="acceptCookieConsent();">Accept</button>
            </div>
        </div>
        <script>
            let cookie_consent = getCookie("user_cookie_consent");
            if (cookie_consent != "") {
                document.getElementById("cookieNotice").style.display = "none";
            } else {
                document.getElementById("cookieNotice").style.display = "block";
            }
        </script>

</body>

</html>