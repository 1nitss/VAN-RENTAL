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
    <title>Home | RentAVan</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <script src="bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="css/homeStyle.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
</head>
<body>
    <?php
    ?>
    <!-- header -->
    <div class = "hero">
        <nav>
        <img src="Images/rentavan_logo.png" alt="RentAvan" class="logo" style = "width: 200px">
            <ul>
                <li><a href="" style = "color: rgb(204, 25, 25);">Home</a></li>
                <li><a href="transaction.php">Transactions</a></li>
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
    <!-- Body -->
    <div class="row">

        <?php 
        $showCars = "SELECT * FROM `van_information` WHERE availability = 'available'";
        $dataset = $connect -> query($showCars);

        if($dataset) {
            while ($data = $dataset -> fetch_assoc()){
                echo "
                
                <div class='col-md-3 col-sm-6'>
                <div class='product-grid'>
                    <div class='product-image'>
                    <form method = 'get'>
                        <a href='van_details.php?vanId=" . $data['van_no'] . "' class='image'>
                            <img src='shop_owner/img/".$data['van_image']."'>
                        </a>
                        
                        <ul class='product-links'>
                            <li><a href='favorite.php?vanId=" . $data['van_no'] . "'><i class='fa-solid fa-star' style = 'color: green;'></i></a></li>
                        </ul>
                        <a href='complete_info.php?id=" . $data['van_no'] . "' class='add-to-cart'>Rent Now</a>
                    </div>
    
                    <div class='product-content'>
                        <h5 class='title'><a href='van_details.php'>" . $data['van_name'] . "</a></h5>
                        <div class='Seller'><p>" . $data['van_model'] . "</p></div>
                        <hr>
                        <div class='price'><p><i class='fa-solid fa-peso-sign'></i>" . $data['price'] . "</p></div>
                    </div>
                    </form>
                </div>
            </div>";

            }
        }
        
        ?>
        

        
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