<?php
include '../db/config.php';

if (isset($_GET['masp'])) {
    $id_pro = $_GET['masp'];
    $pro = mysqli_query($connect, "SELECT * FROM nongsansach.sanpham where MaSP =$id_pro");

    $data = mysqli_fetch_assoc($pro);

    // lấy ra ảnh mô tả 
    $img_pro = mysqli_query($connect, "SELECT * FROM nongsansach.thuvienanh where MaSP = $id_pro");
}
$product = mysqli_query($connect, "SELECT * FROM nongsansach.sanpham");
$category = mysqli_query($connect, "SELECT * FROM nongsansach.danhmuc");
$unit = mysqli_query($connect, "SELECT * FROM nongsansach.donvitinh");

if (isset($_GET['masp'])) {
    $id = $_GET['masp'];

    $data_query_sp = mysqli_query($connect, "SELECT * FROM nongsansach.sanpham WHERE MaSP = '$_GET[masp]' LIMIT 1");
    $product_sp = mysqli_fetch_assoc($data_query_sp);
}
if (isset($_POST['tensp'])) {
    $tensp = $_POST['tensp'];
    $soluong = $_POST['soluong'];
    $giasp = $_POST['giasp'];
    $mota = $_POST['mota'];
    $madm = $_POST['madm'];
    $madv = $_POST['madv'];

    if (isset($_FILES['imagesp'])) {
        $file = $_FILES['imagesp'];
        $file_name = $file['name'];
        // truong hop nguoi dung khong chon anh
        if (empty($file_name)) {
            $file_name = $data['AnhSP'];
        } else {
            // truong hop nguoi dung chon anh
            if ($file['type'] == 'image/jpeg' || $file['type'] == 'image/jpg' || $file['type'] == 'image/png') {
                // move_uploaded_file($file['tmp_name'], '../uploads/' . $file_name);
                $bin_string = file_get_contents($file['tmp_name'], '../uploads/' . $file_name);
                $hex_string = base64_encode($bin_string);
            } else {
                echo '<script>alert("Không đúng định dạng")</script>';
                $file_name = '';
            }
        }
    }
    //    anh mo ta
    if (isset($_FILES['imagesps'])) {
        $files = $_FILES['imagesps'];
        $file_names = $files['name'];
        if (!empty($file_names[0])) {
            mysqli_query($connect, "DELETE FROM nongsansach.thuvienanh where MaSP=$id");
            foreach ($file_names as $key => $value) {
                // move_uploaded_file($files['tmp_name'][$key], '../uploads/' . $value);
                $bin_string1 = file_get_contents($files['tmp_name'][$key], '../uploads/' . $value);
                $hex_string1 = base64_encode($bin_string1);

                mysqli_query($connect, "INSERT INTO nongsansach.thuvienanh (`MaSP`,`AnhTV`) values ('$id','$hex_string1')");
            }
        }
    }
    $sql_them = "UPDATE nongsansach.sanpham SET  TenSP='$tensp', AnhSP='$hex_string', SoLuong='$soluong', GiaSP='$giasp', MoTa='$mota', MaDM='$madm', MaDV='$madv' where MaSP = $id_pro";
    $product_query = mysqli_query($connect, $sql_them);
    if ($product_query) {
?>
        <script>
            window.location.replace("./product.php");
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
        <div class="col-md-12">
            <div class="panel-info">
                <div class="table-list">
                    <div class="panel-body">
                        <form action="" method="POST" role="form" enctype="multipart/form-data">
                            <legend>Sửa sản phẩm</legend>

                            <div class="form-group">
                                <label for="">Tên sản phẩm</label>
                                <input type="text" class="form-control" id="" pattern="^[a-zA-Z0-9]+$" placeholder="Input field" name="tensp" value="<?php echo $data['TenSP'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Ảnh sản phẩm</label>
                                <input type="file" class="form-control" id="" placeholder="Input field" name="imagesp" required>
                                <img src="data:image/png;base64,<?= $data['AnhSP'] ?>" alt="" width="100">
                            </div>
                            .
                            <div class="form-group">
                                <label for="">Ảnh mô tả</label>
                                <input type="file" class="form-control" id="" placeholder="Input field" name="imagesps[]" multiple>
                                <div class="row">
                                    <?php foreach ($img_pro as $key => $value) { ?>
                                        <div class="col-md-4">
                                            <a href="" class="thmbnail">
                                                <img src="data:image/png;base64,<?= $value['AnhTV'] ?>" alt="" style="max-height: 100px">
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="">Số lượng</label>
                                <input type="number" class="form-control" id="" min="1" max="1000" placeholder="Input field" name="soluong" value="<?php echo $data['SoLuong'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Giá sản phẩm</label>
                                <input type="number" class="form-control" id="" placeholder="Input field" min="1" max="300000" name="giasp" value="<?php echo $data['GiaSP'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Mô tả</label>
                                <textarea name="mota" class="form-control" rows="3" required><?php echo $data['MoTa'] ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="">Tên danh mục</label>
                                <select class="form-control" name="madm" required="required" value="<?php echo $data['TenDM'] ?>">
                                    <?php
                                    foreach ($category as $key => $value) {
                                    ?>
                                        <option value="<?php echo $value['MaDM'] ?>" <?php echo (($value['MaDM'] == $data['MaDM']) ? 'selected' : '') ?>>
                                            <?php echo $value['TenDM'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Tên đơn vị</label>
                                <select class="form-control" name="madv" required="required" value="<?php echo $data['TenDV'] ?>">
                                    <?php
                                    foreach ($unit as $key => $value) {
                                    ?>
                                        <option value="<?php echo $value['MaDV'] ?>" <?php echo (($value['MaDV'] == $data['MaDV']) ? 'selected' : '') ?>>
                                            <?php echo $value['TenDV'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php include './footer.php' ?>