<?php
session_start();
?>
<?php
if(!(isset($_SESSION['username']))){
    echo "Please Log in Your Account First, Redirecting...";
    header("Refresh: 3 ; url = login.php");
}else{
require "connection.php";
$query = mysqli_query($connect, "SELECT * FROM `user_account` WHERE '".$_SESSION['username']."' = username and '".$_SESSION['password']."' = password");
$row = mysqli_fetch_array($query);
$userNo = $row['user_no'];
    $_SESSION['Global_userId'] = $row['user_no'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
    <link rel="stylesheet" href="css/transaction.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <script src="bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
</head>

<body>
<div class = "hero">
        <nav>
        <img src="Images/rentavan_logo.png" alt="RentAvan" class="logo" style = "width: 200px">
            <ul>
                <li><a href="home.php" >Home</a></li>
                <li><a href="transaction.php" style = "color: rgb(204, 25, 25);">Transactions</a></li>
                <li><a href="search.php">Search</a></li>
            </ul>
            <img src="<?php if($row["profile_pic"] === ""){echo "profile_pictures/default_profile_picture.png";}else {echo "profile_pictures/".$row['profile_pic'];} ?>" alt="RentAvan"class = "user-pic"onclick="toggleMenu()">
            <a href="user_profile.php"><?php echo $row["full_name"];?></a>
            <form action="logout.php" method = "post">
                <div class="sub-menu-container" id = "subMenu">
                    <div class="sub-menu">
                        <div class="user-info">
                        <img src="<?php if($row["profile_pic"] === ""){echo "profile_pictures/default_profile_picture.png";}else {echo "profile_pictures/".$row['profile_pic'];} ?>" alt="RentAvan"class = "user-pic"onclick="toggleMenu()">
                            <h3><?php echo  $row["full_name"];?></h3>
                        </div>
                        <hr>
                        <a href='update_profile.php?user_no=<?php echo $userNo ?>' class = "sub-menu-link">
                            <img src="icons/profile-user.png" alt="">
                            <p>edit profile</p>
                            <span>></span>
                        </a>

                        <a href="favorite.php" class = "sub-menu-link">
                            <img src="icons/favorite (1).png" alt="">
                            <p>Favorites</p>
                            <span>></span>
                        </a>

                        <a href="" class = "sub-menu-link">
                            <img src="icons/log-out.png" alt="">
                            <input type="submit" class="btn btn-danger" value = "Log Out" name = "logout">
                            <span style = "margin-left: 43%">></span>
                        </a>
                    </div>
                </div>
            </form>
        </nav>
    </div><br><br><br><br><br>
    <div class="container py-5">
<h3 style="color: grey;">Transaction History</h3>
        <hr>
        <div class="row justify-content-center">
            
                <?php

                require "connection.php";
                $show = "SELECT van_information.van_image, van_information.van_name, van_information.van_model, van_information.price,booked.from_date,booked.to_date,booked.transaction_date FROM van_information JOIN booked ON van_information.van_no = booked.van_no AND booked.user_no = '" . $_SESSION['Global_userId'] . "'";

                $dataset = $connect->query($show);
                if($dataset){

                    while($data = $dataset -> fetch_assoc()){
                        echo "
                        <div class='col-md-8 col-lg-6 col-xl-4 mb-3'>
                        <div class='card text-black'>
                        <img src='images/19MBSprinter.png'
                            class='card-img-top'/>
                        <div class='card-body'>
                            <div class='text-center'>
                                <h5 class='card-title'>".$data['van_name']."</h5>
                                <p class='text-muted mb-4'>".$data['van_model']."</p>
                            </div>
                            <div>
                                <div class='d-flex justify-content-between'>
                                    <span>Cost Per Day</span><span style = 'color: red'>".$data['price']."</span>
                                </div>
                                <hr>
                                <div class='d-flex justify-content-between'>
                                    <span>Rented From</span><span style = 'color: red'>".$data['from_date']."</span>
                                </div>
                                <div class='d-flex justify-content-between'>
                                    <span>Rented Until</span><span style = 'color: red'>".$data['to_date']."</span>
                                </div>
                                <hr>
                                <div class='d-flex justify-content-between'>
                                    <span>Date of Reservation:</span><span style = 'color: red'>".$data['transaction_date']."</span>
                                </div>
                            </div>
                        </div>
                    </div></div>";
                    }
                }
                ?>
        </div>
    </div>
    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu(){
            subMenu.classList.toggle("open-menu");
        }
    </script>
</body>

</html>
<?php }?>