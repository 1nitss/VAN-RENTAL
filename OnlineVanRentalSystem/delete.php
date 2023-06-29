<?php
require "connection.php";
    if(isset($_GET['id'])){
    $id = $_GET['id'];

    $delete = "DELETE FROM user_favorites WHERE van_no = '$id'";
    $dataset = $connect->query($delete);
    if($dataset){
        header('location: favorite.php');
    }
    }

?>

