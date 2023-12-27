<?php

require('../carbon/autoload.php');
include('../db/config.php');

use Carbon\Carbon;
use Carbon\CarbonInterval;

$now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
if (isset($_GET['madh'])) {
    $madh = $_GET['madh'];
    // $trangthai = $_POST['trangthai'];
    $sql_update = "UPDATE nongsansach.donhang SET Trangthai=1 WHERE MaDH='" . $madh . "'";
    $query = mysqli_query($mysqli, $sql_update);

    //thong ke doanh thu
    $sql_lietke_dh = "SELECT * FROM nongsansach.chitietdonhang 
    inner join nongsansach.sanpham on chitietdonhang.MaSP=sanpham.MaSP
    inner join nongsansach.donhang on chitietdonhang.MaDH = donhang.MaDH
        AND chitietdonhang.MaDH='$madh' ORDER BY chitietdonhang.MaCTDH DESC";
    $query_lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);

    $sql_thongke = "SELECT * FROM nongsansach.thongke WHERE NgayDat='$now'";
    $query_thongke = mysqli_query($mysqli, $sql_thongke);

    $delivery = "SELECT * FROM nongsansach.vanchuyen ORDER BY MaVC LIMIT 1";
    $query = mysqli_query($connect, $delivery);
    if ($trangthai == 1) {
        $soluongmua = 0;
        $doanhthu = 0;
        while ($row = mysqli_fetch_array($query_lietke_dh)) {
            $soluongmua += $row['SoLuongMua'];
            // $doanhthu += $row['GiaSPMua'] * $row['SoLuongMua'];
        }
        foreach ($query_lietke_dh as $doanhthu1) {
        $doanhthu = $doanhthu1['ThanhTien'];
        }
    }
    if (mysqli_num_rows($query_thongke) == 0) {
        $soluongban = $soluongmua;
        $doanhthu = $doanhthu;
        $donhang = 1;
        $sql_update_thongke = mysqli_query($connect, "INSERT INTO nongsansach.thongke (MaThongKe,NgayDat,SoLuongBan,DoanhThu,DonHang) VALUE(NULL,'$now','$soluongban','$doanhthu','$donhang')");
    } elseif (mysqli_num_rows($query_thongke) != 0) {
        while ($row_tk = mysqli_fetch_array($query_thongke)) {
            $soluongban = $row_tk['SoLuongBan'] + $soluongmua;
            $doanhthu = $row_tk['DoanhThu'] + $doanhthu;
            $donhang = $row_tk['DonHang'] + 1;
            $sql_update_thongke = mysqli_query($mysqli, "UPDATE nongsansach.thongke SET SoLuongBan='$soluongban',DoanhThu='$doanhthu',DonHang='$donhang' WHERE NgayDat='$now'");
        }
    }


    header('Location: order-detail.php');
}
