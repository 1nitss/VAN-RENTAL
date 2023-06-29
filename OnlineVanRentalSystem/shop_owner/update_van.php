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
        <title>Modern Admin Dashboard</title>
        <link rel="stylesheet" href="../css/dashboard.css">
        <link rel="stylesheet" href="../css/fonts.css">
        <link rel="stylesheet" href="../fontawesome/css/all.css">
        <link rel="stylesheet" href="../css/update_van.css">
        <link rel="stylesheet"
            href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
            
    <link rel="stylesheet" href="../sweet alert/sweetalert2.min.css">
    <script src="../sweet alert/sweetalert2.js"></script>
    </head>

    <body>
        <?php

        if (isset($_GET['id'])) {
            $van_no = $_GET['id'];
            $_SESSION['forpic'] = $_GET['id'];
            $select = mysqli_query($connect, "SELECT * FROM van_information WHERE van_no = '$van_no'");
            $row1 = mysqli_fetch_array($select);
        }

        if(isset($_POST["update"])){
            if($_FILES["image"]["error"] == 4){
              echo
              "<script> alert('Image Does Not Exist'); </script>"
              ;
            }
            else{
              $fileName = $_FILES["image"]["name"];
              $fileSize = $_FILES["image"]["size"];
              $tmpName = $_FILES["image"]["tmp_name"];
          
              $validImageExtension = ['jpg', 'jpeg', 'png'];
              $imageExtension = explode('.', $fileName);
              $imageExtension = strtolower(end($imageExtension));
              if ( !in_array($imageExtension, $validImageExtension) ){
                echo
                "
                <script>
                  alert('Invalid Image Extension');
                </script>
                ";
              }
              else if($fileSize > 10000000){
                echo
                "
                <script>
                  alert('Image Size Is Too Large');
                </script>
                ";
              }
              else{
                $newImageName = uniqid();
                $newImageName .= '.' . $imageExtension;
          
                move_uploaded_file($tmpName, 'img/' . $newImageName);
                $query = "UPDATE `van_information` SET `van_image`= '$newImageName' WHERE `van_no` = '".$_SESSION['forpic']."'";
                mysqli_query($connect, $query);
                echo "<script>Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Successfully updated Van information',
                    showConfirmButton: false,
                    timer: 1500
                  })</script>";
                header("refresh: 3 ;url=dashboard.php");
              }
            }
          }
          

        if(isset($_POST['submit'])){
            $vanName = $_POST['van_name'];
            $vanModel = $_POST['van_model'];
            $vanPrice = $_POST['price'];
            $availability = $_POST['availability'];
            $van_desc = $_POST['van_desc'];
            $plate_num = $_POST['plate_no'];

            $update = "UPDATE `van_information` SET `van_name`='$vanName',`van_model`='$vanModel',`plate_no` = '$plate_num',`description`='$van_desc',`price`='$vanPrice',`availability`='$availability' WHERE van_no = '".$_SESSION['forpic']."'";
            $updateVan = $connect->query($update);
            if($updateVan){
                echo "<script>Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Successfully updated Van information',
                    showConfirmButton: false,
                    timer: 1500
                  })</script>";
                header("refresh: 3 ;url=dashboard.php");
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
                            <a href="dashboard.php" class="active">
                                <span class="las la-home" style="color: cyan;"></span></span>
                                <small style="font-size: 18px;">Dashboard</small>

                            </a>
                        </li>
                        <li>
                            <a href="profile.php?id=<?php echo $_SESSION['Global_owner_no'] ?>">
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

                <div class="page-content">


                    <div class="page-wrapper p-t-100 p-b-50">
                        <div class="wrapper wrapper--w900">
                            <div class="card card-6">
                                <div class="card-heading">
                                    <h2 class="title">Update Van Information</h2>
                                </div>
                                <div class="card-body">
                                    <form method="POST"  enctype = "multipart/form-data">
                                        <div class="form-row">
                                            <div class="name">Van Name</div>
                                            <div class="value">
                                                <input class="input--style-6" type="text" name="van_name"
                                                    value="<?php echo $row1['van_name'] ?>">

                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="name">Model</div>
                                            <div class="value">
                                                <div class="input-group">
                                                    <input class="input--style-6" type="text" name="van_model"
                                                        value="<?php echo $row1['van_model'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="name">Plate Number</div>
                                            <div class="value">
                                                <div class="input-group">
                                                    <input class="input--style-6" type="text" name="plate_no"
                                                        value="<?php echo $row1['plate_no'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="name">Price</div>
                                            <div class="value">
                                                <div class="input-group">
                                                    <input class="input--style-6" type="number" name="price"
                                                        value="<?php echo $row1['price'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="name">Availability</div>
                                            <div class="value">
                                                <div class="input-group">
                                                    <input class="input--style-6" type="text" name="availability"
                                                        value="<?php echo $row1['availability'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="name">Description</div>
                                            <div class="value">
                                                <div class="input-group">
                                                    <textarea class="textarea--style-6"
                                                        name="van_desc"><?php echo $row1['description'] ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="name">Upload Van Image</div>
                                            <div class="value">
                                                <div class="input-group js-input-file">
                                                    <input type="file" name="image" id="file">
                                                </div>
                                                <div class="label--desc">Max file size 5 MB</div>
                                                
                                            </div>
                                            <button type = 'submit' class = "btn btn--radius-2 btn--blue-2" name = 'update'>UPDATE IMAGE</button>
                                        </div>
                                        
                                <div class="card-footer">
                                    <button class="btn btn--radius-2 btn--blue-2" type="submit" name = 'submit'>UPDATE</button>
                                </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </main>

        </div>
    </body>

    </html>
<?php } ?>