<?php
session_start();
$showalert=false;
$showerror=false;
$message=false;
$Err = "";
$emailErr = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"]== "POST") {
    include 'dbconnect.php';
    $email=$_POST['email'];
    $user=$_POST['user'];
    $cont=$_POST['cont'];
    $pwd=$_POST['pwd'];
    $cpwd=$_POST['cpwd'];
    $type=$_POST['user_type'];
    $email = test_input($_POST["email"]);
    $select_users = mysqli_query($conn, "SELECT * FROM `register` WHERE email = '$email'") or die('query failed');
    if(mysqli_num_rows($select_users) > 0){
        $message=true;
    }
    elseif (empty($_POST["email"]) || empty($_POST["user"]) || empty($_POST["cont"]) || empty($_POST["pwd"]) || empty($_POST["cpwd"])){
        $Err = "Field is required";
    }
    elseif(strlen($pwd) < 8)
    {
        $emailErr = "Password should be more than 8 character";
    }
    elseif (($pwd == $cpwd) && (filter_var($email, FILTER_VALIDATE_EMAIL)) && preg_match("/^[a-zA-Z-' ]*$/",$user)) {
        if (($string = !preg_replace('/\s+/', '', $user)) || ($string = !preg_replace('/\s+/', '', $pwd))) {
            $Err = "Whitespace is not allowed";
        }
        else{
            $hash = password_hash($pwd, PASSWORD_DEFAULT);
            $sql="INSERT INTO `register` (`email`, `user`, `cont`, `pwd`,`user_type`) VALUES ( '$email', '$user', '$cont', '$hash','$type');";
            $result = mysqli_query($conn ,$sql);
            if ($result) {
                $showalert= true;
                $str_result = '0123456789';
                $otp= substr(str_shuffle($str_result),0,6);
                $otp_query="INSERT INTO `forget_otp` VALUES ('','$otp','0',CURRENT_TIMESTAMP(),'$email');";    
                $otp_result = mysqli_query($conn ,$otp_query);
            
                    $sql1 = "SELECT * FROM `register` WHERE email = '$email'";
                    $query=mysqli_query($conn,$sql1);
                    $emailcount = mysqli_num_rows($query);
               
                    if(($emailcount>0) && (mysqli_num_rows($query) > 0)){
                        $userdata = mysqli_fetch_array($query);
                        $username = $userdata['username'];
                        $token = $userdata['email'];
                       
                        $email = $_POST['email'];
                        echo $email;
               
                        $subject = "Password Reset";
                        $body = "Hi, Thank you for registration. Please verify your email via one time password $otp";
                        $sender_email = "From: 20bmiit098@gmail.com";
               
                        if(mail($email, $subject, $body, $sender_email)) {
                        $_SESSION['email'] = $email;
                           header('location:otp.php');
                        }
                        else{
                            $Err = "Otp sending failed....";
                        }
                    }
                    else{
                        $Err = "Invalid Credentials";
                    }
            }
        }
    }
    elseif(!preg_match("/^[a-zA-Z-' ]*$/",$user)){
        $emailErr = "Invalid username";
    }
    elseif((!filter_var($email, FILTER_VALIDATE_EMAIL)))
    {
        $emailErr = "Invalid email";
    }
    else{
        $showerror=true;
    }
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bowling System</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/cd742a0dd6.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include "alert.php" ?>
    <div class="body">
        <div id="homebtn">
            <a href="main.php"><i class="fa-solid fa-house"></i></a>
        </div>
        <div class="form-container sign-up-form">
            <div class="imgBox sign-up-imgbox">
                <div class="sliding-link">
                    <p>Already a member?</p>
                    <span class="sign-in-btn"><a href="1.php"> Sign in</a></span>
                </div>
                <img src="images/signup-img.png" alt="">
            </div>
            <div class="form-box sign-up-box">
                <h2>Sign Up</h2>
                <form action="register.php" method="post" enctype="multipart/form-data">
                    <div class="field">
                        <i class="fa-solid fa-at"></i>
                        <input type="email" name="email" placeholder="Email ID">
                    </div>
                    <div class="field">
                        <i class="fa-regular fa-user"></i>
                        <input type="text" name="user" placeholder="Full name">
                    </div>
                    <div class="field">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                            maxlength="10" name="cont" placeholder="Phone Number">
                    </div>
                    <div class="field">
                        <i class="fa-solid fa-unlock"></i>
                        <input type="password" maxlength="8" name="pwd" placeholder="Password">
                    </div>
                    <div class="field">
                        <i class="fa-solid fa-key"></i>
                        <input type="password" maxlength="8" name="cpwd" placeholder="Confirm password">
                    </div>
                        <input type="hidden" name="user_type" value="customer">
                    <input class="submit-btn" type="submit" value="Sign Up">
                </form>

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

    const passwordInput = document.querySelector(".password-input");
    const eyeBtn = document.querySelector(".eye-btn");
    eyeBtn.addEventListener("click", () => {
        if (passwordInput.type == "password") {
            passwordInput.type = "text";
            eyeBtn.innerHTML = "<i class='fa-solid fa-eye'></i>";
        } else {
            passwordInput.type = "password";
            eyeBtn.innerHTML = "<i class='fa-solid fa-eye-slash'></i>";
        }
    })
    </script>
</body>

</html>