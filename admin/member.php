<?php
include '../db/config.php';

$member = mysqli_query($connect, "SELECT * FROM nongsansach.taikhoan WHERE MaPQ='2' ORDER BY MaTK DESC ");
?>
<?php include './header.php' ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Danh sách khách hàng</h3>
                </div>
                <div class="panel-body"></div>
            </div>
            <div class="table-responsive table-list">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Mã TK</th>
                            <th>Email</th>
                            <th>Tên khách hàng</th>
                            <th>Đăng nhập</th>
                            <th>Ngày sinh</th>
                            <th>Số điện thoại</th>
                            <th>Giới tính</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($member as $key => $value) { ?>
                            <tr>
                                <td><?php echo $value['MaTK'] ?></td>
                                <td><?php echo $value['Email'] ?></td>
                                <td><?php echo $value['TenKH'] ?></td>
                                <td><?php echo $value['TypeTK'] ?></td>
                                <td><?php echo $value['NgaySinh'] ?></td>
                                <td><?php echo $value['SDT'] ?></td>
                                <td><?php echo $value['GioiTinh'] ?></td>
                                <td><?php echo $value['NgayTao'] ?></td>
                                <td><?php echo $value['TrangThai'] ?></td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</div>
<?php include './footer.php' ?>