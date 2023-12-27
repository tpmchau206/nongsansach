<?php
include '../db/config.php';
if (isset($_GET['masp'])) {
    $id = $_GET['masp'];

    $query = mysqli_query($connect, "DELETE FROM nongsansach.sanpham where MaSP=$id");
    if ($query) {
?>
        <script>
            window.location.replace("./product.php");
            alert("<?php echo "Xóa thành công" ?>");
        </script>
    <?php
    } else {
    ?>
        <script>
            alert("<?php echo "Xóa không thành công" ?>");
        </script>
<?php
    }
}
?>