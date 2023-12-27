<?php 
    include '../db/config.php';
    $query2 = mysqli_query($connect, "SELECT * FROM nongsansach.quanhuyen inner join nongsansach.tinhthanh on tinhthanh.MaTT = quanhuyen.MaTT where tinhthanh.TenTT = '".$_POST['province']."' order by `TenQH` ");
    $district = mysqli_fetch_all($query2, 1);
    foreach ($district as $row) {
    ?>
        <option value="<?= $row['TenQH'] ?>"><?= $row['TenQH'] ?></option>
    <?php
    }
    ?>