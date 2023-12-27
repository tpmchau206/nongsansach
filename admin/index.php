<?php
    session_start();
    if(!isset($_SESSION['current_user'])){
        header("Location: ./category.php");
    }

?>
<?php include './header.php'?>
<div class="container-fluid">
                
<?php include './footer.php'?>