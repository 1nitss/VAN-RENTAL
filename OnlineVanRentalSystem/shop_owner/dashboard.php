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
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <link rel="stylesheet" href="../fontawesome/css/all.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
            <script src="https://kit.fontawesome.com/5a10e0b94b.js" crossorigin="anonymous"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
                            <a href="" class="active">
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

                    <div class="records table-responsive">
                        <style>
                            input[type="text"] {
                                margin: 20px;
                                width: 50%;
                                color: rgb(36, 35, 42);
                                font-size: 16px;
                                line-height: 20px;
                                min-height: 28px;
                                border-radius: 4px;
                                padding: 8px 16px;
                                border: 2px solid red;
                                box-shadow: rgb(0 0 0 / 12%) 0px 1px 3px, rgb(0 0 0 / 24%) 0px 1px 2px;
                                background: rgb(251, 251, 251);
                                transition: all 0.1s ease 0s;

                                :focus {
                                    border: 2px solid rgb(124, 138, 255);
                                }

                            }
                        </style>
                        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Van number..."
                            title="Type in a name">
                        <div>
                            <form method="GET">
                                <table id="myTable" width="100%" class="display">
                                    <thead>
                                        <tr>
                                            <th>VAN NUMBER</th>
                                            <th>VAN NAME</th>
                                            <th>MODEL</th>
                                            <th>PRICE</th>
                                            <th>AVAILABILITY</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $showvan = "SELECT * FROM van_information WHERE owner_id = '" . $_SESSION['Global_owner_no'] . "'";
                                        $dataset = $connect->query($showvan);
                                        if ($dataset) {
                                            while ($data = $dataset->fetch_assoc()) {
                                                echo "
                                                        <tr id='".$data['van_no']."'>
                                                        <td>" . $data['van_no'] . "</td>
                                                        <td>" . $data['van_name'] . "</td>
                                                        <td>" . $data['van_model'] . "</td>
                                                        <td>" . $data['price'] . "</td>
                                                        <td>" . $data['availability'] . "</td>
                                                        <td>
                                                        <a href = 'update_van.php?id=" . $data['van_no'] . "' style = 'color: green'>EDIT</a>&nbsp&nbsp&nbsp
                                                        <button class='btn btn-danger btn-sm remove' value = '".$data['van_no']."' style = 'border: none'><i class='las la-trash-alt' style = 'font-size: 28px; color: red'></i></button>
                                                        </td>
                                                        </tr>
                                                        ";
                                            }
                                        }
                                        ?>
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
                                                            error: function () {
                                                                alert('Something is wrong');
                                                            },
                                                            success: function (data) {
                                                                $("#" + id).hide(2000);
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
                                    </tbody>
                                </table>
                            </form>
                        </div>

                    </div>

                </div>

            </main>

        </div>
        <script>
            function myFunction() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>
    </body>

    </html>
<?php } ?>