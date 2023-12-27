<?php
if (isset($_POST['changepass'])) {
    $user_id = $_POST['user_id'];
    $old_pass = md5($_POST['passcu']);
    $new_pass = md5($_POST['new_pass']);
    $re_pass = md5($_POST['re_pass']);
    $password_query = mysqli_query($connect, "SELECT * FROM nongsansach.taikhoan where MaTK= '" . $user_id . "'");
    $password_row = mysqli_fetch_assoc($password_query);
    if ($password_row['Pass'] == $old_pass) {
        if ($new_pass == $re_pass) {
            if ($password_row['Pass'] != $new_pass) {
                $update_pwd = mysqli_query($connect, "UPDATE nongsansach.taikhoan set Pass='" . $new_pass . "' WHERE (MaTK = " . $user_id . " AND  Pass='" . $old_pass . "')");
                echo "<script>alert('Đổi mật khẩu thành công'); window.location='index.php'</script>";
            } else {
                echo "<script>alert('Mật khẩu cũ với mật khẩu mới của bạn bị trùng');window.location='index.php'</script>";
            }
        } else {
            echo "<script>alert('Mật khẩu mới và nhập lại của bạn không khớp'); window.location='index.php'</script>";
        }
    } else {
        echo "<script>alert('Mật khẩu cũ của bạn sai');window.location='index.php'</script>";
    }
}

?>
<?php
$user = $_SESSION['current_user'];
if (!empty($user)) {
?>
    <link rel="stylesheet" href="./css/personalInfo.css">

    <section class="manage-info">
        <div class="menu">
            <ul>
            <?php if(!isset($user['MaPQ'])==3 || $user['LoaiTK']== 'Thường'){?>
                <li class="select ">
                    <a href="?mod=displays/personalInfo" onclick="openInfo(event,'personInfo')"><i class="fa-solid fa-user"></i> Thông tin cá nhân</a>
                </li>
                <?php } ?>
                <li class="select">
                    <a href="?mod=displays/address" onclick="openInfo(event,'address')"><i class="fa-solid fa-location-dot"></i> Địa chỉ</a>
                </li>
                <li class="select">
                    <a href="?mod=displays/purchaseOrder" onclick="openInfo(event,'purchaseOrder')"><i class="fa-solid fa-receipt"></i> Đơn mua</a>
                </li>
                <?php
                if (isset($user['LoaiTK']) == 'Google' || $user['TenKH'] == 'admin') {
                ?>
                    <li class="select activeMenu">
                        <a href="?mod=displays/changepass" onclick="openInfo(event,'changepass')"><i class="fa-solid fa-user"></i> Đổi mật khẩu</a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <form class="tabcontent" id="changepass" method="POST" action="">
            <div class="box-info">
                <h1>Đổi Mật Khẩu</h1>
                <span style="font-size: 16px;color:#aaa">Để bảo mật tài khoản, vui lòng không chia sẻ mật khẩu cho người khác</span>
                <hr>
                <table class="table-info">
                    <input type="hidden" name="user_id" value="<?= $user['MaTK'] ?>">
                    <tr>
                        <td class="col-1">Mật khẩu cũ:</td>
                        <td class="col-2"><input type="password" name="passcu" value="" placeholder="Mật khẩu cũ" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required></td>
                    </tr>
                    <tr>
                        <td class="col-1">Mật khẩu mới:</td>
                        <td class="col-2"><input type="password" name="new_pass" value="" placeholder="Mật khẩu mới" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required></td>
                    </tr>
                    <tr>
                        <td class="col-1">Nhập lại mật khẩu:</td>
                        <td class="col-2"><input type="password" name="re_pass" value="" placeholder="Nhập lại mật khẩu" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required></td>
                    </tr>


                </table>
                <button type="submit" name="changepass" class="btn">Xác Nhận</button>
        </form>
        </div>
    </section>
<?php
}
?>
</body>

</html>