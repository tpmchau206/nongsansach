<?php
include '../db/config.php';
$slider = mysqli_query($connect, "SELECT * FROM nongsansach.slide");

if (isset($_POST['tensl'])) {
    $tensl = $_POST['tensl'];
    $noidung = $_POST['noidung'];
    $noidung1 = $_POST['noidung1'];

    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $file_name = $file['name'];
        $bin_string = file_get_contents($file['tmp_name'], '../uploads/' . $file_name);
        $hex_string = base64_encode($bin_string);
    }
    $sql2 = "SELECT * FROM nongsansach.slide WHERE TenSlide='$tensl'";
    $query2 = mysqli_query($connect, $sql2);
    $data2 = mysqli_fetch_array($query2);
    $checksl = mysqli_num_rows($query2);
    if ($tensl == $data2['TenSlide']) {
        echo "<script>alert('Tên slide đã tồn tại');window.location='./slider.php'</script>";
        $err['tensl'] = '';
    }
    if (empty($err)) {
        $sql = "INSERT INTO nongsansach.slide(TenSlide, HinhSlide, NoiDung, NoiDungTT) VALUES ('$tensl','$hex_string','$noidung','$noidung1')";
        $slide_query = mysqli_query($connect, $sql);
        if ($slide_query) {
?>
            <script>
                window.location.replace("./slider.php");
                alert("<?php echo "Thêm thành công" ?>");
            </script>
        <?php
        } else {
        ?>
            <script>
                alert("<?php echo "Thêm không thành công" ?>");
            </script>
<?php
        }
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
                        <legend>Thêm mới slide</legend>

                        <div class="form-group">
                            <label for="">Tên slide</label>
                            <input type="text" class="form-control"  pattern="[a-zA-Z0-9]+" id="" placeholder="Input field" name="tensl" required>
                        </div>

                        <div class="form-group">
                            <label for="">Hình slide</label>
                            <input type="file" class="form-control" id="" placeholder="Input field" name="image" required>
                        </div>

                        <div class="form-group">
                            <label for="">Nội dung</label>
                            <textarea name="noidung" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Nội dung tiếp theo</label>
                            <textarea name="noidung1" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
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
                        <?php foreach ($slider as $key => $value) : ?>
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
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include './footer.php' ?>