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
        <link rel="stylesheet" href="../css/update_van.css">
        <link rel="stylesheet"
            href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

        <link rel="stylesheet" href="../sweet alert/sweetalert2.min.css">
        <script src="../sweet alert/sweetalert2.js"></script>
    </head>

    <body>
        <?php

        if (isset($_POST['submit'])) {
            $_SESSION['vancount'] = $_POST['van_count'];
            header("location: add_van.php");
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
                            <a href="profile.php?id=<?php echo $_SESSION['Global_owner_no'] ?>">
                                <span class="las la-user-alt" style="color: cyan;"></span>
                                <small style="font-size: 18px;">Profile</small>
                            </a>
                        </li>
                        <li>
                            <a href="add_count.php" class="active">
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
                                    <h2 class="title">Add Van</h2>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="form-row">
                                            <div class="name">Van Count</div>
                                            <div class="value">
                                                <input class="input--style-6" type="number" name="van_count">

                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button class="btn btn--radius-2 btn--blue-2" type="submit"
                                                name='submit'>Continue</button>
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