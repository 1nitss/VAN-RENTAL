<?php
require "../connection.php";
$select = "SELECT YEAR(`date`) as `year`, SUM(`revenue`) as `total_revenue` 
  FROM `revenue` 
  GROUP BY YEAR(`date`)
  ORDER BY SUM(`revenue`) DESC;";
$result = mysqli_query($connect, $select);
$chart_data = '';

while ($row = mysqli_fetch_array($result)) {
  $chart_data .= "{date: " . $row['year'] . ", revenue: " . $row['total_revenue'] . "}, ";
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

</head>

<body>
  <div class="grid-container">
    <aside id="sidebar">
      <ul class="sidebar-list">
        <li class="sidebar-list-item">
          <a href="dashboard.php">
            <span class="material-icons-outlined">dashboard</span> Dashboard
          </a>
        </li>
        <li class="sidebar-list-item">
          <a href="total_users.php">
          <i class="fa-solid fa-users" style="font-size: 30px;color: red"></i>  Users
          </a>
        </li>
        <li class="sidebar-list-item">
          <a href="total_owners.php">
          <i class="fa-solid fa-users" style="font-size: 30px;"></i>  Shop Owners
          </a>
        </li>
      </ul>
    </aside>
    <main class="main-container" style="color: white">
    <div class="main-title">

<h2>USERS</h2>
</div>
        <table id = 'myTable' width = "100%">
            <thead>
                <tr>
                    <th>USER NUMBER</th>
                    <th>FULL NAME</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $select = "SELECT * FROM user_account";
                $dataset = $connect->query($select);

                if($dataset){
                    while($data = $dataset -> fetch_assoc()){
                        echo "<tr>
                        <td>".$data['user_no']."</td>
                        <td>".$data['full_name']."</td>
                    </tr>";
                    }
                }
                ?>
                <script>
                                $(document).ready( function () {
    $('#myTable').DataTable();
} );
                </script>
                
            </tbody>
        </table>
    </main>

  </div>
</body>

</html>