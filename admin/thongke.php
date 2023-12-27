<?php

use Carbon\Carbon;
use Carbon\CarbonInterval;

include('../db/config.php');
require('../carbon/autoload.php');
$now = Carbon::now('Asia/Ho_Chi_Minh');

if (isset($_POST['thoigian'])) {
	$thoigian = $_POST['thoigian'];
} else {
	$thoigian = '';
	$subdays = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
}

if ($thoigian == '7ngay') {
	$subdays = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
} elseif ($thoigian == '28ngay') {
	$subdays = Carbon::now('Asia/Ho_Chi_Minh')->subdays(28)->toDateString();
} elseif ($thoigian == '90ngay') {
	$subdays = Carbon::now('Asia/Ho_Chi_Minh')->subdays(90)->toDateString();
} elseif ($thoigian == '365ngay') {
	$subdays = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
}


$now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

$sql = "SELECT * FROM nongsansach.thongke WHERE NgayDat BETWEEN '$subdays' AND '$now' ORDER BY NgayDat ASC";
$sql_query = mysqli_query($connect, $sql);

while ($val = mysqli_fetch_array($sql_query)) {

	$chart_data[] = array(
		'date' => $val['NgayDat'],
		'order' => $val['DonHang'],
		'sales' => $val['DoanhThu'],
		'quantity' => $val['SoLuongBan']

	);
}
echo $data = json_encode($chart_data);
