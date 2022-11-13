<?php
include 'dbconnect.php';
session_start();
$placeid = $_SESSION['placeid'];
$place = $_SESSION['place'];
$staffid = $_SESSION['staffid'];

if(!isset($placeid)){
   header('location: 1.php');
}
$query = mysqli_query($conn, "SELECT * FROM `place` WHERE placeid = '$placeid'") or die('query failed');

if(mysqli_num_rows($query) > 0){
    $row = mysqli_fetch_assoc($query);
    if(isset($row['image']))
    {
        $_SESSION['image']=$row['image'];
    }
    $_SESSION['place']=$row['pname'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/staffwoop_admin.css">
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
    <?php include"staffnav.php"?>
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
    <div id="dashboard">
        <h1>DASHBOARD</h1>
        <div class="analysis">
            <div class="box">
                <div class="icon">
                    <i class="fa-solid fa-chart-simple"></i>
                </div>
                <div class="count">
                <?php 
                        $query = "SELECT SUM(p.paid_amount) AS sum, b.place FROM payment as p, book as b where p.payment_id = b.payment_id and b.userid = $staffid"; 
                        $query_result = mysqli_query($conn , $query);
                        while($row = mysqli_fetch_assoc ($query_result)) { 
                            $output =$row['sum'];
                        }
                    ?>
                    <h2>₹<?php echo $output;?></h2>
                    <p>Completed payments</p>
                </div>
            </div>
            <div class="box">
                <div class="icon">
                    <i class="fa-solid fa-arrows-left-right-to-line"></i>
                </div>
                <div class="count">
                <?php 
            $select_messages = mysqli_query($conn, "SELECT p.paid_amount, b.* FROM payment as p, book as b where b.payment_id = p.payment_id and b.userid = '$staffid'") or die('query failed');
            $number_of_offers = mysqli_num_rows($select_messages);
         ?>
                    <h2><?php echo $number_of_offers; ?></h2>
                    <p>Order Placed</p>
                </div>
            </div>
            <div class="box">
                <div class="icon">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div class="count">
                <?php 
            $select_messages = mysqli_query($conn, "SELECT * FROM `offers` WHERE `user_type` = '$place'") or die('query failed');
            $number_of_offers = mysqli_num_rows($select_messages);
         ?>
                    <h2><?php echo $number_of_offers; ?></h2>
                    <p>Total Offers</p>
                </div>
            </div>

        </div>
    </div>
    <script>
    var manubtn = document.getElementById("menubtn");
    var sidenav = document.getElementById("sidenav");
    var menu = document.getElementById("menu");
    var preloader = document.getElementById("loader");
    sidenav.style.right = "-300px";
    menubtn.onclick = function() {
        if (sidenav.style.right == "-300px") {
            sidenav.style.right = "0";
            menu.src = "images/close.png";
        } else {
            sidenav.style.right = "-300px";
            menu.src = "images/menu.png";
        }
    }
    </script>
</body>

</html>