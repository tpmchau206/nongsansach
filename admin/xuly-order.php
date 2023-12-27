<?php
include '../db/config.php';
if(isset($_GET['TrangThai'])){
    $status = $_GET['TrangThai'];
    $chitietdh = $_GET['chitietdh'];
    $sql = mysqli_query($connect,"UPDATE nongsansach.donhang SET TrangThai ='".$status."' WHERE TrangThai='".$chitietdh."' LIMIT 1" );
    header('Location: ./order.php');
    // '".$status."'
}
?>