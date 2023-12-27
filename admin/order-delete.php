<?php
include '../db/config.php';
if (isset($_GET['madh'])) {
    $id = $_GET['madh'];

    $query = mysqli_query($connect, "DELETE FROM nongsansach.donhang where MaDH=$id");
    if ($query) {
?>
        <script>
            window.location.replace("./order.php");
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