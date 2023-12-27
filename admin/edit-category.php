<?php
include '../db/config.php';
$category = mysqli_query($connect, "SELECT * FROM nongsansach.danhmuc");

if (isset($_GET['madm'])) {
    $id = $_GET['madm'];

    $data = mysqli_query($connect, "SELECT * FROM nongsansach.danhmuc WHERE MaDM = '$_GET[madm]' LIMIT 1");
    $cate = mysqli_fetch_assoc($data);
}

if (isset($_POST['tendm'])) {
    $tendm = $_POST['tendm'];


    // anh danh muc
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $file_name = $file['name'];
        // truong hop nguoi dung khong chon anh
        if (empty($file_name)) {
            $file_name = $cate['HinhDD'];
        } else {
            // truong hop nguoi dung chon anh
            if ($file['type'] == 'image/jpeg' || $file['type'] == 'image/jpg' || $file['type'] == 'image/png') {
                $bin_string1 = file_get_contents($file['tmp_name'], '../uploads/' . $file_name);
                $hex_string1 = base64_encode($bin_string1);
            } else {
                echo '<script>alert("Không đúng định dạng")</script>';
                $file_name = '';
            }
        }
    }
    $sql = "UPDATE nongsansach.danhmuc SET TenDM='$tendm',HinhDD= '$hex_string1' where MaDM = $id";
    $query = mysqli_query($connect, $sql);
    if ($query) {
    ?>
        <script>
            window.location.replace("./category.php");
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
                <!-- <div class="panel-heading">
                    <h3 class="panel-title">Thêm mới</h3>
                </div> -->
                <div class="panel-body">
                    <form action="" method="POST" role="form" enctype="multipart/form-data">
                        <legend>Sửa danh mục</legend>

                        <div class="form-group">
                            <label for="">Tên danh mục</label>
                            <input type="text" class="form-control" pattern="[a-zA-Z0-9]+"  id="" placeholder="Input field" name="tendm" value="<?php echo $cate['TenDM'] ?>"  required>
                        </div>

                        <div class="form-group">
                            <label for="">Hình đại diện</label>
                            <input type="file" class="form-control" id="" placeholder="Input field" name="image" value="<?php echo $cate['HinhDD'] ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Danh sách danh mục</h3>
                </div>
            </div>
                <div class="table-list">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Mã danh mục</th>
                                <th>Tên danh mục</th>
                                <th>Ảnh đại diện</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($category as $key => $value) : ?>
                                <tr>
                                    <td><?php echo $key + 1 ?></td>
                                    <td><?php echo $value['TenDM'] ?></td>
                                    <td><img src="data:image/png;base64,<?php echo $value['HinhDD'] ?>" alt="" width="100"></td>
                                    <td>
                                        <a href="./edit-category.php?madm=<?php echo $value['MaDM'] ?>" class="btn btn-outline-success" title="Sửa"><span class="fas fa-edit"></span></a>
                                        <a href="./delete_category.php?madm=<?php echo $value['MaDM'] ?>" class="btn btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa không')"><span class="fas fa-window-close"></span></a>
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