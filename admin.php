
<?php
include 'dbconnect.php';
session_start();
$adminid = $_SESSION['adminid'];

if(!isset($adminid)){
   header('location: 1.php');
}

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: 1.php");
    exit;
} 

?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
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
    <?php include 'adminnav.php'?>
    <div id="sidenav">
        <nav>
            <ul>
            <li><a href="admin.php">Dashboard</a></li>
                <li><a href="admin_offer.php">Offers</a></li>
                <li><a href="admin_history.php">Sold History</a></li>
                <li><a href="admin_user.php">Users</a></li>
                <li><a href="admin_message.php">messages</a></li>
            </ul>
        </nav>
    </div>
    <div id="menubtn">
        <img src="images/menu.png" alt="" id="menu">
    </div>
    <div id="dashboard">
        <h1>DASHBOARD</h1>
        <div class="analysis">
            <a href="admin_offer.php"><div class="box">
                <div class="icon">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
                <div class="count">
                <?php 
            $select_messages = mysqli_query($conn, "SELECT * FROM `offers`") or die('query failed');
            $number_of_offers = mysqli_num_rows($select_messages);
         ?>
                    <h2><?php echo $number_of_offers; ?></h2>
                    <p>Total Offers</p>
                </div>
            </div></a>
            <a href=""><div class="box">
                <div class="icon">
                    <i class="fa-solid fa-chart-simple"></i>
                </div>
                <div class="count">
                <?php 
                        $query = "SELECT SUM(paid_amount) AS sum FROM `payment`"; 
                        $query_result = mysqli_query($conn , $query);
                        while($row = mysqli_fetch_assoc ($query_result)) { 
                            $output =$row[ 'sum' ];
                        }
                    ?>
                    <h2>₹<?php echo $output;?></h2>
                    <p>Completed payments</p>
                </div>
            </div></a>
            <a href="admin_offer.php"><div class="box">
                <div class="icon">
                    <i class="fa-solid fa-arrows-left-right-to-line"></i>
                </div>
                <div class="count">
                <?php 
            $select_messages = mysqli_query($conn, "SELECT * FROM `offers` WHERE `user_type` = 'admin'") or die('query failed');
            $number_of_offers = mysqli_num_rows($select_messages);
         ?>
                    <h2><?php echo $number_of_offers; ?></h2>
                    <p>Strike Offers</p>
                </div>
            </div></a>
            <a href="admin_message.php"><div class="box">
                <div class="icon">
                    <i class="fa-solid fa-magnifying-glass-chart"></i>
                </div>
                <div class="count">
                    <?php 
            $select_messages = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
            $number_of_messages = mysqli_num_rows($select_messages);
         ?>
         <h2><?php echo $number_of_messages; ?></h2>
                    <p>Messages</p>
                </div>
            </div></a>
            <a href="admin_user.php?type=staff"><div class="box">
                <div class="icon">
                    <i class="fa-solid fa-chart-bar"></i>
                </div>
                <div class="count">
                <?php 
            $select_admins = mysqli_query($conn, "SELECT * FROM `register` WHERE user_type = 'staff'") or die('query failed');
            $number_of_suser = mysqli_num_rows($select_admins);
         ?>  
                    <h2><?php echo $number_of_suser; ?></h2>
                    <p>Staff Users</p>
                </div>
            </div></a>
            <a href="admin_user.php?type=customer"><div class="box">
                <div class="icon">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div class="count">
                <?php 
            $select_admins = mysqli_query($conn, "SELECT * FROM `register` WHERE user_type = 'customer'") or die('query failed');
            $number_of_nuser = mysqli_num_rows($select_admins);
         ?>  
                    <h2><?php echo $number_of_nuser; ?></h2>
                    <p>Normal Users</p>
                </div>
            </div></a>
            <a href="admin_user.php?type=admin"><div class="box">
                <div class="icon">
                    <i class="fa-solid fa-chart-area"></i>
                </div>
                <div class="count">
                <?php 
            $select_admins = mysqli_query($conn, "SELECT * FROM `register` WHERE user_type = 'admin'") or die('query failed');
            $number_of_admins = mysqli_num_rows($select_admins);
         ?>
                    <h2><?php echo $number_of_admins; ?></h2>
                    <p>Admin Users</p>
                </div>
            </div></a>
            <a href="admin_user.php"><div class="box">
                <div class="icon">
                    <i class="fa-solid fa-bars-progress"></i>
                </div>
                <div class="count">
                <?php 
            $select_messages = mysqli_query($conn, "SELECT * FROM `register`") or die('query failed');
            $number_of_messages = mysqli_num_rows($select_messages);
         ?>
         <h2><?php echo $number_of_messages; ?></h2>
                    <p>Total Accounts</p>
                </div>
            </div></a>
            
        </div>
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