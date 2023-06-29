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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script src="download.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
</head>
<body>
<div class="container" id = 'invoice'>
        <div class="row m-0">
            <div class="col-lg-7 pb-5 pe-lg-5">
                <div class="row">
                    <div class="col-12 p-5">
                        <img src="images/19MBSprinter.png"
                            alt="">
                    </div>
                    <div class="row m-0 bg-light">
                    <div class="col-md-4 col-6 ps-30 pe-0 my-4">
                            <p class="text-muted">Van Owner:</p>
                            <p class="h5"><?php echo $_SESSION['owner_fullname'] ?></p>
                        </div>
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
                        <div class="col-md-4 col-6 ps-30 my-4">
                            <p class="text-muted">Plate Number</p>
                            <p class="h5 m-0"><?php echo $_SESSION['plate'] ?></p>
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
                            <p class="fs-14 fw-bold"><span class="fa-solid fa-peso-sign px-1"></span><?php echo $_SESSION['vanprice'] ?></p>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <p class="textmuted">Shipping</p>
                            <p class="fs-14 fw-bold">Free</p>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <p class="textmuted">Service Fee</p>
                            <p class="fs-14 fw-bold"><span class="fa-solid fa-peso-sign px-1"></span>50</p>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <p class="textmuted">Rental Per Day</p>
                            <p class="fs-14 fw-bold"><span class="fa-solid fa-peso-sign px-1"></span><?php echo $_SESSION['vanprice'] ?></p>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <p class="textmuted fw-bold">Total Payment</p>
                            <div class="d-flex align-text-top ">
                                <span class="fa-solid fa-peso-sign mt-1 pe-1 fs-14 "></span><span class="h4"><?php
                                                                $service_fee = 50.00;
                                                                $total = $service_fee + $_SESSION['total_payment'];
                                                                echo $total;
                                 ?></span>
                            </div>
                        </div>
                    </div>
                    <form method = "post">
                    <div class="col-12 px-0">
                        <div class="row bg-light m-0">
                            <div class="col-12 px-4 my-4">
                                <p class="fw-bold">User Information</p>
                            </div>
                            <div class="col-12 px-4">
                                <div class="d-flex  mb-4">
                                    <span class="">
                                        <p class="text-muted">Full Name</p>
                                        <p class="h6 m-0"><?php echo $row['full_name'] ?></p>
                                    </span>
                                    <div class=" w-100 d-flex flex-column align-items-end">
                                        <p class="text-muted">Gender</p>
                                        <p class="h6 m-0"><?php echo $row['gender'] ?></p>
                                    </div>
                                </div>
                                <div class="d-flex mb-5">
                                    <span class="me-5">
                                        <p class="text-muted">Phone Number</p>
                                        <p class="h6 m-0"><?php echo $row['phone_number'] ?></p>
                                    </span>
                                    <div class="w-100 d-flex flex-column align-items-end">
                                        <p class="text-muted">Address</p>
                                        <p class="h6 m-0"><?php echo $row['street'] ?>, <?php echo $row['city']?>, <?php echo $row['region']?></p>
                                    </div>
                                </div>
                                <div class="d-flex mb-5">
                                    <span class="me-5">
                                        <p class="text-muted">Rented From:</p>
                                        <p class="h6 m-0"><?php echo $_SESSION['from'] ?></p>
                                    </span>
                                    <div class="w-100 d-flex flex-column align-items-end">
                                        <p class="text-muted">Rented Until:</p>
                                        <p class="h6 m-0"><?php echo $_SESSION['to'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <button class = "btn btn-primary" id="download">Download Now</button>
</body>
</html>
<?php } ?>