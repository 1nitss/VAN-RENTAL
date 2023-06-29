<?php
require "../connection.php";
$select = "SELECT DATE_FORMAT(date, '%M') as month, SUM(revenue) as total_revenue
FROM revenue
GROUP BY DATE_FORMAT(date, '%M')
ORDER BY SUM(revenue) DESC";
$result = mysqli_query($connect, $select);
$chart_data = '';

while ($row = mysqli_fetch_array($result)) {
  $chart_data .= "{date: '" . $row['month'] . "', revenue: " . $row['total_revenue'] . "}, ";
}

$chart_data = substr($chart_data, 0, -2);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Admin Dashboard</title>

  <!-- Montserrat Font -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="dashboard.css">

  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <link rel="stylesheet" href="../fontawesome/css/all.css">

</head>

<body>
  <div class="grid-container">
    <aside id="sidebar">
      <ul class="sidebar-list">
        <li class="sidebar-list-item">
          <a href="dashboard.php">
            <span class="material-icons-outlined" style="color: red;">dashboard</span> Dashboard
          </a>
        </li>
        <li class="sidebar-list-item">
          <a href="total_users.php">
          <i class="fa-solid fa-users" style="font-size: 30px;"></i>  Users
          </a>
        </li>
        <li class="sidebar-list-item">
          <a href="total_owners.php">
          <i class="fa-solid fa-users" style="font-size: 30px;"></i>  Shop Owners
          </a>
        </li>
      </ul>
    </aside>
    <main class="main-container">
      <div class="main-title">

        <h2>GOOD DAY</h2>
      </div>

      <div class="main-cards">

        <div class="card">
          <div class="card-inner">
            <h3>TOTAL SHOP OWNERS</h3>
            <i class="fa-solid fa-shop" style="font-size: 40px;"></i>
          </div>
          <?php

          require "../connection.php";
          //SHOW RECORDS
          $show1 = "SELECT count(*) as count FROM shop_owner";
          $run1 = mysqli_query($connect, $show1);
          while ($count1 = mysqli_fetch_assoc($run1)) {
            $output1 = $count1['count'];
            if ($output1 == 0 && $_SESSION) {
              echo '<h1>No Records</h1>';
            } else {
              echo "<h1>" . $output1 . "</h1>";
            }
          }

          ?>
        </div>

        <div class="card">
          <div class="card-inner">
            <h3>TOTAL USERS</h3>
            <i class="fa-solid fa-users" style="font-size: 40px;"></i>
          </div>
          <?php

          require "../connection.php";
          //SHOW RECORDS
          $show = "SELECT count(*) as count FROM user_account";
          $run = mysqli_query($connect, $show);
          while ($count = mysqli_fetch_assoc($run)) {
            $output = $count['count'];
            if ($output == 0 && $_SESSION) {
              echo '<h1>No Records</h1>';
            } else {
              echo "<h1>" . $output . "</h1>";
            }
          }

          ?>
        </div>

        <div class="card">
          <div class="card-inner">
            <h3>TOTAL REVENUE</h3>
            <i class="fa-solid fa-money-bill" style="font-size: 40px;"></i>
          </div>
          <?php

          require "../connection.php";
          //SHOW RECORDS
          $show = "SELECT SUM(revenue) as count FROM revenue";
          $run = mysqli_query($connect, $show);
          while ($count = mysqli_fetch_assoc($run)) {
            $output = $count['count'];
            if ($output == 0 && $_SESSION) {
              echo '<h1>No Records</h1>';
            } else {
              echo "<h1>" . $output . "</h1>";
            }
          }

          ?>
        </div>

      </div>

      <div id='myfirstchart' style="height: 300px; width: 100%;">
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