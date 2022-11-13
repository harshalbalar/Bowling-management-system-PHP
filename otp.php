<?php
session_start();
$showerror="";   
if(isset($_POST['verify']))
{
    include 'dbconnect.php';
    $otp=$_POST['otp'];
    $email=$_SESSION['email'];
    $sql = mysqli_query($conn, "select * from forget_otp where otp = '$otp' AND email = '$email';");
    $count=mysqli_num_rows($sql);
    if($count>0)
    {
        $result=mysqli_query($conn,"update forget_otp set status=1 where otp=$otp");
        if ($result){
            header('location:1.php');
        }
    } else{
        $showerror = "Enter valid otp!";
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
                <h2> Verify your email </h2>
                <p>Please check your registered email</p>
                <form action="" method="POST">
                    <div class="field">
                        <i class="fa-solid fa-at"></i>
                        <input type="tel" name="otp" placeholder="OTP">
                    </div>
                    <input class="submit-btn" name="verify" type="submit" value="Verify now">
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