<?php
session_start();
?>
<?php
if (!(isset($_SESSION['admin_username']))) {
    echo "Please Log in Your Account First, Redirecting...";
    header("Refresh: 3 ; url = login.php");
} else {
    require "../connection.php";
    $query = mysqli_query($connect, "SELECT * FROM `shop_owner` WHERE owner_id = '".$_SESSION['owner_no']."'");
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

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://kit.fontawesome.com/5a10e0b94b.js" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <link rel="stylesheet" href="../css/admin_profile.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
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
            .button-4.is-active{
                background: cyan;
            }
            .tabs__content {
                display: none;
            }
            .tabs__content.is-active{
                display: block;
            }
        </style>
    </head>

    <body>
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
                            <a href="dashboard.php" >
                                <span class="las la-home" style="color: cyan;"></span></span>
                                <small style="font-size: 18px;">Dashboard</small>
                            </a>
                        </li>
                        <li>
                            <a href="profile.php?id=<?php echo $_SESSION['Global_owner_no'] ?>" >
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
                            <a href="transaction.php" class="active">
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
                </div><br>
                <div style="margin: 10px;" class="tabs">
                <button class="button-4 is-active">Paid</button>
                <button class="button-4">Pending Payment</button>
                <div style="color: white; margin: 10px; background-color: white; padding: 10px;" class="tabs__content is-active">
                    <table id = 'myTable' style="background-color: white;">
                        <thead>
                            <tr style="background-color: cyan;">
                                <th>TRANSACTION NO</th>
                                <th>USER NO</th>
                                
                                <th>VAN NO</th>
                                <th>FULL NAME</th>
                                <th>VAN NAME</th>
                                <th>FROM</th>
                                <th>TO</th>
                                <th>TRANSACTION DATE</th>
                                <th>TOTAL PAYMENT</th>
                                <th>PAYMENT STATUS</th>
                            </trd>
                        </thead>
                        <tbody>
                            <?php

                            $select = "SELECT booked.transac_no, booked.user_no, booked.price, user_account.full_name, booked.van_no, van_information.van_name, booked.from_date,booked.to_date,booked.transaction_date,booked.payment_status FROM booked JOIN user_account  ON booked.user_no = user_account.user_no JOIN van_information ON booked.van_no = van_information.van_no AND van_information.owner_id = '".$_SESSION['owner_no']."' AND booked.payment_status = 'paid'";

                            $dataset = $connect->query($select);
                            if($dataset){
                                while($data = $dataset -> fetch_assoc()){
                                    echo " <tr style = 'background-color: lightcyan'>
                                    <td>".$data['transac_no']."</td>
                                    <td>".$data['user_no']."</td>
                                    <td>".$data['van_no']."</td>
                                    <td>".$data['full_name']."</td>
                                    <td>".$data['van_name']."</td>
                                    <td>".$data['from_date']."</td>
                                    <td>".$data['to_date']."</td>
                                    <td>".$data['transaction_date']."</td>
                                    <td>".$data['price']."</td>
                                    <td>".$data['payment_status']."</td>
                                </tr>";
                                }
                            }
                            ?>
                           
                        </tbody>
                    </table>
                </div>
                <div style="color: black; margin: 10px; background-color: white; padding: 10px;" class="tabs__content">
                    <table id = 'myTable1' style="background-color: white;">
                        <thead>
                            <tr style="background-color: cyan;">
                                <th>TRANSACTION NO</th>
                                <th>USER NO</th>
                                
                                <th>VAN NO</th>
                                <th>FULL NAME</th>
                                <th>VAN NAME</th>
                                <th>FROM</th>
                                <th>TO</th>
                                <th>TRANSACTION DATE</th>
                                <th>TOTAL PAYMENT</th>
                                <th>PAYMENT STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $select = "SELECT booked.transac_no, booked.user_no, booked.price, user_account.full_name, booked.van_no, van_information.van_name, booked.from_date,booked.to_date,booked.transaction_date,booked.payment_status FROM booked JOIN user_account  ON booked.user_no = user_account.user_no JOIN van_information ON booked.van_no = van_information.van_no AND van_information.owner_id = '".$_SESSION['owner_no']."' AND booked.payment_status != 'paid'";

                            $dataset = $connect->query($select);
                            if($dataset){
                                while($data = $dataset -> fetch_assoc()){
                                    echo " <tr style = 'background-color: lightcyan'>
                                    <td>".$data['transac_no']."</td>
                                    <td>".$data['user_no']."</td>
                                    <td>".$data['van_no']."</td>
                                    <td>".$data['full_name']."</td>
                                    <td>".$data['van_name']."</td>
                                    <td>".$data['from_date']."</td>
                                    <td>".$data['to_date']."</td>
                                    <td>".$data['transaction_date']."</td>
                                    <td>".$data['price']."</td>
                                    <td>".$data['payment_status']."</td>
                                </tr>";
                                }
                            }
                            ?>
                           
                        </tbody>
                    </table>
                </div>
            </main>

        </div>
        <script>
            $(document).ready( function () {
    $('#myTable').DataTable();
} );
        </script>
                <script>
            $(document).ready( function () {
    $('#myTable1').DataTable();
} );
        </script>
        <script>
            let tabs = document.querySelectorAll('.button-4'),
                contents = document.querySelectorAll('.tabs__content');

            tabs.forEach((tab,index) => {
                tab.addEventListener('click', () => {
                    contents.forEach((content) => {
                        content.classList.remove('is-active')
                    });
                    tabs.forEach((tab) => {
                        tab.classList.remove('is-active');
                    });
                    contents[index].classList.add('is-active');
                    tabs[index].classList.add('is-active');
                });
            });
        </script>
    </body>

    </html>
<?php } ?>