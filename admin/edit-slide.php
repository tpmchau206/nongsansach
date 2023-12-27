<?php
include '../db/config.php';
$slider = mysqli_query($connect, "SELECT * FROM nongsansach.slide");

if (isset($_GET['masl'])) {
    $id = $_GET['masl'];

    $data = mysqli_query($connect, "SELECT * FROM nongsansach.slide WHERE MaSlide = '$_GET[masl]' LIMIT 1");
    $sli = mysqli_fetch_assoc($data);
}

if (isset($_POST['tensl'])) {
    $tensl = $_POST['tensl'];
    $noidung = $_POST['noidung'];
    $noidung1 = $_POST['noidung1'];



    // anh danh muc
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $file_name = $file['name'];
        // truong hop nguoi dung khong chon anh
        if (empty($file_name)) {
            $file_name = $sli['HinhSlide'];
        } else {
            // truong hop nguoi dung chon anh
            if ($file['type'] == 'image/jpeg' || $file['type'] == 'image/jpg' || $file['type'] == 'image/png') {
                // move_uploaded_file($file['tmp_name'], '../uploads/' . $file_name);
                $bin_string1 = file_get_contents($file['tmp_name'], '../uploads/' . $file_name);
                $hex_string1 = base64_encode($bin_string1);
            } else {
                echo '<script>alert("Không đúng định dạng")</script>';
                $file_name = '';
            }
        }
    }

    $sql = "UPDATE nongsansach.slide SET TenSlide='$tensl',HinhSlide= '$hex_string1', NoiDung= '$noidung', NoiDungTT = '$noidung1' where MaSlide = $id";
    $query = mysqli_query($connect, $sql);
    if ($query) {
        ?>
        <script>
            window.location.replace("./slider.php");
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
                        <legend>Sửa slide</legend>

                        <div class="form-group">
                            <label for="">Tên slide</label>
                            <input type="text" class="form-control" id="" pattern="[a-zA-Z0-9]+" placeholder="Input field" name="tensl" value="<?php echo $sli['TenSlide'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="">Hình slide</label>
                            <input type="file" class="form-control" id="" placeholder="Input field" name="image" value="<?php echo $sli['HinhSlide'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="">Nội dung</label>
                            <textarea name="noidung" class="form-control" rows="3" value="<?php echo $sli['NoiDung'] ?>" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Nhập nội dung tiếp theo</label>
                            <textarea name="noidung1" class="form-control" rows="3" value="<?php echo $sli['NoiDungTT'] ?>" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Danh sách slide</h3>
                </div>
            </div>
            <div class="table-list">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Mã slide</th>
                            <th>Tên slide</th>
                            <th>Hình slide</th>
                            <th>Nội dung</th>
                            <th>Nội dung tiếp theo</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($slider as $key => $value) { ?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td><?php echo $value['TenSlide'] ?></td>
                                <td><img src="data:image/png;base64,<?php echo $value['HinhSlide'] ?>" alt="" width="100"></td>
                                <td><?php echo $value['NoiDung'] ?></td>
                                <td><?php echo $value['NoiDungTT'] ?></td>

                                <td>
                                    <a href="./edit-slide.php?masl=<?php echo $value['MaSlide'] ?>" class="btn btn-outline-success" title="Sửa"><span class="fas fa-edit"></span></a>
                                    <a href="./delete-slide.php?masl=<?php echo $value['MaSlide'] ?>" class="btn btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa không')"><span class="fas fa-window-close"></span></a>
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