<?php
include '../db/config.php';
$product = mysqli_query($connect, "SELECT * FROM nongsansach.sanpham ,nongsansach.danhmuc, nongsansach.donvitinh WHERE nongsansach.sanpham.MaDM = nongsansach.danhmuc.MaDM AND nongsansach.sanpham.MaDV = nongsansach.donvitinh.MaDV ORDER BY MaSP DESC");

?>
<?php include './header.php' ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Danh sách sản phẩm</h3>
                </div>
                <div class="panel-search">
                    <input type="text" id="myInput" placeholder="Tìm kiếm">
                    <script>
                        $(document).ready(function() {
                            $("#myInput").on("keyup", function() {
                                var value = $(this).val().toLowerCase();
                                $("#table-product tbody tr").filter(function() {
                                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                });
                            });
                        });
                    </script>
                </div>
                <div class="panel-body">
                    <a href="./add-product.php" class="btn btn-info">Thêm mới</a>
                </div>
            </div>
            <div class="table-list">
                <table class="table table-bordered table-hover" id="table-product">
                    <thead>
                        <tr>
                            <th>Mã SP</th>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá sản phẩm</th>
                            <th>Mô tả</th>
                            <th>Tên danh mục</th>
                            <th>Tên đơn vị</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($product as $key => $value) : ?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td><?php echo $value['TenSP'] ?></td>
                                <td><img src="data:image/png;base64,<?= $value['AnhSP'] ?>" alt="" width="100"></td>
                                <td><?php echo $value['SoLuong'] ?></td>
                                <td><?php echo number_format($value['GiaSP'], 0, ',', '.') ?>₫</td>
                                <td><?php echo $value['MoTa'] ?></td>
                                <td><?php echo $value['TenDM'] ?></td>
                                <td><?php echo $value['TenDV'] ?></td>

                                <td>
                                    <?php if (checkPrivilege('./edit-product.php?masp=' . $value['MaSP'])) { ?>
                                        <a href="./edit-product.php?masp=<?php echo $value['MaSP'] ?>" class="btn btn-outline-success" title="Sửa"><span class="fas fa-edit"></span></a>
                                    <?php } ?>
                                    <?php if (checkPrivilege('./delete-product.php?masp=' . $value['MaSP'])) { ?>
                                        <a href="./delete-product.php?masp=<?php echo $value['MaSP'] ?>" class="btn btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa không')"><span class="fas fa-window-close"></span></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<?php include './footer.php' ?>