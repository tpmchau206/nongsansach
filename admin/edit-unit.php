<?php
include '../db/config.php';
$unit = mysqli_query($connect, "SELECT * FROM nongsansach.donvitinh");


if (isset($_GET['madv'])) {
    $id = $_GET['madv'];

    $data1 = mysqli_query($connect, "SELECT * FROM nongsansach.donvitinh WHERE MaDV = '$_GET[madv]' LIMIT 1");
    $unit_query = mysqli_fetch_assoc($data1);
}

if (isset($_POST['tendv'])) {
    $tendv = $_POST['tendv'];

    $sql3 = "UPDATE nongsansach.donvitinh SET TenDV='$tendv' where MaDV = $id";
    $query3 = mysqli_query($connect, $sql3);
    if ($query3) {
        ?>
        <script>
            window.location.replace("./unit.php");
            alert("<?php echo "Cập nhật thành công" ?>");
        </script>
    <?php
    } else {
    ?>
        <script>
            alert("<?php echo "Cập nhật thất bại" ?>");
        </script>
    <?php
    }
}
?>
<?php include './header.php' ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-info">

                <div class="panel-body">
                    <form action="" method="POST" role="form">
                        <legend>Sửa đơn vị</legend>

                        <div class="form-group">
                            <label for="">Tên đơn vị</label>
                            <input type="text" class="form-control" pattern="[a-zA-Z0-9]+" id="" placeholder="Input field" name="tendv" value="<?php echo $unit_query['TenDV'] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Danh sách đơn vị</h3>
                </div>
            </div>
                <div class="table-list">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Mã đơn vị</th>
                                <th>Tên đơn vị</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($unit as $key => $value) { ?>
                                <tr>
                                    <td><?php echo $key + 1 ?></td>
                                    <td><?php echo $value['TenDV'] ?></td>

                                    <td>
                                        <a href="./edit-unit.php?madv=<?php echo $value['MaDV'] ?>" class="btn btn-outline-success" title="Sửa"><span class="fas fa-edit"></span></a>
                                        <a href="./delete-unit.php?madv=<?php echo $value['MaDV'] ?>" class="btn btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa không')"><span class="fas fa-window-close"></span></a>
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