<?php
include '../db/config.php';
//hủy session theo tên
unset($_SESSION['current_user']);
unset($_SESSION['access_token']);
unset($_SESSION['address']);
// unset($_SESSION['cart']);
// session_destroy(); //xóa tất cả session
header('location: ../index.php');
