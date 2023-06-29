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
<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
    
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
    <form action="" method="post">
    <div class="v1_2">
        <div class="v1_3"></div>
        <div class="v1_4"></div><span class="v3_10">Please review to ensure the details are correct before you
            proceed</span>
        <div class="v4_15"><span class="v3_9"style="margin-left: 170px"> <?php echo $_SESSION['total_payment'] ?></span><span class="v3_8" style="margin-left: 100px">PHP</span><span class="v3_7">Total</span>
        </div>
        <div class="v4_14"><span class="v3_6" style="margin-left: 40px">No available voucher</span><span class="v3_5">Discount</span></div><span
            class="v1_15">YOU ARE ABOUT TO PAY</span>
        <div class="v4_13"><span class="v2_3" style="margin-left: 170px" >PHP <?php echo $_SESSION['total_payment'] ?></span><span
                class="v2_2">Amount</span></div><span class="v1_6">RentAVan</span>
        <div class="v1_5"></div><span class="v1_7">PAY WITH</span>
        <div class="v4_16"><span class="v1_10" style="margin-left: 50px">Available Balance</span><span class="v1_9" style="margin-left: 150px">PHP</span><span
                class="v1_8">GCash</span>
        </div>
        <div class="v3_11"></div><span class="v3_12"><center><Button style="border: none; background-color: #007cff; color: white; font-size: 20px; font-weight: bold;" name = "submit">Pay Now</Button></center></span>
        
    </div>
    </form>
</body>

