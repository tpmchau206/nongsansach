<?php
include '../db/config.php';
$query3 = mysqli_query($connect, "SELECT * FROM nongsansach.phuongxa inner join nongsansach.quanhuyen on quanhuyen.MaQH = phuongxa.MaQH where quanhuyen.TenQH = '".$_POST['district']."' order by `TenPX` ");
$ward = mysqli_fetch_all($query3, 1);
foreach ($ward as $row1) {
?>
    <option value="<?= $row1['TenPX'] ?>"> <?= $row1['TenPX'] ?></option>
<?php
}
?>