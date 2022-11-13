<?php
 $login=false;
 $showerror=false;
 $Err=false;
 session_start(); 
 $showerror="";   
 if ($_SERVER["REQUEST_METHOD"]== "POST") {
     include 'dbconnect.php';
     $email = $_POST['email'];
     $pwd = $_POST['pwd'];
     $sql = mysqli_query($conn, "SELECT * FROM `register` WHERE email = '$email'") or die('query failed');
     if (empty($_POST["email"]) || empty($_POST["pwd"])){
         $Err = "Field is required";
     }
     elseif(mysqli_num_rows($sql) > 0){
         $row = mysqli_fetch_assoc($sql);
         if($row['user_type'] == 'admin'){
            if(password_verify($pwd, $row['pwd'])) {
                $login = true;
                $_SESSION['adminid'] = $row['userid'];
                $_SESSION['loggedin'] = true;
                $_SESSION['adminemail'] = $email;
                $_SESSION['admin'] = $row['user'];
                header("location: admin.php");
            }else{
                $showerror = "Invalid Password";
            } 
         }
         elseif($row['user_type'] == 'customer'){
             if(password_verify($pwd, $row['pwd'])){
                $login = true;
                $_SESSION['loggedin'] = true;
                $_SESSION['userid'] = $row['userid'];
                $_SESSION['email'] = $email;
                $_SESSION['user'] = $row['user'];
                header("location: main.php");
            }else{
                $showerror = "Invalid Password";
            } 
        }
        elseif($row['user_type'] == 'staff'){
            if(password_verify($pwd, $row['pwd'])){
                $id = $row['pid']; 
                $query = mysqli_query($conn, "SELECT * FROM `place` WHERE `placeid` = '$id'") or die('query failed');
                if(mysqli_num_rows($query) > 0){
                     $line = mysqli_fetch_assoc($query);
                     $login = true;
                     $_SESSION['loggedin'] = true;
                     $_SESSION['staffid'] = $row['userid'];
                     $_SESSION['placeid'] = $row['pid'];
                     $_SESSION['place'] = $row['place'];
                     header("location: staffwoop_admin.php");
                }
            }else{
                $showerror = "Invalid Password";
            } 
        }
        else{
            $showerror = "Invalid User";
        } 
    }
     else{
        $showerror = "Invalid User";
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
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/cd742a0dd6.js" crossorigin="anonymous"></script>
</head>
<style>

</style>

<body>
    <?php
    if ($login) {
    echo '
    <div class="success">
    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
        <strong>Success</strong> Successfully login 
    </div>';
    }
    if ($showerror) {
    echo '
    <div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
        <strong>Alert!</strong> '. $showerror .' 
    </div>';
    }
    if ($Err) {
    echo '
    <div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
        <strong>Alert!</strong> '.$Err.'
    </div>';
    }
    ?>
    <div class="body">
        <div id="homebtn">
            <a href="main.php"><i class="fa-solid fa-house"></i></a>
        </div>
        <div class="form-container sign-in-form">
            <div class="form-box sign-in-box">
                <h2> Login </h2>
                <form action="1.php" method="POST">
                    <div class="field">
                        <i class="fa-solid fa-at"></i>
                        <input type="email" name="email" placeholder="Email ID">
                    </div>
                    <div class="field">
                        <i class="fa-solid fa-unlock"></i>
                        <input class="password-input" name="pwd" type="password" placeholder="Password">
                        <div class="eye-btn"><i class="fa-solid fa-eye-slash"></i></div>
                    </div>
                    <div class="forgot-link">
                        <a href="forgetemail.php">Forget Password?</a>
                    </div>
                    <input class="submit-btn" type="submit" value="Login">
                </form>
            </div>
            <div class="imgBox sign-in-imgbox">
                <div class="sliding-link">
                    <p>Don't have an account?</p>
                    <span class="sign-up-btn"><a href="register.php"> Sign Up</a></span>
                </div>
                <img src="images/signin-img.png" alt="">
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