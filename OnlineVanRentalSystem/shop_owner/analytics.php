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
        <link rel="stylesheet"
            href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
        <style>
            .button-4 {
                appearance: none;
                background-color: #FAFBFC;
                border: 1px solid rgba(27, 31, 35, 0.15);
                border-radius: 6px;
                box-shadow: rgba(27, 31, 35, 0.04) 0 1px 0, rgba(255, 255, 255, 0.25) 0 1px 0 inset;
                box-sizing: border-box;
                color: #24292E;
                cursor: pointer;
                display: inline-block;
                font-family: -apple-system, system-ui, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
                font-size: 14px;
                font-weight: 500;
                line-height: 20px;
                list-style: none;
                padding: 6px 16px;
                position: relative;
                transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
                user-select: none;
                -webkit-user-select: none;
                touch-action: manipulation;
                vertical-align: middle;
                white-space: nowrap;
                word-wrap: break-word;
            }

            .button-4:hover {
                background-color: #F3F4F6;
                text-decoration: none;
                transition-duration: 0.1s;
            }

            .button-4:disabled {
                background-color: #FAFBFC;
                border-color: rgba(27, 31, 35, 0.15);
                color: #959DA5;
                cursor: default;
            }

            .button-4:active {
                background-color: #EDEFF2;
                box-shadow: rgba(225, 228, 232, 0.2) 0 1px 0 inset;
                transition: none 0s;
            }

            .button-4:focus {
                outline: 1px transparent;
            }

            .button-4:before {
                display: none;
            }

            .button-4:-webkit-details-marker {
                display: none;
            }
        </style>
    </head>

    <body>
        <?php
        require "../connection.php";
        $select = "SELECT 
DATE_FORMAT(date, '%M') AS month, 
SUM(revenue) AS monthly_revenue 
FROM 
shop_revenue
WHERE 
owner_id = '" . $_SESSION['Global_owner_no'] . "'
GROUP BY 
month 
ORDER BY 
MONTH(date)";
        $result = mysqli_query($connect, $select);
        $chart_data = '';

        while ($row1 = mysqli_fetch_array($result)) {
            $chart_data .= "{date: '" . $row1['month'] . "', revenue: " . $row1['monthly_revenue'] . "}, ";
        }

        $chart_data = substr($chart_data, 0, -2);

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
                            <a href="">
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

                    <div class="analytics">

                        <div class="card">
                            <div class="card-head">
                                <?php

                                require "../connection.php";
                                $show1 = "SELECT count(*) as count FROM van_information WHERE owner_id = " . $_SESSION['Global_owner_no'] . "";
                                $run1 = mysqli_query($connect, $show1);
                                while ($count1 = mysqli_fetch_assoc($run1)) {
                                    $output1 = $count1['count'];
                                    if ($output1 == 0 && $_SESSION) {
                                        echo '<h2>No Records</h2>';
                                    } else {
                                        echo "<h2>" . $output1 . "</h2>";
                                    }
                                }

                                ?>
                                <span class="fa-solid fa-van-shuttle" style="color: red;"></span>
                            </div>
                            <div class="card-progress">
                                <small>Total Vans</small>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-head">
                                <?php

                                require "../connection.php";
                                //SHOW RECORDS
                                $show2 = "SELECT count(*) as count FROM booked WHERE owner_id = '" . $_SESSION['owner_no'] . "'";
                                $run2 = mysqli_query($connect, $show2);
                                while ($count2 = mysqli_fetch_assoc($run2)) {
                                    $output2 = $count2['count'];
                                    if ($output2 == 0 && $_SESSION) {
                                        echo '<h2>No Records</h2>';
                                    } else {
                                        echo "<h2>" . $output2 . "</h2>";
                                    }
                                }

                                ?>
                                <span class="las la-check-double" style="color: red;"></span>
                            </div>
                            <div class="card-progress">
                                <small>Total Rented Vans</small>

                            </div>
                        </div>

                        <div class="card">
                            <div class="card-head">
                                <?php

                                require "../connection.php";
                                //SHOW RECORDS
                                $show3 = "SELECT count(*) as count FROM van_information WHERE owner_id = '" . $_SESSION['Global_owner_no'] . "' AND availability = 'unavailable' OR availability = 'damaged'";
                                $run3 = mysqli_query($connect, $show3);
                                while ($count3 = mysqli_fetch_assoc($run3)) {
                                    $output3 = $count3['count'];
                                    if ($output3 == 0 && $_SESSION) {
                                        echo '<h2>No Records</h2>';
                                    } else {
                                        echo "<h2>" . $output3 . "</h2>";
                                    }
                                }

                                ?>
                                <span class="fa-solid fa-hammer" style="color: red;"></span>
                            </div>
                            <div class="card-progress">
                                <small>Damaged/Unavailable Vans</small>

                            </div>
                        </div>
                    </div>
                    <a href="analytics.php"><button class="button-4 is-active" role="button" style="background-color: cyan;">By Month</button></a>
                    <a href="analytics_year.php"><button class="button-4" role="button">By Year</button></a>
                    <div class="records table-responsive" style="background-color: #080710 !important;">
                        <div id='myfirstchart' style="height: 400px; width: 100%;" class="tabs__content is-active">
                        </div>
                    </div>

                </div>

            </main>

        </div>
        <script>
            new Morris.Bar({
                // ID of the element in which to draw the chart.
                element: 'myfirstchart',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data: [<?php echo $chart_data; ?>],
                // The name of the data record attribute that contains x-values.
                xkey: 'date',
                // A list of names of data record attributes that contain y-values.
                ykeys: ['revenue'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['Revenue'],


            });
        </script>
    </body>

    </html>
<?php } ?>