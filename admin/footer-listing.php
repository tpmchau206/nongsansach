<?php
include '../db/config.php';
$footer = mysqli_query($connect, "SELECT * FROM nongsansach.chantrang");


if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $diachi = $_POST['diachi'];
    $sodt = $_POST['sdt'];
    $tenws = $_POST['tenws'];


    $sql = "INSERT INTO nongsansach.chantrang(EmailCT,DiachiCT,SdtCT,TenWS) VALUES ('$email','$diachi','$sodt','$tenws') ";
    $footer_query = mysqli_query($connect, $sql);
    if ($footer_query) {
        header('Location: ./footer-listing.php');
    } else {
        echo 'thêm không thành công';
    }
}

?>
<?php include './header.php' ?>
<div class="container-fluid">
    <div class="row" style="display:flex;">
        <div class="col-md-3">
            <div class="panel panel-info">
                <div class="panel-body">
                    <form action="" method="POST" role="form" enctype="multipart/form-data">
                        <legend>Thêm mới chân trang</legend>

                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" class="form-control" id="" placeholder="Nhập email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                        </div>

                        <div class="form-group">
                            <label for="">Địa chỉ</label>
                            <input type="text" class="form-control" id="" placeholder="Nhập địa chỉ" name="diachi">
                        </div>
                        
                        <div class="form-group">
                            <label for="">Số điện thoại</label>
                            <input type="number" class="form-control" id="" placeholder="Nhập số điện thoại" name="sodt" pattern=".{9,}+((09|03|07|08|05)+([0-9]{8}))">
                        </div>

                        <div class="form-group">
                            <label for="">Tên website</label>
                            <input type="text" class="form-control" id="" placeholder="Nhập tên website của bạn" name="tenws">
                        </div>

                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Danh sách chân trang</h3>
                </div>
            </div>
            <div class="table-list">
                <table class="table table-bordered table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th>Tên website</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($footer as $key => $value) : ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $value['EmailCT'] ?></td>
                                <td><?= $value['DiachiCT'] ?></td>
                                <td><?= $value['SdtCT'] ?></td>
                                <td><?= $value['TenWS'] ?></td>
                                <td>
                                    <a href="./edit-footer.php?mact=<?= $value['MaCT'] ?>" class="btn btn-outline-success" title="Sửa"><span class=" fas fa-edit"></span></a>
                                    <a href="./delete-footer.php?mact=<?= $value['MaCT'] ?>" class="btn btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa không')"><span class=" fas fa-window-close"></span></a>
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