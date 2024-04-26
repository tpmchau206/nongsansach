<?php
if (!isset($_SESSION)) {
    session_start();
}

$host_name = 'localhost';
$user_name = 'root';
$password = '';
$db_name = '';

$connect = mysqli_connect($host_name, $user_name, $password, $db_name) or die('Lỗi kết nối');

mysqli_query($connect, "set names utf8");
mysqli_character_set_name($connect);
