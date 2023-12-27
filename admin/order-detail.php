<?php
include '../db/config.php';
require('../carbon/autoload.php');

use Carbon\Carbon;
use Carbon\CarbonInterval;

$now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
$madh = $_GET['madh'];
$order_detail = mysqli_query($connect, "SELECT * FROM nongsansach.chitietdonhang,nongsansach.sanpham where chitietdonhang.MaSP = sanpham.MaSP AND chitietdonhang.MaDH = '$madh' ORDER BY chitietdonhang.MaCTDH DESC");
if (isset($_POST['trangthai'])) {
    $trangthai = $_POST['trangthai'];

    // cập nhật trạng thái
    $query = mysqli_query($connect, "UPDATE nongsansach.donhang SET TrangThai ='$trangthai' where MaDH='$madh'");
    if ($query) {
        if ($trangthai == 3) {
            $products = mysqli_query($connect, "SELECT * FROM nongsansach.chitietdonhang INNER JOIN nongsansach.sanpham ON chitietdonhang.MaSP = sanpham.MaSP WHERE MaDH='" . $madh . "' ORDER BY chitietdonhang.MaCTDH DESC");
            while ($row = mysqli_fetch_array($products)) {
                $soluonghoi = $row['SoLuong'] + $row['SoLuongMua'];
                mysqli_query($connect, "UPDATE nongsansach.sanpham set SoLuong = '$soluonghoi' WHERE MaSP =" . $row['MaSP']);
            }
        }
?>
        <script>
            window.location.replace("./order.php");
            alert("<?php echo "Cập nhật tình trạng thành công" ?>");
        </script>
    <?php
    } else {
    ?>
        <script>
            alert("<?php echo "Cập nhật tình trạng thất bại" ?>");
        </script>
<?php
    }
    //thong ke doanh thu
    $sql_lietke_dh = "SELECT * FROM nongsansach.chitietdonhang 
    inner join nongsansach.sanpham on chitietdonhang.MaSP=sanpham.MaSP
    inner join nongsansach.donhang on chitietdonhang.MaDH = donhang.MaDH
        AND chitietdonhang.MaDH='$madh' ORDER BY chitietdonhang.MaCTDH DESC";
    // SELECT * FROM nongsansach.chitietdonhang inner join nongsansach.sanpham on chitietdonhang.MaSP=sanpham.MaSP 
    // AND chitietdonhang.MaDH='$madh' ORDER BY chitietdonhang.MaCTDH DESC
    $query_lietke_dh = mysqli_query($connect, $sql_lietke_dh);

    $sql_thongke = "SELECT * FROM nongsansach.thongke WHERE NgayDat='$now'";
    $query_thongke = mysqli_query($connect, $sql_thongke);

    $delivery = "SELECT * FROM nongsansach.vanchuyen ORDER BY MaVC limit 1";
    $query = mysqli_query($connect, $delivery);

    if ($trangthai == 1) {
        $soluongmua = 0;
        $doanhthu = 0;
        while ($row = mysqli_fetch_array($query_lietke_dh)) {
            $soluongmua += $row['SoLuongMua'];
        }
        foreach ($query_lietke_dh as $doanhthu1) {
            $doanhthu = $doanhthu1['ThanhTien'];
        }
    }
    if (mysqli_num_rows($query_thongke) == 0) {
        $soluongban = $soluongmua;
        $doanhthu = $doanhthu;
        $donhang = 1;
        $sql_update_thongke = mysqli_query($connect, "INSERT INTO nongsansach.thongke (NgayDat,SoLuongBan,DoanhThu,DonHang) VALUE('$now','$soluongban','$doanhthu','$donhang')");
    } elseif (mysqli_num_rows($query_thongke) != 0) {
        while ($row_tk = mysqli_fetch_array($query_thongke)) {
            $soluongban = $row_tk['SoLuongBan'] + $soluongmua;
            $doanhthu = $row_tk['DoanhThu'] + $doanhthu;
            $donhang = $row_tk['DonHang'] + 1;
            $sql_update_thongke = mysqli_query($connect, "UPDATE nongsansach.thongke SET SoLuongBan='$soluongban',DoanhThu='$doanhthu',DonHang='$donhang' WHERE NgayDat='$now'");
        }
    }

    header('Location: order.php');
}
// }
?>
<?php include './header.php' ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Thông tin đơn hàng</h3>
                </div>
                <div class="panel-body">
                    <form action="" method="POST" class="form-inline" role="form">
                        <div class="form-group" style="display: flex;">
                            <label for="" class="sr-only">Trạng Thái</label>
                            <select name="trangthai" id="input" class="form-control" required="required">
                                <option value="0">Chờ xác nhận</option>
                                <option value="1">Đang giao</option>
                                <option value="2">Đã giao</option>
                                <option value="3">Đã hủy</option>
                            </select>
                            <button type="submit" class="btn1 btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive table-list">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh sản phẩm</th>
                            <th>Số lượng mua</th>
                            <th>Đơn giá</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_detail as $key => $value) { ?>
                            <tr>

                                <td><?= $value['MaDH'] ?></td>
                                <td><?= $value['TenSP'] ?></td>
                                <td><img src="data:image/png;base64,<?= $value['AnhSP'] ?>" alt="" width="100"></td>
                                <td><?= $value['SoLuongMua'] ?></td>
                                <td><?= number_format($value['GiaSPMua'], 0, ',', '.') ?>₫</td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include './footer.php' ?>