
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
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `book` WHERE lane_id = '$delete_id'") or die('query failed');
    header('location:staffwoop_history.php');
}
 
?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin_history.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cd742a0dd6.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
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
    <div id="history">
        <h1>Booking History</h1>
        <div class="container mt-5">

        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Place</th>
                    <th scope="col">Lane</th>
                    <th scope="col">Time</th>
                    <th scope="col">Players</th>
                    <th scope="col">Paid Amount</th>
                    <th scope="col">Delete User</th>
                </tr>
            </thead>
            <tbody>
                    <?php
                    $sql = "SELECT p.paid_amount, b.* FROM payment as p, book as b where b.payment_id = p.payment_id";
                    $result = mysqli_query($conn, $sql);
                    $sno=0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sno=$sno+1;
                    ?><tr>
                        <th scope='row'><?php echo $sno; ?></th>
                        <td><?php echo $row['place']; ?></td>
                        <td><?php echo $row['lane_name']; ?></td>
                        <td><?php echo $row['time']; ?></td>
                        <td><?php echo $row['players']; ?></td>
                        <td><?php echo $row['paid_amount']; ?></td>
                        <td class='delete' onclick="return confirm('Delete this User?');"> <a href="staffwoop_history.php?delete=<?php echo $row['lane_id'];?>" >Delete</a></td>
                    </tr>
                    <?php
                    }
                ?>
                </tbody>
        </table>
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
    function delete() {        
        confirm('Delete this Message?');;
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    </script>
</body>

</html>