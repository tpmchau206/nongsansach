<?php
include '../db/config.php';
if (isset($_GET['masl'])) {
    $id = $_GET['masl'];

    $query = mysqli_query($connect, "DELETE FROM nongsansach.slide where MaSlide=$id");
    if ($query) {
?>
        <script>
            window.location.replace("./slider.php");
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
