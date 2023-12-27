<?php
include '../db/config.php';
$transport = mysqli_query($connect, "SELECT * FROM nongsansach.vanchuyen");

if (isset($_GET['mavc'])) {
    $id = $_GET['mavc'];

    $data = mysqli_query($connect, "SELECT * FROM nongsansach.vanchuyen WHERE MaVC = '$_GET[mavc]' LIMIT 1");
    $trans = mysqli_fetch_assoc($data);
}

if (isset($_POST['tentp'])) {
    $tentp = $_POST['tentp'];
    $phiship = $_POST['phiship'];

    $sql = "UPDATE nongsansach.vanchuyen SET TenTP='$tentp',Phiship= '$phiship' where MaVC = $id";
    $query = mysqli_query($connect, $sql);
    if ($query) {
        ?>
        <script>
            window.location.replace("./transport.php");
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
        <div class="col-md-4">
            <div class="panel panel-info">

                <div class="panel-body">
                    <form action="" method="POST" role="form" enctype="multipart/form-data">
                        <legend>Sửa vận chuyển</legend>

                        <div class="form-group">
                            <label for="">Tên thành phố</label>
                            <input type="text" class="form-control" pattern="[a-zA-Z0-9]+" id="" placeholder="Input field" name="tentp" value="<?php echo $trans['TenTP'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Phí ship</label>
                            <input type="number" class="form-control" id="" min="1" max="50000" placeholder="Input field" name="phiship" value="<?php echo $trans['Phiship'] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Danh sách vận chuyển</h3>
                </div>
            </div>
            <div class="table-list">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Mã VC</th>
                            <th>Tên thành phố</th>
                            <th>Phí ship</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transport as $key => $value) { ?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td><?php echo $value['TenTP'] ?></td>
                                <td><?php echo $value['Phiship'] ?></td>

                                <td>
                                    <a href="./edit-transport.php?mavc=<?php echo $value['MaVC'] ?>" class="btn btn-outline-success" title="Sửa"><span class="fas fa-edit"></span></a>
                                    <a href="./delete-transport.php?mavc=<?php echo $value['MaVC'] ?>" class="btn btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa không')"><span class="fas fa-window-close"></span></a>
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