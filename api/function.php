<?php
function loginFromSocialCallBackGG($socialUser)
{
    include '../db/config.php';
    $query = mysqli_query($connect, "SELECT MaTK,Email,TenKH,AnhDD from nongsansach.taikhoan WHERE Email ='" . $socialUser['email'] . "'");

    if ($query->num_rows == 0) {
        $query = mysqli_query($connect, "INSERT INTO nongsansach.taikhoan (Email, TenKH, AnhDD, LoaiTK, TinhTrang, NgayTao, MaPQ) VALUES ('" . $socialUser['email'] . "','" . $socialUser['name'] . "','" . $socialUser['picture'] . "','Google','0', NOW() ,'3');");
        if (!$query) {
            echo mysqli_error($connect);
            exit;
        }
        $query = mysqli_query($connect, "SELECT MaTK,Email,TenKH,AnhDD from nongsansach.taikhoan WHERE Email ='" . $socialUser['email'] . "'");
    }
    if ($query->num_rows > 0) {
        $user = mysqli_fetch_assoc($query);

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['current_user'] = $user;
        header('location: ../index.php');
        // echo '<pre>';
        // var_dump($index);
        // echo '</pre>';
        // exit();
    }
}
