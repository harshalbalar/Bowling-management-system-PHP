<?php
include 'dbconnect.php';
session_start();
$userid = $_SESSION['userid'];
if(!isset($userid)){
    header('location: 1.php');
} 
$showalert=false;
$showerror=false;
$message=false;
$Err = "";
$login = "";
$emailErr = "";
$email = "";
if(isset($_POST['cpass'])){
    if (count($_POST) > 0) {
        if($_POST['pwd'] == $_POST['npwd'])
        {
            $showerror = "Please enter new password";
        }
        elseif(strlen($_POST['npwd']) < 8)
        {
            $showerror = "Password should be more than 8 character";
        }
        elseif($_POST['npwd'] == $_POST['cpwd']){
            $sql = "SELECT * FROM register WHERE userid= ?";
            $statement = $conn->prepare($sql);
            $statement->bind_param('i', $_SESSION["userid"]);
            $statement->execute();
            $result = $statement->get_result();
            $row = $result->fetch_assoc();
        
            if (! empty($row)) {
                $hashedPassword = $row["pwd"];
                $password = PASSWORD_HASH($_POST["npwd"], PASSWORD_DEFAULT);
                if (password_verify($_POST["pwd"], $hashedPassword)) {
                    $sql = "UPDATE register set pwd=? WHERE userid=?";
                    $statement = $conn->prepare($sql);
                    $statement->bind_param('si', $password, $_SESSION["userid"]);
                    $statement->execute();
                    $login = "Password Changed";
                    session_start();
                    session_unset();
                    session_destroy();
                    header('location:1.php');
                }else{
                    $showerror = "Current Password is not correct";
                }
            }
        }else{
            $showerror ="New Password and Current Password are not matched";
        }
    }
}
if(isset($_POST['update'])){
    
    $email=$_POST['email'];
    $user=$_POST['user'];
    $cont=$_POST['cont'];
        $sql = "update register set email='$email', user = '$user', cont = '$cont' where userid = '{$_SESSION['userid']}'";
        $result = mysqli_query($conn,$sql);
        if($result){
            $login = 'Profile updated.';
        }else{
            $showerror = 'Profile not updated.';
        }
}
if(isset($_POST['delete'])){
    $sql = "delete from register where userid = '$userid'";
    $result = mysqli_query($conn,$sql);
    if($result){
        echo "<script>alert('Delete successfully.')</script>";
        session_start();
        session_unset();
        session_destroy();
        header('location:1.php');
    }else{
        $showerror = 'Delete successfully';
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
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/alert.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cd742a0dd6.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cd742a0dd6.js" crossorigin="anonymous"></script>
</head>

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
    if ($Err){
    echo '
    <div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
        <strong>Alert!</strong> '.$Err.'
    </div>';
    }
    ?>
    <?php
    $sql="SELECT * FROM `register` WHERE `userid` = '$userid'";  
    $result = mysqli_query($conn ,$sql);
      if(mysqli_num_rows($result) > 0){ 
         $fetch = mysqli_fetch_assoc($result);
      }
      ?>
    <div class="body">
        <div id="homebtn">
            <a href="main.php"><i class="fa-solid fa-house"></i></a>
        </div>
        <div class="form-container sign-up-form">
            <div class="form-box sign-up-box">
                <h2>Edit Profile</h2>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="box">
                        <div class="box1">
                            <div class="field">
                                <i class="fa-solid fa-at"></i>
                                <input type="email" name="email" value="<?php echo $fetch['email']; ?>"
                                    placeholder="Email ID" readonly>
                            </div>
                            <div class="field">
                                <i class="fa-regular fa-user"></i>
                                <input type="text" name="user" value="<?php echo $fetch['user']; ?>"
                                    placeholder="Full name">
                            </div>
                            <div class="field">
                                <i class="fa-solid fa-phone"></i>
                                <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                    maxlength="10" name="cont" value="<?php echo $fetch['cont']; ?>"
                                    placeholder="Phone Number">
                            </div>
                        </div>
                    </div>
                    <input class="submit-btn" type="submit" name="update" value="Update Profile">
                    <input class="submit-btn" type="submit" name="delete" value="Delete Profile"
                        style="background-color:#ff5353;;">
                </form>

            </div>
            <div class="form-box sign-up-box">
                <h2>Change Password</h2>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="box">
                        <div class="box2">
                            <div class="field">
                                <i class="fa-solid fa-unlock-keyhole"></i>
                                <input type="password" maxlength="8" name="pwd" placeholder="Old Password">
                            </div>
                            <div class="field">
                                <i class="fa-solid fa-unlock"></i>
                                <input type="password" maxlength="8" name="npwd" placeholder="New Password">
                            </div>
                            <div class="field">
                                <i class="fa-solid fa-key"></i>
                                <input type="password" maxlength="8" name="cpwd" placeholder="Confirm password">
                            </div>
                        </div>
                    </div>
                    <input class="submit-btn" type="submit" name="cpass" value="Change password">
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