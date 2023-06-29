<?php
session_start();
?>
<?php
if(!(isset($_SESSION['username']))){
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
    <title>Payment</title>
    <link rel="stylesheet" href="css/payment.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <script src="bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="sweet alert/sweetalert2.min.css">
    <script src="sweet alert/sweetalert2.js"></script>
</head>
<body>
    <?php

if(isset($_POST['submit'])){
    $payment = 50;
    
    $curr_date = date('Y-m-d H:i:s');
    $ADD = "INSERT INTO revenue VALUES ('', '$payment', '$curr_date')";
    $addedRevenue = $connect->query($ADD);

    }

    if (isset($_POST['submit'])) {
        $_SESSION['card_holder'] = $_POST['holder'];
        $userNo = $_SESSION['Global_userId'];
        $vanNo = $_SESSION['vanno'];
        $from = $_SESSION['from'];
        $to = $_SESSION['to'];
        $curr_date = date('Y-m-d H:i:s');
        $origin = $_SESSION['origin'];
        $destination = $_SESSION['destination'];
        $start = strtotime($from);
$end = strtotime($to);

$days_between = ceil(abs($end - $start) / 86400);

        $_SESSION['total_payment'] = $days_between * $_SESSION['vanprice'];
        $insert = "INSERT INTO booked VALUES ('', '$userNo', '$vanNo', '$from', '$to', '$origin', '$destination', '$curr_date', 'paid', '".$_SESSION['owner_ID']."', '".$_SESSION['total_payment']."')";
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
                timer: 2000
              })
            </script>";
            header("refresh: 3; url = invoice.php");

        }

    }

    if(isset($_POST['submit'])){
        $start = strtotime($from);
        $end = strtotime($to);
        
        $days_between = ceil(abs($end - $start) / 86400);
        
                $_SESSION['total_payment'] = $days_between * $_SESSION['vanprice'];
        $current_date = date('Y-m-d H:i:s');
    $inser_rev = "INSERT INTO shop_revenue VALUES('', '".$_SESSION['owner_ID']."', '".$_SESSION['total_payment']."', '$current_date')";

    $dateset2 = $connect->query($inser_rev);
    
        }

    ?>
<div class="container">
        <div class="row m-0">
            <div class="col-lg-7 pb-5 pe-lg-5">
                <div class="row">
                    <div class="col-12 p-5">
                        <img src="images/19MBSprinter.png"
                            alt="">
                    </div>
                    <div class="row m-0 bg-light">
                        <div class="col-md-4 col-6 ps-30 pe-0 my-4">
                            <p class="text-muted">Van Number:</p>
                            <p class="h5"><?php echo $_SESSION['vanno'] ?></p>
                        </div>
                        <div class="col-md-4 col-6  ps-30 my-4">
                            <p class="text-muted">Van Name:</p>
                            <p class="h5 m-0"><?php echo $_SESSION['vanname'] ?></p>
                        </div>
                        <div class="col-md-4 col-6 ps-30 my-4">
                            <p class="text-muted">Van Model</p>
                            <p class="h5 m-0"><?php echo $_SESSION['vanmodel'] ?></p>
                        </div>
                    </div>
                    <div class="row m-0 bg-light">
                        <p><?php echo $_SESSION['vandesc'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 p-0 ps-lg-4">
                <div class="row m-0">
                    <div class="col-12 px-4">
                        <div class="d-flex align-items-end mt-4 mb-2">
                        </div><br>
                        <div class="d-flex justify-content-between mb-2">
                            <p class="textmuted">Subtotal</p>
                            <p class="fs-14 fw-bold"><span class="fas fa-dollar-sign pe-1"></span><?php echo $_SESSION['vanprice'] ?></p>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <p class="textmuted">Shipping</p>
                            <p class="fs-14 fw-bold">Free</p>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <p class="textmuted">Service Fee</p>
                            <p class="fs-14 fw-bold"><span class="fas fa-dollar-sign px-1"></span>50</p>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <p class="textmuted fw-bold">Rental per day</p>
                            <div class="d-flex align-text-top ">
                                <span class="fas fa-dollar-sign mt-1 pe-1 fs-14 "></span><span class="h4"><?php
                                $service_fee = 50.00;
                                $price = $_SESSION['vanprice'];
                                $total = $price;

                                echo $price;
                                 ?></span>
                            </div>
                        </div>
                    </div>
                    <form method = "post">
                    <div class="col-12 px-0">
                        <div class="row bg-light m-0">
                            <div class="col-12 px-4 my-4">
                                <p class="fw-bold">Payment detail</p>
                            </div>
                            <div class="col-12 px-4">
                                <div class="d-flex  mb-4">
                                    <span class="">
                                        <p class="text-muted">Card number</p>
                                        <input class="form-control" type="text">
                                    </span>
                                    <div class=" w-100 d-flex flex-column align-items-end">
                                        <p class="text-muted">Expires</p>
                                        <input class="form-control2" type="text"placeholder="MM/YYYY">
                                    </div>
                                </div>
                                <div class="d-flex mb-5">
                                    <span class="me-5">
                                        <p class="text-muted">Cardholder name</p>
                                        <input class="form-control" type="text"
                                            placeholder="Name" name = "holder">
                                    </span>
                                    <div class="w-100 d-flex flex-column align-items-end">
                                        <p class="text-muted">CVC</p>
                                        <input class="form-control3" type="password"placeholder="XXX">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-12  mb-4 p-0">
                                <input type="submit" name="submit" id="" value = "Rent Now" class = "btn btn-primary">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php } ?>