<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="sweet alert/sweetalert2.min.css">
    <script src="sweet alert/sweetalert2.js"></script>
</head>
<body>
<?php
    require "connection.php";
    session_start();
    if(isset($_GET['vanId'])){
        $vanID = $_GET['vanId'];
        $user_no = $_SESSION['Global_userId'];
        $add = "INSERT INTO user_favorites VALUES ('', '$vanID', '$user_no')";
        $dataset = $connect->query($add);
        if($dataset){
            echo "<script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Succesfully Added to the Favorites!',
                showConfirmButton: false,
                timer: 1500
              })
            </script>";
            header("refresh: 2 ;url = home.php");
        }
    }

?>
</body>
</html>
