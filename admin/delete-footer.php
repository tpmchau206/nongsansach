<?php
include '../db/config.php';
    if(isset($_GET['mact'])){
        $id = $_GET['mact'];

       $query= mysqli_query($connect, "DELETE FROM nongsansach.chantrang where MaCT=$id");
    if($query){
        header('Location: ./footer-listing.php');
    }else{
        echo 'Xoá không thành công';
    }
    }
