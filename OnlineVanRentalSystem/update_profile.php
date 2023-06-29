<?php 
session_start();
?>
<?php
if(!(isset($_SESSION['username']))){
    echo "Please Log in Your Account First, Redirecting...";
    header("Refresh: 3 ; url = login.php");
}else{
require "connection.php";
if (isset($_GET['user_no'])){
    $user_no = $_GET['user_no'];
    $query = mysqli_query($connect, "SELECT * FROM `user_account` WHERE `user_no` = '$user_no'");
    $row = mysqli_fetch_array($query);
    $userNo = $row['user_no'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <script src="bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="css/update.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="sweet alert/sweetalert2.min.css">
    <script src="sweet alert/sweetalert2.js"></script>
    <link rel="stylesheet" href="css/fonts.css">
</head>
<body>
    <?php 
        if(isset($_POST['submit'])){
            $fullname=mysqli_real_escape_string($connect, $_POST['full-name']);
            $username=mysqli_real_escape_string($connect, $_POST['username']);
            $password=mysqli_real_escape_string($connect, $_POST['password']);
            $gender=mysqli_real_escape_string($connect, $_POST['gender']);
            $birthday=mysqli_real_escape_string($connect, $_POST['birthday']);
            $phoneNumber=mysqli_real_escape_string($connect, $_POST['pnum']);
            $street=mysqli_real_escape_string($connect, $_POST['street']);
            $city=mysqli_real_escape_string($connect, $_POST['city']);
            $region=mysqli_real_escape_string($connect, $_POST['region']);
            $zipcode=mysqli_real_escape_string($connect, $_POST['zipcode']);
            
            $update = "UPDATE `user_account` SET `full_name`='$fullname',`username`='$username',`password`='$password',`gender`='$gender',`birthday`='$birthday',`phone_number`='$phoneNumber',`street`='$street',`city`='$city',`region`='$region',`zip_code`='$zipcode' WHERE `user_no` = '$user_no'";
            
            $dataset=$connect->query($update)or die("Error Query");
            
            if ($dataset){
                header("refresh: 2 ; url = update_profile.php?user_no=".$user_no."");
                echo "<script>Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'The Record has been updated',
                    showConfirmButton: false,
                    timer: 2000
                })</script>";
            }
        }
    ?>
    <div class = "hero">
        <nav>
        <img src="Images/rentavan_logo.png" alt="RentAvan" class="logo" style = "width: 200px">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="transaction.php">Transactions</a></li>
                <li><a href="search.php">Search</a></li>
            </ul>
            <img src="<?php if($row["profile_pic"] === ""){echo "profile_pictures/default_profile_picture.png";}else {echo "profile_pictures/".$row['profile_pic'];} ?>" alt="RentAvan"class = "user-pic"onclick="toggleMenu()" style = "margin-top: 4px">
            <a href="user_profile.php"><?php echo $row['full_name'];?></a>

            <form action="logout.php" method = "post">
                <div class="sub-menu-container" id = "subMenu">
                    <div class="sub-menu">
                        <div class="user-info">
                        <img src="<?php if($row["profile_pic"] === ""){echo "profile_pictures/default_profile_picture.png";}else {echo "profile_pictures/".$row['profile_pic'];} ?>" alt="RentAvan"class = "user-pic">
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
    <form action="" method = "post">
        <div class="container">
            <div class="row gutters">
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="account-settings">
                                <div class="user-profile">
                                    <div class="user-avatar">
                                    <img src="<?php if($row["profile_pic"] === ""){echo "profile_pictures/default_profile_picture.png";}else {echo "profile_pictures/".$row['profile_pic'];} ?>" alt="RentAvan"class = "user-pic"onclick="toggleMenu()">

                                    </div>
                                    <h5 class="user-name"><?php echo $row['full_name']?></h5>
                                    <h6 class="user-email"><?php echo $row['username']?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mb-2 text-primary">Personal Details</h6>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                    <label for="fullName">Full Name</label>
                                    <input type="text" class="form-control"  name = "full-name" value = "<?php echo $row['full_name']?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="eMail">Username</label>
                                    <input type="email" class="form-control" name = "username" value = "<?php echo $row['username']?>">
                                </div>
                            </div>
                            
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" name = "pnum" value = "<?php echo $row['phone_number']?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name = "password" value = "<?php echo $row['password']?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="website">Gender</label>
                                    <select name="gender" class = "form-select" value="<?php echo $row['gender']?>">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Bisexual">Bisexual</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="website">Birthday</label>
                                    <input type="date" class="form-control" name = "birthday" value = "<?php echo $row['birthday']?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-3 mb-2 text-primary">Complete Address</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Street">Street</label>
                                    <input type="name" class="form-control" name = "street" value = "<?php echo $row['street']?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="ciTy">City</label>
                                    <input type="name" class="form-control" name = "city" value = "<?php echo $row['city']?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="sTate">Region</label>
                                    <input type="text" class="form-control" name = "region" value = "<?php echo $row['region']?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="zIp">Zip Code</label>
                                    <input type="text" class="form-control" name = "zipcode" value = "<?php echo $row['zip_code']?>">
                                </div>
                            </div>
                        </div><br>

                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-right">
                                    <a href="home.php">Cancel</a>
                                    <input type="submit" name="submit" class="btn btn-primary" value = "Update">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu(){
            subMenu.classList.toggle("open-menu");
        }
    </script>
    <?php 
    ?>
</body>
</html>
<?php } ?>