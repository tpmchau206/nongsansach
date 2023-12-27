<?php
include '../db/config.php';
$category = mysqli_query($connect, "SELECT * FROM nongsansach.danhmuc");


if (isset($_POST['tendm'])) {
    $tendm = $_POST['tendm'];
   

    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $file_name = $file['name'];
        $bin_string = file_get_contents($file['tmp_name'], '../uploads/' . $file_name);
        $hex_string = base64_encode($bin_string);
    }
    $sql2 = "SELECT * FROM nongsansach.danhmuc WHERE TenDM='$tendm'";
    $query2 = mysqli_query($connect, $sql2);
    $data2 = mysqli_fetch_array($query2);
    $checkdm = mysqli_num_rows($query2);
    if ($tendm == $data2['TenDM']) {
    echo "<script>alert('Tên danh mục đã tồn tại');window.location='./category.php'</script>";
        $err['tendm'] = '';
    }
    if (empty($err)) {
        $sql = "INSERT INTO nongsansach.danhmuc(TenDM,HinhDD) VALUES ('$tendm','$hex_string') ";
        $category_query = mysqli_query($connect, $sql);
        if ($category_query) {
?>
            <script>
                window.location.replace("./category.php");
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
    <div class="row" style="display:flex;">
        <div class="col-md-5">
            <div class="panel panel-info">
                <div class="panel-body">
                    <form action="" method="POST" role="form" enctype="multipart/form-data">
                        <legend>Thêm mới danh mục</legend>
                        <div class="form-group">
                            <label for="">Tên danh mục</label>
                            <input type="text" class="form-control" id="" pattern="[a-zA-Z0-9]+"  placeholder="Input field" name="tendm" required>
                        </div>

                        <div class="form-group">
                            <label for="">Hình đại diện</label>
                            <input type="file" class="form-control" id="" placeholder="Input field" name="image" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Danh sách danh mục</h3>
                </div>
                <div class="panel-search">
                    <input type="text" id="myInput" placeholder="Tìm kiếm">
                    <script>
                        $(document).ready(function() {
                            $("#myInput").on("keyup", function() {
                                var value = $(this).val().toLowerCase();
                                $("#myTable tbody tr").filter(function() {
                                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                });
                            });
                        });
                    </script>
                </div>
            </div>
            <div class="table-list">
                <table class="table table-bordered table-hover" id="myTable">
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
                                    <a href="./edit-category.php?madm=<?php echo $value['MaDM'] ?>" class="btn btn-outline-success" title="Sửa"><span class=" fas fa-edit"></span></a>
                                    <a href="./delete_category.php?madm=<?php echo $value['MaDM'] ?>" class="btn btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa không')"><span class=" fas fa-window-close"></span></a>
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