<?php
include '../db/config.php';
if (isset($_GET['mavc'])) {
    $id = $_GET['mavc'];

    $query = mysqli_query($connect, "DELETE FROM nongsansach.vanchuyen where MaVC=$id");
    if ($query) {
    ?>
        <script>
            window.location.replace("./transport.php");
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