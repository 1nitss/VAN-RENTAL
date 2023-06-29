<?php
    session_start();
    if(isset($_GET['id'])){
    session_unset();
    session_destroy();

    header("location: login.php");
    }

?>