<?php
include 'dbconnect.php';
session_start();
$placeid = $_SESSION['placeid'];

if(!isset($placeid)){
   header('location: 1.php');
}
$showerror="";
$success="";
if(isset($_POST['proceed']) && ($_POST['proceed']) == 'Proceed'){
    $players = $_POST['players'];
    $place = $_POST['place'];
    $time = $_POST['time'];
    $status = $_POST['status'];
    if(isset($_POST['lane'])){
        $lane_name = $_POST['lane'];
        $booking = mysqli_query($conn, "SELECT * FROM `book` WHERE `place` = '$place' and `time` = '$time' and `lane_name` ='$lane_name'") or die('query failed');

        if(mysqli_num_rows($booking) > 0){
            $showerror = "This is been allready booked";
        }
        elseif($_POST['place'] == 'Please select place' && $_POST['players'] == 'Please select players' && $_POST['time'] == 'Please select time'){
            $showerror = "feild is required";
        }else{
                $_SESSION['place'] = $place;
                $_SESSION['time'] = $time;
                $_SESSION['players'] = $players;
                $_SESSION['lane'] = $lane_name;
    
                $_SESSION['discount'] = 0;
                $_SESSION['total_amount'] = 0;
                $_SESSION['discount_added'] = 0;
                $_SESSION['final_price'] = 0;

                header('location:offline_payment.php');
        }
    }
    else{
        $showerror = "Please select details";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/staffwoop_lane.css">
    <link rel="stylesheet" href="css/alert.css">
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
        <?php include"staffnav.php"?>
        <div class="banner-text">
            <img src="data: image/jpg;charset=utf8;base64,<?php echo base64_encode($_SESSION['image']); ?>" />
        </div>
    </section>
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
    <div class="information">
        <div class="info">
            <h1><?php echo $_SESSION['place']; ?></h1>
            <div class="timezone">
                <div class="date">
                    <?php
                        echo date(" F j  Y") . "<br>";
                    ?>
                </div>
                <div class="time">
                    <i class="fa-regular fa-clock"></i>
                    <p> : 10:00AM to 11:00PM</p>
                </div>
            </div>
        </div>
    </div>
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
    <div class="mainbox">
        <div class="book">
            <form action="" class="" method="post">
                <div class="box1">
                    <input type="hidden" name="status" value="1">
                    <input type="hidden" name="place" value="<?php echo $_SESSION['place']; ?>">
                    <select name="players" id="">
                        <option value="Please select players">Please select players</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                    <select name="time" id="">
                        <option value="Please select time">Please select time</option>
                        <?php
                        $sql = "SELECT * FROM `lane`";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            // date_default_timezone_set('Asia/Kolkata');
                            // $current_time = date("g:i A");
                            // $arr=explode(":",$current_time);
                            // $current_time=$arr[0];
                            // $current_time = date("g:i A");
                            // $arr=explode(" ",$current_time);
                            //     $ampm=$arr[1];
                            // echo $arr[1];
                            // $arr=explode(":",$row['time']);

                            // $temptime=$arr[0];
                            // echo " temp time ".$temptime;

                            // $current_time = date("g:i A");
                            // $arr=explode(":",$current_time);
                            // // echo $arr[0];
                            // $current_time=$arr[0];
                            // echo " current time==".$current_time;
                            // // echo $temptime;
                            // $arr=explode(" ",$row['time']);
                            // $tempampm=$arr[1];

                            
                            // if($current_time<$temptime && $tempampm==$ampm){ 
                        ?>
                        <option value="<?php echo $row['time']; ?>"><?php echo $row['time']; ?></option>
                        <?php
                                }
                        
                        // }
                        ?>
                    </select>
                </div>
                <div class="slots">
                    <?php
                        $sql = "SELECT * FROM `lane` WHERE `lane_name` IS NOT NULL";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
    
                        ?>
                    <div class="time-slot">
                        <input type="radio" value="<?php echo $row['lane_name']; ?>" class="timebtn"
                            id="<?php echo $row['lane_name']; ?>" name="lane">
                        <label for="<?php echo $row['lane_name']; ?>"><?php echo $row['lane_name']; ?><i
                                class="fa-solid fa-bowling-ball"></i></label>
                    </div>
                    <?php
                        }
                    
                ?>
                </div>
                <input type="hidden" name="status" value="1">
                <div class="pbtn">
                    <input type="submit" value="Proceed" name="proceed">
                    <input type="reset" value="Reset" class="reset">
                </div>
            </form>
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