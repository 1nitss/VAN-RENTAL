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
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Favorites</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" href="css/favoriteStyles.css">
        <link rel="stylesheet" href="css/nav.css">
        <link rel="stylesheet" href="css/fonts.css">
        <link rel="stylesheet" href="sweet alert/sweetalert2.min.css">
        <script src="sweet alert/sweetalert2.js"></script>
                    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
            <script src="https://kit.fontawesome.com/5a10e0b94b.js" crossorigin="anonymous"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    </head>
        
    <link rel="stylesheet" href="fontawesome/css/all.css">
    </head>

    <body>
        <?php
        if (isset($_GET['vanId'])) {
            $vanID = $_GET['vanId'];
            $user_no = $_SESSION['Global_userId'];
            $selectFav = mysqli_query($connect, "SELECT van_no FROM user_favorites WHERE van_no = $vanID");
            if (mysqli_num_rows($selectFav) == 1) {
                echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Van already in favorite!'
              })
            </script>";
            } else {
                $add = "INSERT INTO user_favorites VALUES ('', '$vanID', '$user_no')";
                $dataset = $connect->query($add);
                if ($dataset) {
                    echo "<script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Succesfully Added to the Favorites!',
                showConfirmButton: false,
                timer: 1500
              })
            </script>";
                }
            }
        }

        ?>
        <div class="hero">
            <nav>
            <img src="Images/rentavan_logo.png" alt="RentAvan" class="logo" style = "width: 200px">
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="transaction.php">Transactions</a></li>
                    <li><a href="search.php">Search</a></li>
                </ul>
                <img src="<?php if ($row["profile_pic"] === "") {
                    echo "profile_pictures/default_profile_picture.png";
                } else {
                    echo "profile_pictures/" . $row['profile_pic'];
                } ?>"
                    alt="RentAvan" class="user-pic" onclick="toggleMenu()">
                <a href="user_profile.php">
                    <?php echo $row['full_name']; ?>
                </a>
                <form action="logout.php" method="post">
                    <div class="sub-menu-container" id="subMenu">
                        <div class="sub-menu">
                            <div class="user-info">
                                <img src="<?php if ($row["profile_pic"] === "") {
                                    echo "profile_pictures/default_profile_picture.png";
                                } else {
                                    echo "profile_pictures/" . $row['profile_pic'];
                                } ?>"
                                    alt="RentAvan" class="user-pic" onclick="toggleMenu()">
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
        <!-- Body -->
        <div class="container">
            <div class="row">
                <?php
                $user_no1 = $_SESSION['Global_userId'];
                $showAll = "SELECT van_information.van_name, van_information.van_model, van_information.price, van_information.van_image, van_information.van_no FROM van_information JOIN user_favorites ON van_information.van_no = user_favorites.van_no AND user_no = '$user_no1'";
                $dataset1 = $connect->query($showAll);
                if ($dataset1) {
                    while ($data = $dataset1->fetch_assoc()) {
                        echo "
                        <form method = 'get'>
                        <div class='col-xl-12'>
                            <div class='card mb-3 card-body'>
                                <div class='row align-items-center'>
                                    <div class='col-auto'>
                                        <a href='#!.html'>
                                            <img src='images/19MBSprinter.png' class='width-90 rounded-3' alt=''>
                                        </a>
                                    </div>
                                    <div class='col'>
                                        <div class='overflow-hidden flex-nowrap'>
                                            <h6 class='mb-1'>
                                                <a href='#!' class='text-reset'>".$data['van_name']."</a>
                                            </h6>
                                            <span class='text-muted d-block mb-2 small'>
                                                <p style = 'color: white'>Model: ".$data['van_model']."</p>
                                                $".$data['price']."
                                            </span>
                                            <div class='row align-items-center'>
                                                <div class='col-12'>
                                                    <div class='row align-items-center g-0'>
                                                        <div class='col'>
                                                            <a href = 'complete_info.php?id=".$data['van_no']."'><button type='button' class='btn btn-success'>Rent Now</button></a>
                                                            <button class='btn btn-danger btn-sm remove' value = '".$data['van_no']."' style = 'border: none'>REMOVE</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>";
                    }
                }

                ?>


            </div>
        </div>
        
        <script>

$('.remove').click(function (e) {
    e.preventDefault();
    var id = $(this).val();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'delete.php',
                type: 'GET',
                data: { id: id },
                success: function (data) {
                    setTimeout("window.location = 'favorite.php'",2000);
                }
            });
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
        }
    })
});
</script>

        <script>
            let subMenu = document.getElementById("subMenu");

            function toggleMenu() {
                subMenu.classList.toggle("open-menu");
            }
        </script>
    </body>

    </html>
<?php
}
?>