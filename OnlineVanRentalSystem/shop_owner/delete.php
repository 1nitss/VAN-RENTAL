<?php
require "../connection.php";
    if(isset($_GET['id'])){
    $id = $_GET['id'];

    $delete = "DELETE FROM van_information WHERE van_no = '$id'";
    $dataset = $connect->query($delete);
    header('location: dashboard.php');
    }

?>

