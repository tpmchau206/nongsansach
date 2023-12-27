<?php
include '../db/config.php';
if (isset($_GET['madv'])) {
    $id = $_GET['madv'];

    $query = mysqli_query($connect, "DELETE FROM nongsansach.donvitinh where MaDV=$id");
    if ($query) {
?>
        <script>
            window.location.replace("./unit.php");
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