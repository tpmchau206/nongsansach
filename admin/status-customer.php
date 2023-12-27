<?php 

include '../db/config.php';

$id=$_GET['MaTK'];
$status=$_GET['TinhTrang'];

$sql ="UPDATE nongsansach.taikhoan set TinhTrang=$status where MaTK=$id";
$query=mysqli_query($connect, $sql);
if ($query) {
    ?>
    <script>
        window.location.replace("customer.php");
        alert("<?php echo "Cập nhật trạng thái thành công" ?>");
    </script>
<?php
} else {
?>
    <script>
        alert("<?php echo "Cập nhật trạng thái thất bại" ?>");
    </script>
<?php
}
?>