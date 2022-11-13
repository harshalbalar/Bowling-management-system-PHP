<?php
session_start();
$placeid = $_SESSION['placeid'];

if(!isset($placeid)){
   header('location: 1.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/staffwoop_bookwoop.css">
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
    <div id="sidenav">
        <nav>
            <ul>
            <li><a href="staffwoop_admin.php">Dashboard</a></li>
                    <li><a href="staffwoop_lane.php">Lanes</a></li>
                    <li><a href="staffwoop_offers.php">Offers</a></li>
                    <li><a href="staffwoop_history.php">History</a></li>
            </ul>
        </nav>
    </div>
    <div id="menubtn">
        <img src="images/menu.png" alt="" id="menu">
    </div>
    <div class="control">
        <h1><?php echo $_SESSION['place']; ?></h1>
        <div class="nav">
            <ul>
                <li><a href="staffwoop_admin.php">Home</a><span>>> Lane Booking</span> </li>
            </ul>
        </div>
    </div>
    <div class="banner-text">
        <img src="data: image/jpg;charset=utf8;base64,<?php echo base64_encode($_SESSION['image']); ?>" />
    </div>
    <div id="lane">
        <a href=""><input type="image" src="images/1.png" alt="" class="btn"></a>
        <a href=""><input type="image" src="images/2.png" alt="" class="btn"></a>
        <a href=""><input type="image" src="images/3.png" alt="" class="btn"></a>
        <a href=""><input type="image" src="images/4.png" alt="" class="btn"></a>
        <a href=""><input type="image" src="images/5.png" alt="" class="btn"></a>
        <a href=""><input type="image" src="images/6.png" alt="" class="btn"></a>
    </div>
    <div class="proceedbtn">
        <form action="" class="pbtn" >
            <input type="submit" value="Book now">
        </form>
    </div>
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
    </script>
</body>

</html>