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
$Err=false;
$success=false;
if(isset($_POST['add_product'])){

    $desc = $_POST['desc'];
    $discount = $_POST['discount'];
    $user_type = $_POST['user_type'];
    $code = $_POST['code'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/'.$image;
 
    $select_product_name = mysqli_query($conn, "SELECT code FROM `offers` WHERE code = '$code'") or die('query failed');
 
    if(mysqli_num_rows($select_product_name) > 0){
        $Err = 'product name already added';
    }
    else{
        
        if($image_size > 2000000){
            $Err = 'image size is too large';
        }
        elseif (empty($_POST["desc"]) && empty($_POST["image"]) && empty($_POST["price"]) && empty($_POST["code"])){
            $Err = "Offers detail is not filled";
        }
        else{
            $add_product_query = mysqli_query($conn, "INSERT INTO `offers`(`desc`, `image`, `discount`, `code`,`user_type`) VALUES ('$desc', '$image', '$discount', '$code', '$user_type')") or die('query failed');
             move_uploaded_file($image_tmp_name, $image_folder);
             $success = 'Product added successfully!';
          }
       
    }
 }
 if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_image_query = mysqli_query($conn, "SELECT image FROM `offers` WHERE id = '$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    unlink('uploaded_img/'.$fetch_delete_image['image']);
    mysqli_query($conn, "DELETE FROM `offers` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_offer.php');
 }

 if(isset($_POST['update_product'])){
 
    $update_user_type = $_POST['update_user_type'];
    $update_p_id = $_POST['update_p_id'];
    $update_desc = $_POST['update_desc'];
    $update_discount = $_POST['update_discount'];
    $update_code = $_POST['update_code'];
 
    mysqli_query($conn, "UPDATE `offers` SET `user_type` = '$update_user_type',`desc` = '$update_desc' , `discount` = '$update_discount', `code` = '$update_code' WHERE id = '$update_p_id'") or die('query failed');
 
    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'uploaded_img/'.$update_image;
    $update_old_image = $_POST['update_old_image'];
 
    if(!empty($update_image)){
       if($update_image_size > 2000000){
          $message[] = 'image file size is too large';
       }else{
          mysqli_query($conn, "UPDATE `offers` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
          move_uploaded_file($update_image_tmp_name, $update_folder);
          unlink('uploaded_img/'.$update_old_image);
       }
    }
 
    header('location:admin_offer.php');
 
 }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin_offer.css">
    <link rel="stylesheet" href="css/alert.css">
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
    <?php include 'adminnav.php';
    if ($Err) {
        echo '
        <div class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
            <strong>Alert!</strong> '.$Err.'
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
    <div class="offerbox">
        <div class="offerbox1">
            <h1 class="title">Offers data</h1>
            <div class="container mt-5">

                <table class="table " id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Image</th>
                            <th scope="col">Description</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Code</th>
                            <th scope="col">User</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                    $sql = "SELECT * FROM `offers`";
                    $result = mysqli_query($conn, $sql);
                    $sno=0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sno=$sno+1;
                        echo "<tr>
                        <th scope='row'>". $sno . "</th>
                        <td>". $row['image'] . "</td>
                        <td>". $row['desc'] . "</td>
                        <td>". $row['discount'] . "</td>
                        <td>". $row['code'] . "</td>
                        <td>". $row['user_type'] . "</td>
                    </tr>";
                    }
                ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="offerbox2">
            <div id="offer">
                <h1>Add OFFERS</h1>
                <div class="addoffer">
                    <form action="" method="post" enctype="multipart/form-data">
                        <h2>Add Offers</h2>
                        <input type="hidden" name="user_type" value="admin">
                        <input type="text" name="desc" class="box1" placeholder="Enter the Description">
                        <input type="text" name="discount" class="box1" placeholder="Enter the Discount ">
                        <input type="text" name="code" class="box1" maxlength='8' placeholder="Enter the Code" onkeyup="this.value = this.value.toUpperCase();">
                        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box1">
                        <input type="submit" value="Add offer" name="add_product" class="btn">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="edit-product-form">

        <?php
            if(isset($_GET['update'])){
                $update_id = $_GET['update'];
                $update_query = mysqli_query($conn, "SELECT * FROM `offers` WHERE `id` = '$update_id'") or die('query failed');
            if(mysqli_num_rows($update_query) > 0){
                while($fetch_update = mysqli_fetch_assoc($update_query)){
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
            <input type="hidden" name="update_user_type" value="admin">
            <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
            <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
            <input type="text" name="update_desc" value="<?php echo $fetch_update['desc']; ?>" class="box2" required
                placeholder="Enter description">
            <input type="text" name="update_discount" value="<?php echo $fetch_update['discount']; ?>" class="box2" required
                placeholder="Enter discount">
            <input type="text" name="update_code" value="<?php echo $fetch_update['code']; ?>" class="box2" required
                placeholder="Enter Code" onkeyup="this.value = this.value.toUpperCase();">
            <input type="file" class="box2" name="update_image" accept="image/jpg, image/jpeg, image/png">
            <div class="button">
                <input type="submit" value="update" name="update_product" class="option-btn">
                <input type="reset" value="cancel"
                    onclick="document.querySelector('.edit-product-form').style.display = 'none';" class="delete-btn">
            </div>
        </form>
        <?php
      }
    }
   }
   else{
    echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
 }
?>

    </section>
    <section class="show-products">

        <h1 class="title">Edit Offers</h1>
        <div class="box-container1">
            <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `offers` WHERE `user_type` = 'admin'") or die('query failed');
                if(mysqli_num_rows($select_products) > 0){
                while($fetch_products = mysqli_fetch_assoc($select_products)){
            ?>
            <div class="box">
                <div class="banner">
                    <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                </div>
                <div class="price">
                    <p>Offer Description : <?php echo $fetch_products['desc']; ?></p>
                </div>
                <div class="price">
                    <p>Offer Price : <?php echo $fetch_products['discount']; ?></p>
                </div>
                <div class="price">
                    <p>Offer Code : <?php echo $fetch_products['code']; ?></p>
                </div>
                <div class="button">
                    <a href="admin_offer.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
                    <a href="admin_offer.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn"
                        onclick="return confirm('Delete this offers?');">delete</a>
                </div>
            </div>
            <?php
            }
            }
            ?>
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
    document.querySelector('#close-update').onclick = () => {

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