</html> <br /><br 
/>
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-size: 14px;
    }

    .v1_2 {
        width: 100%;
        height: 1024px;
        background: rgba(255, 255, 255, 1);
        opacity: 1;
        position: relative;
        top: 0px;
        left: 0px;
        overflow: hidden;
    }

    .v1_3 {
        width: 100%;
        height: 301px;
        background: rgba(0, 124, 255, 1);
        opacity: 1;
        position: relative;
        top: 0px;
        left: 0px;
        overflow: hidden;
    }

    .v1_4 {
        width: 432px;
        height: 597px;
        background: rgba(255, 255, 255, 1);
        opacity: 1;
        position: absolute;
        top: 150px;
        left: 504px;
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        overflow: hidden;
    }

    .v3_10 {
        width: 396px;
        color: rgba(143, 136, 136, 1);
        position: absolute;
        top: 603px;
        left: 524px;
        font-family: Inter;
        font-weight: Bold;
        font-size: 14px;
        opacity: 1;
        text-align: center;
    }

    .v4_15 {
        width: 354px;
        height: 32px;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        opacity: 1;
        position: absolute;
        top: 490px;
        left: 531px;
        overflow: hidden;
    }

    .v3_9 {
        width: 77px;
        color: rgba(25, 25, 25, 1);
        position: absolute;
        top: 3px;
        left: 101px;
        font-family: Inter;
        font-weight: Bold;
        font-size: 24px;
        opacity: 1;
        text-align: left;
    }

    .v3_8 {
        width: 33px;
        color: rgba(57, 53, 53, 1);
        position: absolute;
        top: 3px;
        left: 134px;
        font-family: Inter;
        font-weight: Bold;
        font-size: 16px;
        opacity: 1;
        text-align: left;
    }

    .v3_7 {
        width: 35px;
        color: rgba(90, 86, 86, 1);
        position: relative;
        top: 0px;
        left: 0px;
        font-family: Inter;
        font-weight: Bold;
        font-size: 14px;
        opacity: 1;
        text-align: left;
    }

    .v4_14 {
        width: 354px;
        height: 17px;
        background: url("../images/v4_14.png");
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        opacity: 1;
        position: absolute;
        top: 425px;
        left: 536px;
        overflow: hidden;
    }

    .v3_6 {
        width: 143px;
        color: rgba(143, 136, 136, 1);
        position: absolute;
        top: 0px;
        left: 157px;
        font-family: Inter;
        font-weight: Bold;
        font-size: 14px;
        opacity: 1;
        text-align: left;
    }

    .v3_5 {
        width: 62px;
        color: rgba(143, 136, 136, 1);
        position: relative;
        top: 0px;
        left: 0px;
        font-family: Inter;
        font-weight: Bold;
        font-size: 14px;
        opacity: 1;
        text-align: left;
    }

    .v1_15 {
        width: 170px;
        color: rgba(87, 80, 80, 1);
        position: absolute;
        top: 326px;
        left: 524px;
        font-family: Inter;
        font-weight: Bold;
        font-size: 14px;
        opacity: 1;
        text-align: left;
    }

    .v4_13 {
        width: 349px;
        height: 31px;
        background: url("../images/v4_13.png");
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        opacity: 1;
        position: absolute;
        top: 370px;
        left: 536px;
        overflow: hidden;
    }

    .v2_4 {
        width: 121px;
        color: rgba(143, 136, 136, 1);
        position: absolute;
        top: 14px;
        left: 140px;
        font-family: Inter;
        font-weight: Bold;
        font-size: 14px;
        opacity: 1;
        text-align: left;
    }

    .v2_3 {
        width: 68px;
        color: rgba(105, 98, 98, 1);
        position: absolute;
        top: 0px;
        left: 87px;
        font-family: Inter;
        font-weight: Bold;
        font-size: 13px;
        opacity: 1;
        text-align: left;
    }

    .v2_2 {
        width: 55px;
        color: rgba(143, 136, 136, 1);
        position: relative;
        top: 0px;
        left: 0px;
        font-family: Inter;
        font-weight: Bold;
        font-size: 14px;
        opacity: 1;
        text-align: left;
    }

    .v1_6 {
        width: 95px;
        color: rgba(0, 124, 255, 1);
        position: absolute;
        top: 164px;
        left: 672px;
        font-family: Inter;
        font-weight: Semi Bold;
        font-size: 20px;
        opacity: 1;
        text-align: left;
    }

    .v1_5 {
        width: 231px;
        height: 61px;
        background: url("Images/gcash (1).png");
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        opacity: 1;
        position: absolute;
        top: 52px;
        left: 604px;
        overflow: hidden;
    }

    .v1_7 {
        width: 69px;
        color: rgba(87, 80, 80, 1);
        position: absolute;
        top: 204px;
        left: 524px;
        font-family: Inter;
        font-weight: Bold;
        font-size: 14px;
        opacity: 1;
        text-align: left;
    }

    .v4_16 {
        width: 349px;
        height: 37px;
        background: url("4_16.png");
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        opacity: 1;
        position: absolute;
        top: 246px;
        left: 535px;
        overflow: hidden;
    }

    .v1_10 {
        width: 121px;
        color: rgba(143, 136, 136, 1);
        position: absolute;
        top: 20px;
        left: 163px;
        font-family: Inter;
        font-weight: Bold;
        font-size: 14px;
        opacity: 1;
        text-align: left;
    }

    .v1_9 {
        width: 29px;
        color: rgba(57, 53, 53, 1);
        position: absolute;
        top: 0px;
        left: 138px;
        font-family: Inter;
        font-weight: Bold;
        font-size: 14px;
        opacity: 1;
        text-align: left;
    }

    .v1_8 {
        width: 46px;
        color: rgba(143, 136, 136, 1);
        position: absolute;
        top: 14px;
        left: 0px;
        font-family: Inter;
        font-weight: Bold;
        font-size: 14px;
        opacity: 1;
        text-align: left;
    }

    .v1_12 {
        width: 13px;
        height: 13px;
        background: rgba(255, 255, 255, 1);
        opacity: 1;
        position: absolute;
        top: 14px;
        left: 34px;
        border-radius: 50%;
    }

    .v1_14 {
        width: 9px;
        height: 9px;
        background: rgba(0, 124, 255, 1);
        opacity: 1;
        position: absolute;
        top: 16px;
        left: 32px;
        border-radius: 50%;
    }

    .v3_11 {
        width: 320px;
        height: 46px;
        background: rgba(0, 124, 255, 1);
        opacity: 1;
        position: absolute;
        top: 668px;
        left: 558px;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
        overflow: hidden;
    }

    .v3_12 {
        width: 149px;
        color: rgba(255, 255, 255, 1);
        position: absolute;
        top: 680px;
        left: 634px;
        font-family: Inter;
        font-weight: Bold;
        font-size: 20px;
        opacity: 1;
        text-align: left;
    }
</style>
<?php } ?>