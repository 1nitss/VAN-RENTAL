<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="../css/admin_payment.css">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../sweet alert/sweetalert2.min.css">
    <script src="../sweet alert/sweetalert2.js"></script>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <script src="../bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/admine_profile.css">
</head>
<body>
    
<?php 
    
    if(isset($_POST['pay'])){
        require_once "../connection.php";
        $fullname=mysqli_real_escape_string($connect, $_SESSION['fname']);
        $username=mysqli_real_escape_string($connect, $_SESSION['user_name']);
        $password=mysqli_real_escape_string($connect, $_SESSION['pass']);
        $gender=mysqli_real_escape_string($connect, $_SESSION['gender']);
        $birthday=mysqli_real_escape_string($connect,  $_SESSION['birthday']);
        $region=mysqli_real_escape_string($connect, $_SESSION['region']);
        $city=mysqli_real_escape_string($connect, $_SESSION['city']);
        $street=mysqli_real_escape_string($connect, $_SESSION['street2']);
        $zipcode=mysqli_real_escape_string($connect, $_SESSION['zip']);
        $phone=mysqli_real_escape_string($connect,  $_SESSION['p_no']);

        $addQuery = "INSERT INTO `shop_owner`(`owner_id`, `profile_picture`, `full_name`, `username`, `password`, `gender`, `birthday`, `phone_number`, `street`, `city`, `region`, `zipcode`) VALUES ('','default_profile_picture.png','$fullname','$username','$password','$gender','$birthday','$phone','$street','$city','$region','$zipcode')";

        $dataset=$connect->query($addQuery)or die("Error Query");

        if ($dataset){
            echo "<script>Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Registered Successfully',
              showConfirmButton: false,
              timer: 2000
            })</script>";
            $_SESSION['uname1'] = $username;
            $_SESSION['pass2'] = $password;
            header("Refresh: 3 ;url=login.php");
        }

        
    }

    if(isset($_POST['pay'])){
    $payment = 100;
    
    $curr_date = date('Y-m-d');
    $ADD = "INSERT INTO revenue VALUES ('', '$payment', '$curr_date')";
    $addedRevenue = $connect->query($ADD);

    }

?>
    <form method = "post">
<div class="container p-0">
        <div class="card px-4">
            <p class="h8 py-3">One Time Payment</p>
            <div class="row gx-3">
                <div class="col-12">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Person Name</p>
                        <input class="form-control mb-3" type="text" placeholder="Name">
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Card Number</p>
                        <input class="form-control mb-3" type="number" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Expiry</p>
                        <input class="form-control mb-3" type="text" placeholder="MM/YYYY" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">CVV/CVC</p>
                        <input class="form-control mb-3 pt-2 " type="password" placeholder="***" required>
                    </div>
                </div>
                <div class="col-12">
                       <button class="button-24" style="width: 100% !important;" name = "pay">PAY100</button>
                </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>