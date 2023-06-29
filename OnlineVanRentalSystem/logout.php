<?php session_start() ?>
<?php
if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header("location: login.php");
}
?>