<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In Your Account</title>
    <link rel="stylesheet" href="bootstrap/style.css">
    <link rel="stylesheet" href="css/loginStyle.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="sweet alert/sweetalert2.min.css">
    <script src="sweet alert/sweetalert2.js"></script>
</head>
<body>

    
    

    <div class = "welcome">
        <h2>Welcome To RentAVan</h2>
        <img src="images/19MBSprinter.png">
    </div>

    <form method = "post">
        <h3>Login Here</h3>

        <label for="username">Username</label>
        <input type="text" placeholder="Email or Phone" name = "username" value = "<?php if(isset($_SESSION['uname'])){
            echo $_SESSION['uname'];
        }else{
            echo "";
        }
        ?>">

        <label for="password">Password</label>
        <input type="password" placeholder="Password" name = "password" value = "<?php if(isset($_SESSION['pass'])){
            echo $_SESSION['pass'];
        }else{
            echo "";
        }
        ?>">

        <button name = "log-in">Log In</button>
        <?php
        require "connection.php";
        if(isset($_POST['log-in'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $check = mysqli_query( $connect, "SELECT`username`, `password`FROM `user_account` WHERE '$username'= username AND '$password' = password");
            if( mysqli_num_rows($check) == 1 ) {
                header('location: home.php');
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
            }else{
                echo "<script>
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer)
                      toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                  })
                  
                  Toast.fire({
                    icon: 'warning',
                    title: 'Incorrect Username or Password'
                  })
                    </script>";
            }
        }
        ?>
    </form>
</body>
</html>
