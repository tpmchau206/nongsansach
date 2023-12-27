<?php
include '../db/config.php';
    if(isset($_GET['madm'])){
        $id = $_GET['madm'];

       $query= mysqli_query($connect, "DELETE FROM nongsansach.danhmuc where MaDM=$id");
    if($query){
        header('Location: ./category.php');
    }else{
        echo 'Xoá không thành công';
    }
    }
?>