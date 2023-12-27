<?php
include '../db/config.php';

$member = "SELECT * FROM nongsansach.taikhoan WHERE MaPQ='3' ORDER BY MaTK DESC";
$query = mysqli_query($connect, $member);
?>
<?php include './header.php' ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Danh sách khách hàng</h3>
                </div>
                <div class="panel-search">
                    <input type="text" id="myInput" placeholder="Tìm kiếm">
                    <script>
                        $(document).ready(function() {
                            $("#myInput").on("keyup", function() {
                                var value = $(this).val().toLowerCase();
                                $("#table-customer tbody tr").filter(function() {
                                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                });
                            });
                        });
                    </script>
                </div>
                <div class="panel-body"></div>
            </div>
            <div class="table-responsive table-list">
                <table class="table table-bordered table-hover" id="table-customer">
                    <thead>
                        <tr>
                            <th>Mã tài khoản</th>
                            <th>Email khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Tên khách hàng</th>
                            <th>Ngày sinh</th>
                            <th>Ngày tạo</th>
                            <th>PT đăng nhập</th>
                            <th>Trạng thái</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($query as $key => $value) { ?>

                            <tr>
                                <td><?php echo $value['MaTK'] ?></td>
                                <td><?php echo $value['Email'] ?></td>
                                <td><?php echo $value['SDT'] ?></td>
                                <td><?php echo $value['TenKH'] ?></td>
                                <td><?php echo $value['NgaySinh'] ?></td>
                                <td><?php echo $value['NgayTao'] ?></td>
                                <td><?php echo $value['LoaiTK'] ?></td>
                                <td>
                                    <?php
                                    if ($value['TinhTrang'] == 0) {
                                        echo '<p><a class="label label-success" href="status-customer.php?MaTK=' . $value['MaTK'] . '&TinhTrang=1">Đang sử dụng</a></p>';
                                    } else {
                                        echo  '<p><a class="label label-danger" href="status-customer.php?MaTK=' . $value['MaTK'] . '&TinhTrang=0">Vô hiệu hóa</a></p>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include './footer.php' ?>