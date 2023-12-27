<?php
include '../db/config.php';
$unit = mysqli_query($connect, "SELECT * FROM nongsansach.donvitinh");

if (isset($_POST['tendv'])) {
    $tendv = $_POST['tendv'];

    $sql2 = "SELECT * FROM nongsansach.donvitinh WHERE TenDV='$tendv'";
    $query2 = mysqli_query($connect, $sql2);
    $data2 = mysqli_fetch_array($query2);
    $checkdv = mysqli_num_rows($query2);
    if ($tendv == $data2['TenDV']) {
        echo "<script>alert('Tên đơn vị đã tồn tại');window.location='./unit.php'</script>";
        $err['tendv'] = '';
    }
    if (empty($err)) {
        $sql = "INSERT INTO nongsansach.donvitinh(TenDV) VALUES ('$tendv') ";
        $unit_query = mysqli_query($connect, $sql);
        if ($unit_query) {
?>
            <script>
                window.location.replace("./unit.php");
                alert("<?php echo "Thêm mới thành công" ?>");
            </script>
        <?php
        } else {
        ?>
            <script>
                alert("<?php echo "Thêm mới không thành công" ?>");
            </script>
<?php
        }
    }
}
?>
<?php include './header.php' ?>
<div class="container-fluid">
    <div class="row" style="display:flex">
        <div class="col-md-6">
            <div class="panel panel-info">

                <div class="panel-body">
                    <form action="" method="POST" role="form">
                        <legend>Thêm mới đơn vị</legend>

                        <div class="form-group">
                            <label for="">Tên đơn vị</label>
                            <input type="text" class="form-control" pattern="[a-zA-Z0-9]+" id="" placeholder="Input field" name="tendv" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
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
                        <?php foreach ($unit as $key => $value) : ?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td><?php echo $value['TenDV'] ?></td>

                                <td>
                                    <a href="./edit-unit.php?madv=<?php echo $value['MaDV'] ?>" class="btn btn-outline-success" title="Sửa"><span class="fas fa-edit"></span></a>
                                    <a href="./delete-unit.php?madv=<?php echo $value['MaDV'] ?>" class="btn btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa không')"><span class="fas fa-window-close"></span></a>
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