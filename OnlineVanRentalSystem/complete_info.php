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
    $_SESSION['Global_userId'] = $row['user_no'];
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Complete Information</title>
        <link rel="stylesheet" href="css/complte.css">
        <link rel="stylesheet" href="css/nav.css">
        <link rel="stylesheet" href="css/fonts.css">
        <link rel="stylesheet" href="fontawesome/css/all.css">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="sweet alert/sweetalert2.min.css">
    <script src="sweet alert/sweetalert2.js"></script>
    </head>

    <body>
        <?php 
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            $select = mysqli_query($connect, "SELECT van_information.van_no, van_information.van_name, van_information.van_model, van_information.price, van_information.van_image, van_information.description, van_information.owner_id,van_information.plate_no ,shop_owner.full_name FROM van_information JOIN shop_owner ON van_information.owner_id = shop_owner.owner_id AND van_no = '$id'");
            $row1 = mysqli_fetch_array($select);

            $_SESSION['vanno'] = $id;
            $_SESSION['owner_ID'] = $row1['owner_id'];
            $_SESSION['vanname'] = $row1['van_name'];
            $_SESSION['vanmodel'] = $row1['van_model'];
            $_SESSION['vanprice'] = $row1['price'];
            $_SESSION['vanimage'] = $row1['van_image'];
            $_SESSION['vandesc'] = $row1['description'];
            $_SESSION['owner_fullname'] = $row1['full_name'];
            $_SESSION['plate'] = $row1['plate_no'];
            }

        ?>
        <div class="hero">
            <nav>
            <img src="Images/rentavan_logo.png" alt="RentAvan" class="logo" style = "width: 200px">
                <ul>
                    <li><a href="home.php" style="color: rgb(204, 25, 25);">Home</a></li>
                    <li><a href="transaction.php">Transactions</a></li>
                    <li><a href="search.php">Search</a></li>
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
        </div><br><br><br><br><br><br>
        <?php
        
        if(isset($_POST['pay_cash'])){
            $_SESSION['from'] = $_POST['from'];
            $_SESSION['to'] = $_POST['to'];
            $_SESSION['origin'] = $_POST['origin'];
            $_SESSION['destination'] = $_POST['destination'];
            header("location: gcash.php");
            
        $start = strtotime($_SESSION['from']);
        $end = strtotime($_SESSION['to']);
        
        $days_between = ceil(abs($end - $start) / 86400);
        
        $_SESSION['total_payment'] = $days_between * $_SESSION['vanprice'];
        }
        if(isset($_POST['submit'])){
            $_SESSION['from'] = $_POST['from'];
            $_SESSION['to'] = $_POST['to'];
            $_SESSION['origin'] = $_POST['origin'];
            $_SESSION['destination'] = $_POST['destination'];
            header("location: payment.php");
        }

        
        if(isset($_POST['pay_later'])){
            $_SESSION['from'] = $_POST['from'];
            $_SESSION['to'] = $_POST['to'];
                $userNo = $_SESSION['Global_userId'];
                $vanNo = $_SESSION['vanno'];
                $from = $_SESSION['from'];
                $to = $_SESSION['to'];
                $curr_date = date('Y-m-d H:i:s');
                $start = strtotime($from);
                $end = strtotime($to);
                $origin = $_POST['origin'];
            $destination = $_POST['destination'];
                
                $days_between = ceil(abs($end - $start) / 86400);
                
                 $_SESSION['total_payment'] = $days_between * $_SESSION['vanprice'];
                $insert = "INSERT INTO booked VALUES ('', '$userNo', '$vanNo', '$from', '$to', '$origin', '$destination', '$curr_date', 'pending payment', '".$_SESSION['owner_ID']."', '".$_SESSION['total_payment']."')";
                $dataset = $connect->query($insert);
                if($dataset){
                    $select = "UPDATE van_information SET availability = 'Unavailable' WHERE van_no = '".$_SESSION['vanno']."'";
                    $set = $connect->query($select);
                    echo "<script>
                    
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Rent Sucessful, Redirecting...',
                        showConfirmButton: false,
                        timer: 1500
                      })
                    </script>";
                    header("refresh: 3; url = invoice.php");
                }
        }

        if(isset($_POST['pay_later'])){
            $payment = 50;
            
            $curr_date = date('Y-m-d H:i:s');
            $ADD = "INSERT INTO revenue VALUES ('', '$payment', '$curr_date')";
            $addedRevenue = $connect->query($ADD);
        
            }

            if(isset($_POST['pay_later'])){
                
                $start = strtotime($from);
                $end = strtotime($to);
                
                $days_between = ceil(abs($end - $start) / 86400);
                
                 $_SESSION['total_payment'] = $days_between * $_SESSION['vanprice'];
                $current_date = date('Y-m-d H:i:s');
            $inser_rev = "INSERT INTO shop_revenue VALUES('', '".$_SESSION['owner_ID']."', '".$_SESSION['total_payment']."', '$current_date')";

            $dateset2 = $connect->query($inser_rev);
            
                }
            
        
        ?>
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Fill up the form first</h2>

                                <form method="post">
                                    <div class="form-outline mb-4">

                                        <label class="form-label" >When do you want to start to rent the van:</label>
                                        <input type="date" required id="form3Example1cg" class="form-control form-control-lg" name = "from" />
                                    </div>

                                    <div class="form-outline mb-4">

                                        <label class="form-label" >Until when do you want to rent the van:</label>
                                        <input type="date"  required class="form-control form-control-lg"  name = 'to'/>
                                    </div>
                                    <div class="form-outline mb-4">

                                        <label class="form-label" >Origin:</label>
                                        <input type="text"  required class="form-control form-control-lg"  name = 'origin'/>
                                    </div>

                                    <div class="form-outline mb-4">

                                        <label class="form-label" >Destination:</label>
                                        <input type="text"  required class="form-control form-control-lg"  name = 'destination'/>
                                    </div>



                                    <div class="d-flex justify-content-center">
                                    <input type="submit" class="btn btn-success btn-block btn-lg d" name = "pay_cash" value = "Pay with Gcash">
                                    &nbsp&nbsp&nbsp
                                        <input type="submit" class="btn btn-success btn-block btn-lg d" name = "submit" value = "Pay with Bank">
                                        &nbsp&nbsp&nbsp
                                        <input type="submit" class="btn btn-success btn-block btn-lg d" name = "pay_later" value = "Pay Later">
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php } ?>