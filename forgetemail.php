<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require "PHPMailer.php";
require "Exception.php";
require "SMTP.php";
session_start();
$showerror=""; 
$email = "";

if(isset($_POST['submit']))
{
    include 'dbconnect.php';
    $_SESSION['email'] = $email;
    $email=$_POST['email'];
    $sql = mysqli_query($conn, "SELECT * FROM `register` WHERE email='$email'");
    $query = mysqli_num_rows($sql);

    if (empty($_POST["email"])){
        $showerror = "Email is required";
    }
    elseif ($query > 0) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $userdata = mysqli_fetch_array($sql);
            //  $username = $userdata['username'];
            $token = $userdata['email'];
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host='smtp.gmail.com';
            $mail->Port=587;
            $mail->SMTPAuth=true;
            $mail->SMTPSecure='tls';
            $mail->Username='20bmiit098@gmail.com';
            $mail->Password='dfrmmxovzsifqgdl';
            $mail->setFrom('20bmiit098@gmail.com', 'Password Reset');
            $mail->addAddress($_POST['email']);
            $mail->isHTML(true);
            $mail->Subject="Your verify code";
            $mail->Body="<p>Dear Customer, </p> <h3>Did you forget your password? If so, please click the link given below to create a new one. <br><br>http://localhost/project/updatepass.php?email=$token</h3>
            <br><br>
            <p>With regrads,</p>
            <b>Strike</b>";
    
            if($mail->send())
            {
               header('location:1.php');   
            }
            else
            {
                $showerror ="Sorry, Invalid email."; 
            }
        }
    }
    elseif((!filter_var($email, FILTER_VALIDATE_EMAIL)))
    {
        $showerror = "Invalid email";
    }
    else
    {
        $showerror ="Sorry, no emails exists, Kindly register your account";    
    }
} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bowling System</title>
    <link rel="stylesheet" href="css/forgotemail.css">
    <link rel="stylesheet" href="css/alert.css">
    <script src="https://kit.fontawesome.com/cd742a0dd6.js" crossorigin="anonymous"></script>
</head>
<style>

</style>

<body>
    <?php
    if ($showerror) {
        echo '
        <div class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
            <strong>Alert!</strong> '. $showerror .' 
        </div>';
    }
    ?>
    <div class="body">
        <div id="homebtn">
            <a href="main.php"><i class="fa-solid fa-house"></i></a>
        </div>
        <div class="form-container sign-in-form">
            <div class="form-box sign-in-box">
                <h2> Recover Account </h2>
                <p>Fill the data correctly</p>
                <form action="" method="POST">
                    <div class="field">
                        <i class="fa-solid fa-at"></i>
                        <input type="email" name="email" placeholder="Email ID">
                    </div>
                    <input class="submit-btn" name="submit" type="submit" value="Send Mail">
                </form>
                <p>Don't have an account? <a href="register.php">Sign up</a></p>
            </div>
        </div>
    </div>
    <script>
    const textInputs = document.querySelectorAll("input");

    textInputs.forEach(textInput => {
        textInput.addEventListener("focus", () => {
            let parent = textInput.parentNode;
            parent.classList.add("active");
        });
        textInput.addEventListener("blur", () => {
            let parent = textInput.parentNode;
            parent.classList.remove("active");
        });
    });
    </script>
</body>

</html>