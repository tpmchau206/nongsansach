<?php
if (!isset($_SESSION)) {
    session_start();
}

$host_name = 'localhost';
$db_name = 'mysql';
$user_name = 'root';
$password = '';

$connect = mysqli_connect($host_name, $user_name, $password, $db_name) or die('Lỗi kết nối');

mysqli_query($connect, "set names utf8");
mysqli_character_set_name($connect);
