<?php
include '../db/config.php';
    if(isset($_GET['madh'])){
        $id = $_GET['madh'];

       $query= mysqli_query($connect, "DELETE FROM nongsansach.donhang where MaDH=$id");
    if($query){
        header('Location: ../?mod=displays/cart');
    }else{
        echo 'Xoá không thành công';
    }
    }
