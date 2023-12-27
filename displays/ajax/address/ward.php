<?php
include '../../../db/config.php';
$sql2 = "SELECT * FROM nongsansach.phuongxa inner join nongsansach.quanhuyen on phuongxa.MaQH = quanhuyen.MaQH where TenQH = '" . $_POST['districtid'] . "' order by `TenPX`";
$query2 = mysqli_query($connect, $sql2);
$ward = mysqli_fetch_all($query2, 1);
foreach ($ward as $row) {
?>
    <option value="<?= trim($row['TenPX']) ?>"> <?= trim($row['TenPX']) ?></option>
<?php
}
?>