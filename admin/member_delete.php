<?php
include '../db/config.php';
include './header.php';
if (!empty($_SESSION['current_user'])) {
    ?>
    <div class="main-content">
        <h1>Xóa nhân viên</h1>
        <div id="content-box">
            <?php
            $error = false;
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $result = mysqli_query($connect, "DELETE FROM nongsansach.taikhoan WHERE `MaTK` = " . $_GET['id']);
                if (!$result) {
                    $error = "Không thể xóa nhân viên.";
                }
                mysqli_close($connect);
                if ($error !== false) {
                    ?>
                    <div id="error-notify" class="box-content">
                        <h2>Thông báo</h2>
                        <h4><?= $error ?></h4>
                        <a href="./member_listing.php">Danh sách nhân viên</a>
                    </div>
        <?php } else { ?>
                    <div id="success-notify" class="box-content">
                        <h2>Xóa nhân viên thành công</h2>
                        <a href="./member_listing.php">Danh sách nhân viên</a>
                    </div>
                <?php } ?>
    <?php } ?>
        </div>
    </div>
    <?php
}
include './footer.php';
?>