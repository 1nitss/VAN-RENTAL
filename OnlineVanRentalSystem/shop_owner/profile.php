<?php
session_start();
?>
<?php
if (!(isset($_SESSION['admin_username']))) {
    echo "Please Log in Your Account First, Redirecting...";
    header("Refresh: 3 ; url = login.php");
} else {
    require "../connection.php";
    $query = mysqli_query($connect, "SELECT * FROM `shop_owner` WHERE owner_id = '" . $_SESSION['owner_no'] . "'");
    $row = mysqli_fetch_array($query);
    $_SESSION['Global_owner_no'] = $row['owner_id'];
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <title>Dashboard</title>
        <link rel="stylesheet" href="../css/dashboard.css">
        <link rel="stylesheet" href="../css/fonts.css">
        <link rel="stylesheet" href="../fontawesome/css/all.css">
        <link rel="stylesheet"
            href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://kit.fontawesome.com/5a10e0b94b.js" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <link rel="stylesheet" href="../css/admin_profile.css">
    </head>

    <body>
        <?php

        if (isset($_GET['id'])) {
            $ownID = $_GET['id'];
            $_SESSION['selectedID'] = $_GET['id'];

            $showowner = mysqli_query($connect, "SELECT * FROM shop_owner WHERE owner_id = '$ownID'");

            $owner = mysqli_fetch_array($showowner);


        }

        ?>
        <?php
        if (isset($_POST['update_profile'])) {
            $fname = $_POST['fname'];
            $user_name = $_POST['username'];
            $password = $_POST['password'];
            $gen = $_POST['gender'];
            $birth = $_POST['bday'];
            $street = $_POST['street'];
            $city = $_POST['city'];
            $region = $_POST['region'];
            $zip = $_POST['zipcode'];
            $pnum = $_POST['pnum'];

            $update = "UPDATE `shop_owner` SET `full_name`='$fname',`username`='$user_name',`password`='$password',`gender`='$gen',`birthday`='$birth',`phone_number`='$pnum',`street`='$street',`city`='$city',`region`='$region',`zipcode`='$zip' WHERE owner_id = '" . $_SESSION['selectedID'] . "'";
            $dataset = $connect->query($update);
            if ($dataset) {
                echo "<script>Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Successfully updated Profile Picture',
                            showConfirmButton: false,
                            timer: 1500
                          })</script>";
                header("refresh: 2 ;url=profile.php?id=" . $_SESSION['selectedID'] . "");
            }
        }

        if (isset($_POST["submit"])) {
            if ($_FILES["image"]["error"] == 4) {
                echo
                    "<script> alert('Image Does Not Exist'); </script>"
                ;
            } else {
                $fileName = $_FILES["image"]["name"];
                $fileSize = $_FILES["image"]["size"];
                $tmpName = $_FILES["image"]["tmp_name"];

                $validImageExtension = ['jpg', 'jpeg', 'png'];
                $imageExtension = explode('.', $fileName);
                $imageExtension = strtolower(end($imageExtension));
                if (!in_array($imageExtension, $validImageExtension)) {
                    echo
                        "
                            <script>
                              alert('Invalid Image Extension');
                            </script>
                            ";
                } else if ($fileSize > 1000000) {
                    echo
                        "
                            <script>
                              alert('Image Size Is Too Large');
                            </script>
                            ";
                } else {
                    $newImageName = uniqid();
                    $newImageName .= '.' . $imageExtension;

                    move_uploaded_file($tmpName, 'img/' . $newImageName);
                    $query = "UPDATE `shop_owner` SET `profile_picture`= '$newImageName' WHERE `owner_id` = '" . $_SESSION['selectedID'] . "'";
                    mysqli_query($connect, $query);
                    echo
                        "
                            <script>
                              alert('Successfully Added');
                              document.location.href = 'profile.php?id=".$_SESSION['selectedID']."';
                            </script>
                            ";
                }
            }
        }
        ?>
        <input type="checkbox" id="menu-toggle">
        <div class="sidebar">
            <div class="side-header">
                <h3>R<span>entAVan</span></h3>
            </div>

            <div class="side-content">
                <div class="profile">
                    <div class="profile-img bg-img"
                        style="background-image: url(img/<?php echo $row['profile_picture'] ?>)"></div>
                    <h4>
                        <?php echo $row['full_name'] ?>
                    </h4>
                </div>

                <div class="side-menu">
                    <ul>
                        <li>
                            <a href="dashboard.php">
                                <span class="las la-home" style="color: cyan;"></span></span>
                                <small style="font-size: 18px;">Dashboard</small>
                            </a>
                        </li>
                        <li>
                            <a href="profile.php?id=<?php echo $_SESSION['Global_owner_no'] ?>" class="active">
                                <span class="las la-user-alt" style="color: cyan;"></span>
                                <small style="font-size: 18px;">Profile</small>
                            </a>
                        </li>
                        <li>
                            <a href="add_count.php">
                                <span class="las la-envelope" style="color: cyan;"></span>
                                <small style="font-size: 18px;">Add Van</small>
                            </a>
                        </li>
                        <li>
                            <a href="transaction.php">
                                <span class="las la-shopping-cart" style="color: cyan;"></span>
                                <small style="font-size: 18px;">Transactions</small>
                            </a>
                        </li>
                        
                        <li>
                            <a href="analytics.php">
                                <span class="las la-chart-bar" style="color: cyan;"></span></span>
                                <small style="font-size: 18px;">Graphical Analytics</small>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <div class="main-content">

            <header>
                <div class="header-content">
                    <label for="menu-toggle">
                        <i class="fa-solid fa-bars" style="color: red;"></i>
                    </label>

                    <div class="header-menu">
                        <div class="user">
                            <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>

                            <i class="fa-solid fa-power-off" style="color: red;"></i>
                            <a href="logout.php?id=1" style="color: white;"><span>Logout</span></a>
                        </div>
                    </div>
                </div>
            </header>


            <main>

                <div class="page-header">
                    <h1>Welcome</h1>
                    <small>
                        <?php echo $row['full_name'] ?>
                    </small>
                </div>
                <div class="records table-responsive">
                    <div class="update-profile">

                        <form method="post" enctype="multipart/form-data">
                            <img src="img/<?php echo $row['profile_picture'] ?>">
                            <div class="flex">
                                <div class="inputBox">
                                    <span>Full Name: </span>
                                    <input type="text" name="fname" value="<?php echo $owner['full_name'] ?>" class="box">
                                    <span>username: </span>
                                    <input type="text" name="username" value="<?php echo $owner['username'] ?>"
                                        class="box">
                                    <span>Password: </span>
                                    <input type="password" name="password" value="<?php echo $owner['password'] ?>"
                                        class="box">
                                    <span>Gender: </span>
                                    <input type="text" name="gender" value="<?php echo $owner['gender'] ?>" class="box">
                                    <span>Birthday: </span>
                                    <input type="date" name="bday" value="<?php echo $owner['birthday'] ?>" class="box">
                                    <span>Phone Number: </span>
                                    <input type="text" name="pnum" value="<?php echo $owner['phone_number'] ?>"
                                        class="box">


                                </div>
                                <div class="inputBox">
                                    <span>Street</span>
                                    <input type="text" name="street" value="<?php echo $owner['street'] ?>" class="box">
                                    <span>City:</span>
                                    <input type="text" name="city" class="box" value="<?php echo $owner['city'] ?>">
                                    <span>Region:</span>
                                    <input type="region" name="region" class="box" value="<?php echo $owner['region'] ?>">
                                    <span>zip code:</span>
                                    <input type="region" name="zipcode" value="<?php echo $owner['zipcode'] ?>" class="box">
                                    <span>update your pic:</span>
                                    <input type="file" name="image" class="box" accept=".jpg, .jpeg, .png">
                                    <button type="submit" name="submit" class="btn" style="margin-top: 52px">Upload</button>
                                </div>
                            </div>
                            <input type="submit" value="update profile" name="update_profile" class="btn">
                            <a href="dashboard.php" class="delete-btn">go back</a>
                        </form>
                    </div>

                </div>

            </main>

        </div>
        <script>
            function myFunction() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>
    </body>

    </html>
<?php } ?>