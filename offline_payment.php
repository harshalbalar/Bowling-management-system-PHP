<?php
include 'dbconnect.php';
session_start();
$showerror="";
$success="";
$staffid = $_SESSION['staffid'];

if(!isset($staffid)){
   header('location: 1.php');
}
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: 1.php");
    exit;
}

if(!isset($_SESSION['players']) && !isset($_SESSION['time']) && !isset($_SESSION['lane'])){
    header('location: booking.php');
}
            $place = $_SESSION['place'];
            $players = $_SESSION['players'];
            $time = $_SESSION['time'];
            $lane_name = $_SESSION['lane'];

            $booking = mysqli_query($conn, "SELECT * FROM `book` WHERE `place` = '$place' and `time` = '$time' and `lane_name` ='$lane_name'") or die('query failed');

            if(!isset($_POST['continue']) && !isset($_POST['check'])){
                $query = "select * from `place` where `pname` = '$place'";
                $result = mysqli_query($conn, $query);
                if($result){
                    while($row = mysqli_fetch_array($result)){
                        $price = $row['price'];
                        $players = $_SESSION['players'];
                        $_SESSION['total_amount'] = $players * $price;
                        $_SESSION['final_price'] = $_SESSION['total_amount'];
                    }
                }
            }  

            if(isset($_POST['check'])){
                $offercoupon = $_POST['offercoupon'];
                $query = "select * from `offers` where `code` = '$offercoupon'";
                $result = mysqli_query($conn, $query);
        
                if($result){
                    if(mysqli_num_rows($result) < 1){
                        $_SESSION['discount']=0;
                        echo "please enter valid coupon code";
                    }
                    while($row = mysqli_fetch_array($result)){
                        $_SESSION['discount'] = $row['discount'];
                    }
                    $_SESSION['discount_added'] = ($_SESSION['total_amount'] * $_SESSION['discount'])/100;
                    $_SESSION['final_price'] = $_SESSION['total_amount'] - $_SESSION['discount_added'];
                }
        }
        if(isset($_POST['continue'])){

            if(mysqli_num_rows($booking) > 0){
                $showerror = "This is been allready booked";
            }
            else{
            $paid_amount = $_SESSION['final_price'];
            $payment_query = "INSERT INTO `payment`(`userid`,`payment_method`, `paid_amount`) VALUES ('$staffid', 'cash','$paid_amount')";
            $result = mysqli_query($conn, $payment_query);
    
            if($result){
                $sql = "select * from payment where userid = '$staffid' order by time desc limit 1";
                $result = mysqli_query($conn, $sql);
    
                if($result){
                    while($row = mysqli_fetch_array($result)){
                        $pid = $row['payment_id'];
                    }
                    $_SESSION['payment_id'] = $pid;
                    $sql = "INSERT INTO `book`(`userid`, `payment_id`, `players`, `lane_name`, `place`, `time`, `status`) VALUES ('$staffid','$pid','$players','$lane_name','$place','$time','1')";
                    $result = mysqli_query($conn, $sql);
    
                    if($result){
                        header('location: staffwoop_lane.php');
                    }
                }
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
    <link rel="stylesheet" href="css/payment.css">
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
    <?php
    if ($showerror) {
        echo '
        <div class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
            <strong>Alert!</strong> '. $showerror .' 
        </div>';
    }
    if ($success) {
        echo '
        <div class="success">
        <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
            <strong>Success!</strong> '.$success.'
        </div>';
        }
    ?>
    <?php
        $sql="SELECT * FROM `register` WHERE `userid` = '$staffid'";  
        $result = mysqli_query($conn ,$sql);
        if(mysqli_num_rows($result) > 0){ 
            $fetch = mysqli_fetch_assoc($result);
        }
    ?>
    <div id="homebtn">
        <a href="staffwoop_lane.php"><i class="fa-solid fa-house"></i></a>
    </div>
    <section class="main">
        <form method="post">
            <div class="title">
                <h1>Share your Contact Details</h1>
            </div>
            <div class="form">
                <input type="email" name="email" value="<?php echo $fetch['email']; ?>" placeholder="Email ID" readonly>
                <input type="text" name="pno" id="phone" value="<?php echo $fetch['cont']; ?>"
                    placeholder="Enter the Phone Number" readonly>
                <input type="text" name="name" id="phone" value="<?php echo $fetch['user']; ?>"
                    placeholder="Enter the Username" readonly>
            </div>
            <div class="title">
                <h1>Unlock Offers and Apply Promocodes</h1>
            </div>
            <div class="form1">
                <div class="field">
                    <p>Enter your offer code : </p> <input type="text" id="Offers" placeholder="Enter your offer code"
                        autocomplete="off" name="offercoupon" onkeyup="this.value = this.value.toUpperCase();">
                </div>
                <div class="field">
                    <p>Applied Discount : </p><input type="text" name="email"
                        value="<?php echo $_SESSION['discount'];?> " readonly>
                </div>
                <div class="field">
                    <p>Total Amount : </p><input type="text" name="email"
                        value="<?php echo $_SESSION['total_amount'];?>">
                </div>
                <div class="field">
                    <p>Discounted Amount : </p><input type="text" name="email"
                        value="<?php echo $_SESSION['discount_added'];?>">
                </div>
                <div class="field">
                    <p>Final price : </p><input type="text" name="email" value="<?php echo $_SESSION['final_price'];?>">
                </div>
                <div class="field">
                    <input type="submit" value="Check" class="btn" name="check">
                </div>
            </div>
            <div class="result">
                <input type="submit" value="Continue" class="btn" name="continue">
            </div>
        </form>
    </section>
</body>

</html>