<?php
include '../db/config.php';
if (isset($_GET['madm'])) {
    $id = $_GET['madm'];

    $query = mysqli_query($connect, "DELETE FROM nongsansach.danhmuc where MaDM=$id");
    if ($query) {
    ?>
        <script>
            window.location.replace("./category.php");
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