<?php
session_start();
$showalert=false;
$showerror=false;
$message=false;
$Err = "";
$emailErr = "";
$email = "";
include 'dbconnect.php';
if (!$conn) {
    die("Failed".mysli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $name =$_POST['name'];
    $phoneno =$_POST['phoneno'];
    $email =$_POST['email'];
    $msg =$_POST['msg'];
     
    if (empty($_POST["name"]) || empty($_POST["phoneno"]) || empty($_POST["email"]) || empty($_POST["msg"])){
        $Err = "Field is required";
    }
    elseif ((filter_var($email, FILTER_VALIDATE_EMAIL))) {
        $sql = "INSERT INTO `message` ( `name`,`phoneno` ,`email`,`msg`) VALUES ( '$name','$phoneno','$email', '$msg')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $showalert= true;
        }
    }
    elseif((!filter_var($email, FILTER_VALIDATE_EMAIL)))
    {
        $emailErr = "Invalid email";
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
    <link rel="stylesheet" href="css/quick_inquiry.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cd742a0dd6.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <section id="home">
    <?php include 'nav.php'?>
        <div class="control">
            <h1>Message</h1>
            <div class="nav">
                <ul>
                    <li><a href="main.php">Home</a><span>>>Message</span> </li>
                </ul>
            </div>
        </div>
        <div class="banner-text">
            <h1>Message</h1>
        </div>
    </section>
    <div id="sidenav">
        <nav>
            <ul>
                <li><a href="main.php">Home</a></li>
                <li><a href="#abouts">About Us</a></li>
                <li><a href="#places">Places</a></li>
                <li><a href="offers.php">Offers</a></li>
                <li><a href="#home">Contact Us</a></li>
            </ul>
        </nav>
    </div>
    <div id="menubtn">
        <img src="images/menu.png" alt="" id="menu">
    </div>
    <?php
    if ($showalert) {
    echo '
    <div class="success">
    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
        <strong>Success</strong> Successfully Send 
    </div>';
    }
    if ($Err) {
    echo '
    <div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
        <strong>Danger!</strong> '.$Err.'
    </div>';
    }
    if ($emailErr) {
    echo '
    <div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
        <strong>Danger!</strong> '.$emailErr.'
    </div>';
    }
    ?>
    <div id="offer">
        <div class="addoffer">
            <form action="" method="post">
                <h2>Say Something</h2>
                <input type="text" name="name" class="box" placeholder="Full Name" >
                <input type="text" name="phoneno" class="box" placeholder="Phone Number">
                <input type="text" name="email" class="box" placeholder="Email Address" >
                <textarea class="box" name="msg" id="" cols="30" rows="10" placeholder="Type a Message"></textarea>
                <center><input type="submit" value="Submit" name="add_product" class="btn"> </center>
            </form>
        </div>
    </div>
    <section id="footer">
        <div class="title-text">
            <h1>Contact</h1>
        </div>
        <div class="footer-row">
            <div class="footer-left">
                <h1><i class="fa-solid fa-bowling-ball"></i>Messages</h1>
                <p>Address: Plot NO.235/B Bhimpur Village <br> Near Decathlon Dumas Road, Surat, <br> Gujarat 394550</p>
            </div>
            <div class="footer-mid">
                <img src="images/logo.png" alt="">
                <nav>
                    <ul>
                        <li><a href="main.php">Home</a></li>
                        <li><a href="#abouts">About Us</a></li>
                        <li><a href="#places">Places</a></li>
                        <li><a href="offers.php">Offers</a></li>
                        <li><a href="#home">Contact Us</a></li>
                    </ul>
                </nav>
            </div>
            <div class="footer-right">
                <h1>Get In Touch</h1>
                <p><a href=""> Surat, Gujarat, India.<i class="fa-solid fa-location-dot"></i></a></p>
                <p><a href=""> strikeoffical@gmail.com<i class="fa-solid fa-inbox"></i></a></p>
                <p><a href="">+91 9012345678<i class="fa-solid fa-phone"></i></a></p>
            </div>
        </div>
        <div class="social-links">
            <a href=""><i class="fa-brands fa-instagram"></i></a>
            <a href=""><i class="fa-brands fa-twitter"></i></a>
            <a href=""><i class="fa-brands fa-facebook-f"></i></a>
            <a href=""><i class="fa-brands fa-linkedin-in"></i></a>
            <p>Copyright www.strikeoffical.com</p>
        </div>

    </section>
    <script>
        var manubtn = document.getElementById("menubtn");
        var sidenav = document.getElementById("sidenav");
        var menu = document.getElementById("menu");
        var preloader = document.getElementById("loader");
        sidenav.style.right = "-300px";
        menubtn.onclick = function () {
            if (sidenav.style.right == "-300px") {
                sidenav.style.right = "0";
                menu.src = "images/close.png";
            }
            else {
                sidenav.style.right = "-300px";
                menu.src = "images/menu.png";
            }
        }
        window.addEventListener("load", function () {
            preloader.style.display = "none";

        })
        window.addEventListener("scroll", function () {
            var header = document.querySelector(".header");
            header.classList.toggle("sticky", window.scrollY > 0);
        })
        let cardContainers = [...document.querySelectorAll('.card-container')];
        let preBtns = [...document.querySelectorAll('.pre-btn')];
        let nxtBtns = [...document.querySelectorAll('.nxt-btn')];

        cardContainers.forEach((item, i) => {
            let containerDimensions = item.getBoundingClientRect();
            let containerWidth = containerDimensions.width;

            nxtBtns[i].addEventListener('click', () => {
                item.scrollLeft += containerWidth - 200;
            });

            preBtns[i].addEventListener('click', () => {
                item.scrollLeft -= containerWidth + 200;
            });
        });
    </script>
   
</body>

</html>