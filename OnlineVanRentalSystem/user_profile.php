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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Information</title>
    <link rel="stylesheet" href="css/user_profile.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <script src="bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="sweet alert/sweetalert2.min.css">
    <script src="sweet alert/sweetalert2.js"></script>
</head>
<body>
    
<?php
        require "connection.php";
        if (isset($_POST["upload"])) {
            if($_FILES["image"]["error"] === 4){
                echo "<script>alert('File Does Not Exist')</script>";
            }else{
                $fileName = $_FILES["image"]["name"];
                $fileSize = $_FILES["image"]["size"];
                $tmpName = $_FILES["image"]["tmp_name"];

                $validImageExtensions = ["jpg", "jpeg", "png"];
                $imageExtension = explode('.', $fileName);
                $imageExtension = strtolower(end($imageExtension));

                if(!in_array($imageExtension, $validImageExtensions)){
                    echo "<script>alert('Invalid File Extension')</script>";
                }elseif($fileSize > 1000000){
                    echo "<script>alert('File is too large')</script>";
                }else {
                    $newImageName = uniqid();
                    $newImageName .= '.' . $imageExtension;

                    move_uploaded_file($tmpName, 'profile_pictures/' . $newImageName);
                    $uploadImage = "UPDATE `user_account` SET `profile_pic`= '$newImageName' WHERE `user_no` = '$userNo'";
                    mysqli_query($connect, $uploadImage);
                    echo "<script>Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Successfully updated profile picture',
                        showConfirmButton: false,
                        timer: 1500
                      })</script>";
                    header("refresh: 2 ;url=user_profile.php");
                }

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
            <img src="<?php if($row["profile_pic"] === ""){echo "profile_pictures/default_profile_picture.png";}else {echo "profile_pictures/".$row['profile_pic'];} ?>" alt="RentAvan"class = "user-pic"onclick="toggleMenu()">
            <a href="user_profile.php" style = "color: rgb(204, 25, 25); font-weight: 600"><?php echo $row["full_name"];?></a>
            <form action="logout.php" method = "post">
                <div class="sub-menu-container" id = "subMenu">
                    <div class="sub-menu">z
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
    </div><br><br><br>
    <form action="" method = "post" enctype = "multipart/form-data">
        <div class="container-xl px-4 mt-4">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card mb-4 mb-xl-0">
                        <div class="card-header">Profile Picture</div>
                        <div class="card-body text-center">
                            <img src="<?php if($row["profile_pic"] === ""){echo "profile_pictures/default_profile_picture.png";}else {echo "profile_pictures/".$row['profile_pic'];} ?>" alt="RentAvan"class = "user-pic" style = "min-width: 50%; "><br>
                            <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                            <input type = "file" class="form-control" name = "image" accept = ".jpg, .jpeg, .png"><br>
                            <input type = "submit" class="btn btn-primary" value = "Upload" name = "upload" >
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card mb-4">
                        <div class="card-header"><h3>Account Details</h3></div>
                        <div class="card-body">
                                <div class="row gx-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputFirstName">Full Name</label>
                                        <input class="form-control" type="text" value="<?php echo $row['full_name']?>" disabled readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputLastName">Username</label>
                                        <input class="form-control" value="<?php echo $row['username']?>" disabled readonly>
                                    </div>
                                </div>
                                <div class="row gx-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputOrgName">Phone Number</label>
                                        <input class="form-control"type="text"value="<?php echo $row['phone_number']?>" disabled readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputLocation">Gender</label>
                                        <input class="form-control" type="text" value="<?php echo $row['gender']?>" disabled readonly>
                                    </div>
                                </div>

                                <div class="row gx-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputOrgName">Birthday</label>
                                        <input class="form-control"type="text"value="<?php echo $row['birthday']?>" disabled readonly>
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <h5>Complete Address</h5>
                                </div>
                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPhone">Street</label>
                                        <input class="form-control" type="text" value="<?php echo $row['street']?>" disabled readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputBirthday">City</label>
                                        <input class="form-control" type="text" value="<?php echo $row['city']?>" disabled readonly>
                                    </div>
                                </div>

                                <div class="row gx-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPhone">Region</label>
                                        <input class="form-control" type="text" value="<?php echo $row['region']?>" disabled readonly>
                                    </div>
                                    <!-- Form Group (birthday)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputBirthday">Zip Code</label>
                                        <input class="form-control" type="text" value="<?php echo $row['zip_code']?>" disabled readonly>
                                    </div>
                                </div>
                                
                                <a href="update_profile.php?user_no=<?php echo $userNo ?>"><input class="btn btn-primary" value = "Update Your Profile" name = "update"></a>
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

?>
</body>
</html>
<?php }?>