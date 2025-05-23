<?php
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
            $loggedin = true;
        }else{
            $loggedin = false;
        }
        echo'
        <div class="header">
            <div class="logo">
                <img src="images/logo.png" alt="">
            </div>
            <div class="navbar">
                <ul>
                    <li><a href="main.php">Home</a></li>
                    <li><a href="#abouts">About Us</a></li>
                    <li><a href="#places">Places</a></li>
                    <li><a href="offers.php">Offers</a></li>
                    <li><a href="quick_inquiry.php">Contact Us</a></li>
                </ul>
            </div>
            <div class="option">';
            if(!$loggedin){
                 echo '<a href="1.php"><i class="fa-solid fa-arrow-right-to-bracket"></i> Login now</a>';
            }
            if($loggedin ){
                echo '<a href="profile.php"> Welcome <br>' . $_SESSION['user'] .'</a>';
                echo '<a href="logout.php"> <i class="fa-solid fa-right-from-bracket"></i> Logout </a> ';
            }
            echo'
            </div>
        </div>'
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
.option {
    line-height: 20px;
    text-align: right;
    letter-spacing: 2px;
    color: #fff;
    z-index: 3;
    top: 20px;
    width: 20%;
    display: flex;
    justify-content: space-around;
    align-items: center;
    font-size: 13px;
    text-transform: uppercase;
    /* border: 1px solid wheat; */
}
.option a{
    display: flex;
    justify-content: center;
    align-items: center;
    /* border: 1px solid wheat;     */
    color: #fff;
    text-decoration: none;
}
.option i {
    padding:5px;
    color: #fff;
    font-size: 1.3rem;
}
::-webkit-scrollbar {
    width: 15px; 
    height: 20px; 
}
::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #ff850a,#ff3474);
    border-radius: 50px;
}
::-webkit-scrollbar-track {
    background: #474747;
}
 
</style>

<body>

</body>

</html>