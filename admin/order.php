<?php
include '../db/config.php';
$order = mysqli_query($connect, "SELECT * FROM nongsansach.donhang inner join nongsansach.thongtinnguoinhan ON `donhang`.`MaNN` = `thongtinnguoinhan`.`MaNN` ORDER BY NgayDatHang DESC");
// $order = mysqli_query($connect, "SELECT * FROM nongsansach.donhang ORDER BY NgayDatHang DESC");

?>
<?php include './header.php' ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Danh sách đơn hàng</h3>
                </div>
                <div class="panel-search">
                    <input type="text" id="myInput" placeholder="Tìm kiếm">
                    <script>
                        $(document).ready(function() {
                            $("#myInput").on("keyup", function() {
                                var value = $(this).val().toLowerCase();
                                $("#table-order tbody tr").filter(function() {
                                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                });
                            });
                        });
                    </script>
                </div>
            </div>
            <div class="table-responsive table-list">
                <table class="table table-bordered table-hover" id="table-order">
                    <thead>
                        <tr>
                            <th>Mã ĐH</th>
                            <th style="min-width: 150px;">Tên khách hàng</th>
                            <th style="min-width: 150px;">Số điện thoại</th>
                            <th style="min-width: 150px;">Địa chỉ</th>
                            <th>Phương thức thanh toán</th>
                            <th>Thành tiền</th>
                            <th>Ngày đặt hàng</th>
                            <th>Tình trạng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($order as $key => $value) {
                            $arr = explode(', ', $value['DuLieu']);
                        ?>
                            <tr>
                                <td><?php echo $value['MaDH'] ?></td>
                                <td><?php echo $arr[0] ?></td>
                                <td><?php echo $arr[1] ?></td>
                                <td><?php echo $arr[2] . ', ' . $arr[3] . ', ' . $arr[4] . ', ' . $arr[5] ?></td>
                                <td><?php echo $value['PTThanhToan'] ?></td>
                                <td><?php echo number_format($value['ThanhTien'], 0, ',', '.') ?>đ</td>
                                <td><?= $value['NgayDatHang'] ?></td>
                                <td>
                                    <?php if ($value['TrangThai'] == 0) { ?>
                                        <p class="btn btn-warning">Chờ xác nhận</p>
                                    <?php } elseif ($value['TrangThai'] == 1) { ?>
                                        <p class="btn btn-primary">Đang giao</p>
                                    <?php } elseif ($value['TrangThai'] == 2) { ?>
                                        <p class="btn btn-primary">Đã giao</p>
                                    <?php } elseif ($value['TrangThai'] == 3) { ?>
                                        <p class="btn btn-warning">Đã hủy</p>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="./order-detail.php?madh=<?php echo $value['MaDH'] ?>" class="btn btn-outline-success" title="Xem đơn hàng"><span class="fas fa-search"></span></a>
                                    <?php if($value['TrangThai'] == 3 || $value['TrangThai'] ==2 || $value['TrangThai'] ==0) {?>
                                    <a href="./order-delete.php?madh=<?php echo $value['MaDH'] ?>" class="btn btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa không')"><span class="fas fa-window-close"></span></a>
                                    <?php }?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>
</div>
<?php include './footer.php' ?>