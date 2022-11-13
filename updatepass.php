<?php
include 'dbconnect.php';
session_start();
$showerror=""; 
if(isset($_POST['submit'])){
    if(isset($_GET['email'])){
        $token=$_GET['email'];
        $npwd=mysqli_real_escape_string($conn, $_POST['npwd']);
        $cpwd=mysqli_real_escape_string($conn, $_POST['cpwd']);

        if (empty($_POST["npwd"]) || empty($_POST["cpwd"])){
            $showerror = "Password is required";
        }
        elseif($npwd == $cpwd){
                  $pass = password_hash($npwd, PASSWORD_DEFAULT);
                  $updateqry = "update register set pwd = '$pass' where email = '$token'";
                  $result = mysqli_query($conn, $updateqry);
                  if($result){
                        // $_SESSION['msg'] = "Your password has been updated.";
                      header('location:1.php');
                  }else{
                      $showerror = "Your password has not been updated.";
                      header('location:updatepass.php');
                  }
              }
      else{
          $showerror = "Password is not matching.";
      }
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
                <h2> Update Password </h2>
                <p>Fill both the field correctly</p>
                <form action="" method="POST">
                    <div class="field">
                        <i class="fa-solid fa-unlock"></i>
                        <input class="password-input" type="password" maxlength="8" name="npwd"
                            placeholder="New Password">
                    </div>
                    <div class="field">
                        <i class="fa-solid fa-key"></i>
                        <input class="password-input" type="password" maxlength="8" name="cpwd"
                            placeholder="Confirm password">
                    </div>
                    <input class="submit-btn" type="submit" name="submit" value="Update Password">
                </form>
                <p>Have an account? <a href="1.php">Log In</a></p>
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