<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '/home/ppdkpcom/public_html/PHPMailer/src/Exception.php';
require '/home/ppdkpcom/public_html/PHPMailer/src/PHPMailer.php';
require '/home/ppdkpcom/public_html/PHPMailer/src/SMTP.php';

if (isset($_POST["submit"])) {
    include_once("../php/dbconnectpdo.php");
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password =sha1( $_POST["password"]);
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $otp = rand(10000, 99999);
    
    $sqlreg = "INSERT INTO `users`( `user_name`, `email`, `password`, `user_phone`, `otp`, `address`) VALUES ('$username','$email','$password','$phone','$otp','$address')";
    try {
        $conn->exec($sqlreg);
        sendMail($email,$otp);
        echo "<script>alert('Registered Successfully')</script>";
        echo "<script>window.location.replace('mainpage.php')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Failed to Register')</script>";
    }
}

function sendMail($email,$otp){
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 0;                                               //Disable verbose debug output
    $mail->isSMTP();                                                    //Send using SMTP
    $mail->Host       = 'mail.ppdkp.com';                          //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                           //Enable SMTP authentication
    $mail->Username   = 'akmalsyafiq@ppdkp.com';  
    $mail->Password   = 'akmalsyafiq';                                 //g(v!@D([]7UP$K7wty  /  T0MizfNmCddW
    $mail->SMTPSecure = 'tls';         
    $mail->Port       = 587;
    $from = "akmalsyafiq@ppdkp.com";
    $to = $email;
    $subject = 'Bellacosa Shop - Please verify your account';
    $message = "<h2>Welcome to Bellacosa Shop</h2> <p>Thank you for registering your account with us. To complete your registration please click the following.<p>
    <p><button><a href ='https://ppdkp.com/bellacosa/php/verifyaccount.php?email=$email&otp=$otp'>Verify Here</a></button>";
    
    $mail->setFrom($from,"Bellacosa Shop");
    $mail->addAddress($to);                                             //Add a recipient
    
    //Content
    $mail->isHTML(true);                                                //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->send();
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
    <title>Register</title>
</head>

<body >


    <div class="w3-bar w3-blue-gray" style="max-width:1200px;margin:auto"> 
        <img src="../images/heda.png" alt="shop banner " >
        <a href="index.php" class="w3-bar-item w3-button w3-left">Home</a>
    </div>

    <div class="w3-container w3-padding-64 form-container " style="max-width:1200px;margin:auto">
        <div class="w3-card has-background-warning">
            <div class="w3-container w3-pale-yellow">
                <p>New User Registration</p>
            </div>
            <form class="w3-container w3-padding" name="registerForm" action="register.php" method="post" enctype="multipart/form-data" onsubmit="return confirmDialog()" >
               

                <p>
                    <label>Name</label>
                    <i class="fa fa-user-o" ></i>
                    <input class="w3-input w3-border w3-round" name="username" id="idname" type="text" required>
                </p>
                <p>
                    <label>Email</label>
                    <i class="fa fa-envelope icon"></i>
                    <input class="w3-input w3-border w3-round" name="email"  type="text" required>
                </p>
                
<p>
                    <label>Password</label>
                    <i class="fa fa-lock" ></i>
                    <input class="w3-input w3-border w3-round" name="password" type="password" required>
                </p>
                
                <p>
                    <label>Phone Number</label>
                    <i class="fa fa-phone icon"></i>
                    <input class="w3-input w3-border w3-round" name="phone"  type="text" required>
                </p>
                
                <p>
                    <label>Address</label>
                    <i class="fa fa-home icon"></i>
                    <input class="w3-input w3-border w3-round" name="address"  type="text" required>
                </p>
<br>

                <div class="row">
                    <input class="w3-input w3-border w3-block has-background-link-light  w3-round" type="submit" name="submit" value="Register">
                </div>

            </form>


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

    </p>
  </div>
</footer>


</body>

</html>