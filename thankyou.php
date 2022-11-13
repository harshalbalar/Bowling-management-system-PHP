<?php
session_start();
$userid = $_SESSION['userid'];
include 'dbconnect.php';
if(!isset($userid)){
   header('location: 1.php');
}

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: 1.php");
    exit;
} 


if(!isset($_SESSION['payment_id'])){
    header("location: payment.php");
}

$pid = $_SESSION['payment_id'];

$place = "";
$paid_amount = 0;
$players = 0;
$lane_name = "";
$time = "";

$sql = "SELECT p1.*, b1.* from payment as p1, book as b1 where p1.payment_id = b1.payment_id and p1.payment_id = '$pid'";
$result = mysqli_query($conn, $sql);

if($result){
    while($row = mysqli_fetch_array($result)){
        $place = $row['place'];
        $paid_amount = $row['paid_amount'];
        $players = $row['players'];
        $lane_name = $row['lane_name'];
        $time = $row['time'];
    }
}else{
    echo "<br>" . "it's not working";
}

$sql="SELECT * FROM `register` WHERE `userid` = '$userid'";  
    $result = mysqli_query($conn ,$sql);
    if(mysqli_num_rows($result) > 0){ 
        $fetch = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/thankyou.css">
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
<div id="homebtn">
        <a href="main.php"><i class="fa-solid fa-house"></i></a>
    </div>
    <section class="main">
        <div class="box1">
            <div class="title">
                <h1><i class="fa-solid fa-circle-check"></i> Slot is Booked Successfully, Thank you!</h1>
            </div>
            <br>
            <div class="place">
                <h1> <?php echo $place;?> </h1>
                <div class="ticket">
                    <p><?php echo $players;?> Players </p>
                </div>
            </div>
            <div class="ticket">
                <p><?php echo $lane_name;?></p>
            </div>
                <div class="time">
                    <p><?php echo $fetch['email'];?></p>
                </div>
                <div class="time">
                    <p><?php echo $fetch['user'];?></p>
                </div>
            <div class="time">
                <p> Booked Time-slot : <?php echo $time;?></p>
            </div>
            <div class="total ">
                Paid Amount : <?php echo $paid_amount;?>
            </div>
            <div class="btn">
                <a href="main.php" class="btn"><i class="fa-solid fa-arrow-left"></i>Back to Home</a>
            </div>
        </div>
    </section>
</body>

</html>