<?php
include '../../../db/config.php';
$sql2 = "SELECT * FROM nongsansach.quanhuyen inner join nongsansach.tinhthanh on tinhthanh.MaTT = quanhuyen.MaTT where TenTT = '" . $_POST['provinceid'] . "' order by `TenQH`";
$query2 = mysqli_query($connect, $sql2);
$district = mysqli_fetch_all($query2, 1);
foreach ($district as $row) {
?>
    <option onclick="openTransfer(event,'ward')" value="<?= trim($row['TenQH']) ?>"><?= trim($row['TenQH']) ?></option>
<?php
}
?>