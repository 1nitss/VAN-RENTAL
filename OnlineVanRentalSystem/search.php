<?php
session_start();
?>

<?php
if (!(isset($_SESSION['username']))) {
    echo "Please Log in Your Account First, Redirecting...";
    header("Refresh: 3 ; url = login.php");
} else {
    require "connection.php";

    $query = mysqli_query($connect, "SELECT * FROM `user_account` WHERE '" . $_SESSION['username'] . "' = username and '" . $_SESSION['password'] . "' = password");
    $row = mysqli_fetch_array($query);
    $userNo = $row['user_no'];
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Search VAn</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" href="css/searchStyles.css">
        <link rel="stylesheet" href="css/nav.css">
        <link rel="stylesheet" href="css/fonts.css">
        <link rel="stylesheet" href="fontawesome/css/all.css">
        <link rel="stylesheet" href="css/homeStyle.css">
    </head>

    <body>
        <div class="hero">
            <nav>
            <img src="Images/rentavan_logo.png" alt="RentAvan" class="logo" style = "width: 200px">
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="transaction.php">Transactions</a></li>
                    <li><a href="search.php" style="color: rgb(204, 25, 25);">Search</a></li>
                </ul>
                <img src="<?php if ($row["profile_pic"] === "") {
                    echo "profile_pictures/default_profile_picture.png";
                } else {
                    echo "profile_pictures/" . $row['profile_pic'];
                } ?>" alt="RentAvan" class="user-pic" onclick="toggleMenu()">
                <a href="user_profile.php">
                    <?php echo $row["full_name"]; ?>
                </a>
                <form action="logout.php" method="post">
                    <div class="sub-menu-container" id="subMenu">
                        <div class="sub-menu">
                            <div class="user-info">
                                <img src="<?php if ($row["profile_pic"] === "") {
                                    echo "profile_pictures/default_profile_picture.png";
                                } else {
                                    echo "profile_pictures/" . $row['profile_pic'];
                                } ?>" alt="RentAvan" class="user-pic" onclick="toggleMenu()">
                                <h3>
                                    <?php echo $row["full_name"]; ?>
                                </h3>
                            </div>
                            <hr>
                            <a href='update_profile.php?user_no=<?php echo $userNo ?>' class="sub-menu-link">
                                <img src="icons/profile-user.png" alt="">
                                <p>edit profile</p>
                                <span>></span>
                            </a>

                            <a href="favorite.php" class="sub-menu-link">
                                <img src="icons/favorite (1).png" alt="">
                                <p>Favorites</p>
                                <span>></span>
                            </a>

                            <a href="" class="sub-menu-link">
                                <img src="icons/log-out.png" alt="">
                                <input type="submit" class="btn btn-danger" value="Log Out" name="logout">
                                <span style="margin-left: 43%">></span>
                            </a>
                        </div>
                    </div>
                </form>
            </nav>
        </div><br><br>
        <form action="" method="post">
            <div class="container">
                <div class="row height d-flex justify-content-center align-items-center">
                    <div class="col-md-8">
                        <div class="search">
                            <i class="fa fa-search"></i>
                            <input type="text" class="form-control" placeholder="Search for Van" name="search"><br>
                            
                            <input placeholder = "ranging from" name = 'from'>
                            <input placeholder="ranging to" name = 'to'>
                            <input type="text" placeholder="Van Model" name = 'model'>
                            <button class="btn btn-primary" name="search1">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <?php

            if (isset($_POST['search1'])) {
                
                $search = $_POST['search'];
                $model = $_POST['model'];
                $from = $_POST['from'];
                $to = $_POST['to'];
                $showCars = mysqli_query($connect, "SELECT van_no, van_name,van_model, price FROM `van_information` WHERE (van_name LIKE '%$search%' OR van_model LIKE '%$model%') AND price BETWEEN '$from' AND '$to'");
                if(mysqli_num_rows($showCars) > 0){
                echo "<h5 style = 'color: white'>Search Results:</h5><br>";
                }else{
                    echo '';
                }
                if(mysqli_num_rows($showCars) == 0){
                    echo "<center><h4 style = 'color: grey'>No Result Found</h4></center>";
                } else {
                    while ($data = mysqli_fetch_array($showCars)) {
                        ?>
                    <div class='col-md-3 col-sm-6'>
                        <div class='product-grid'>
                            <div class='product-image'>
                                <a href='van_details.php?vanId="<?php echo $data['van_no'] ?>"' class='image'>
                                    <img src='images/19MBSprinter.png'>
                                </a>

                                <ul class='product-links'>
                                    <li><a href='favorite.php?vanId=<?php echo $data['van_no'] ?>'><i class='fa-solid fa-star' style='color: green;'></i></a></li>
                                </ul>
                                <a href='complete_info.php?id=<?php echo $data['van_no'] ?>' class='add-to-cart'>Rent Now</a>
                            </div>

                            <div class='product-content'>
                                <h5 class='title'><a href='van_details.php'>
                                        <?php echo $data['van_name'] ?>
                                    </a></h5>
                                <div class='Seller'>
                                    <p>
                                        <?php echo $data['van_model'] ?>
                                    </p>
                                </div>
                                <hr>
                                <div class='price'>
                                    <p>$
                                        <?php echo $data['price'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                }
            }

            ?>
        </div>
        <script>
            let subMenu = document.getElementById("subMenu");

            function toggleMenu() {
                subMenu.classList.toggle("open-menu");
            }
        </script>


    </body>

    </html>
<?php } ?>