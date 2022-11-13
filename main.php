<?php
include 'dbconnect.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
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
        <div class="overlay"></div>
        <video autoplay loop muted plays-inline class="back-video" src="images/backvideo.mp4"></video>
        <?php include 'nav.php'?>
        <div class="banner-text">
            <h1>FUN</h1>
            <h1>TOH YAHAAAN HAI !</h1>
            <p>Easy to streamline your Gaming services, Tags, Coupons, and Billing system.</p>
            <div class="banner-btn">
                <a href="booking.php"><span></span>Book Now</a>
                <a href="#abouts"><span></span>Read More</a>
            </div>
        </div>
    </section>
    <div id="sidenav">
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#abouts">About Us</a></li>
                <li><a href="#places">Places</a></li>
                <li><a href="offers.php">Offers</a></li>
                <li><a href="quick_inquiry.php">Contact Us</a></li>
            </ul>
        </nav>
    </div>
    <div id="menubtn">
        <img src="images/menu.png" alt="" id="menu">
    </div>
    <div class="quick-inquiry">
        <a href="quick_inquiry.php"><button class="qibtn">QUICK INQUIRY</button></a>
    </div>
    <h1 id="offer">Offers for you</h1>
    <div class="offer-list">
        <button class="pre-btn" title="btn"><img src="images/pre.png" alt=""></button>
        <button class="nxt-btn" title="btn"><img src="images/nxt.png" alt=""></button>
        <div class="card-container">
            <?php  
            $select_offers = mysqli_query($conn, "SELECT * FROM `offers`") or die('query failed');
            if(mysqli_num_rows($select_offers) > 0){
                while($row = mysqli_fetch_assoc($select_offers)){
                  ?>
            <a href="offers.php"><div class="offer-card">
                <img src="uploaded_img/<?php echo $row['image']; ?>" class="offer-img" alt="">
                <div class="card-body">
                    <h2 class="name"><?php echo $row['code']; ?> </h2>
                    <h6 class="des"><?php echo $row['desc']; ?></h6>
                </div>
            </div></a>
            <?php
                }
            }
            ?>
        </div>
    </div>



    </div>
    </div>
    <section id="abouts">
        <div class="about-box">
            <div class="about-video">
                <video autoplay loop muted plays-inline class="video" src="images/about.mp4"></video>
            </div>
            <div class="about">
                <div class="about-desc">
                    <div class="title">
                        <h1>BOWLING</h1><img src="images/ball.png" alt="">
                    </div>
                    <p>Take the perfect stride, let go of the ball, knock off pins in style at the bowling arena. At our
                        UV-lit bowling alley, the only thing you lose is track of time. 6 lane bowling with a DJ music
                        playing it’s the only place you had want to come again to bowl.</p>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div id="places">
            <a href="woop.php">
                <div class="place-card">
                    <img src="images/woop_logo.png" class="card-image" alt="">
                </div>
            </a>
            <a href="rebounce.php">
                <div class="place-card">
                    <img src="images/rebounce.png" class="card-image" alt="">
                </div>
            </a>
            <a href="shott.php">
                <div class="place-card">
                    <img src="images/shott.png" class="card-image" alt="">
                </div>
            </a>
            <a href="xplore.php">
                <div class="place-card">
                    <img src="images/xplore.png" class="card-image" alt="">
                </div>
            </a>
            <a href="bb.php">
                <div class="place-card">
                    <img src="images/bb.png" class="card-image" alt="">
                </div>
            </a>
        </div>
    </div>
    <section id="footer">
        <div class="title-text">
            <h1>Contact</h1>
        </div>
        <div class="footer-row">
            <div class="footer-left">
                <h1>Places to bowl</h1>
                <p><i class="fa-solid fa-bowling-ball"></i>Woop</p>
                <p><i class="fa-solid fa-bowling-ball"></i>Rebounce</p>
                <p><i class="fa-solid fa-bowling-ball"></i>Shott</p>
                <p><i class="fa-solid fa-bowling-ball"></i>Xplore</p>
                <p><i class="fa-solid fa-bowling-ball"></i>Black Bunny</p>
            </div>
            <div class="footer-mid">
                <img src="images/logo.png" alt="">
                <nav>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#abouts">About Us</a></li>
                        <li><a href="#places">Places</a></li>
                        <li><a href="offers.php">Offers</a></li>
                        <li><a href="quick_inquiry.php">Contact Us</a></li>
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
    menubtn.onclick = function() {
        if (sidenav.style.right == "-300px") {
            sidenav.style.right = "0";
            menu.src = "images/close.png";
        } else {
            sidenav.style.right = "-300px";
            menu.src = "images/menu.png";
        }
    }
    window.addEventListener("load", function() {
        preloader.style.display = "none";

    })
    window.addEventListener("scroll", function() {
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