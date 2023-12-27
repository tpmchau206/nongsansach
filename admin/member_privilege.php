<?php
include '../db/config.php';

use Carbon\Carbon;
use Carbon\CarbonInterval;

require('../carbon/autoload.php');
$now = Carbon::now('Asia/Ho_Chi_Minh');
include './header.php';
if (!empty($_SESSION['current_user'])) {
?>
    <div class="main-content">
        <h1>Phân quyền nhân viên</h1>
        <div id="content-box">
            <?php
            if (
                !empty($_GET['action']) && $_GET['action'] == "save"
            ) {
                $data = $_POST;
                $insertString = "";
                $deleteOldPrivileges = mysqli_query($connect, "DELETE FROM nongsansach.taikhoan_phanquyen WHERE MaTK = " . $data['MaTK']);
                foreach ($data['privileges'] as $insertPrivilege) {
                    $insertString .= !empty($insertString) ? "," : "";
                    $insertString .= "(NULL, " . $data['MaTK'] . ", " . $insertPrivilege . ")";
                }
                $insertPrivilege = mysqli_query($connect, "INSERT INTO nongsansach.taikhoan_phanquyen (`MaTKPQ`, `MaTK`, `MaPQNV`) VALUES " . $insertString);
                if (!$insertPrivilege) {
                    $error = "Phân quyền không thành công. Xin thử lại";
                }
            ?>
                <?php if (!empty($error)) { ?>
                    echo $error;
                <?php } else { ?>
                    Phân quyền thành công. <a href="member_listing.php">Quay lại danh sách nhân viên</a>
                <?php } ?>
            <?php } else { ?>
                <?php
                $privileges = mysqli_query($connect, "SELECT * FROM nongsansach.phanquyen_nhanvien");
                $privileges = mysqli_fetch_all($privileges, MYSQLI_ASSOC);

                $privilegeGroup = mysqli_query($connect, "SELECT * FROM nongsansach.phanquyen_nhom ORDER BY `phanquyen_nhom`.`ThuTuNPQ` ASC");
                $privilegeGroup = mysqli_fetch_all($privilegeGroup, MYSQLI_ASSOC);

                $currentPrivileges = mysqli_query($connect, "SELECT * FROM nongsansach.taikhoan_phanquyen WHERE `MaTK` = " . $_GET['id']);
                $currentPrivileges = mysqli_fetch_all($currentPrivileges, MYSQLI_ASSOC);
                $currentPrivilegeList = array();
                if (!empty($currentPrivileges)) {
                    foreach ($currentPrivileges as $currentPrivilege) {
                        $currentPrivilegeList[] = $currentPrivilege['MaPQNV'];
                    }
                }
                ?>
                <form id="editing-form" method="POST" action="?action=save" enctype="multipart/form-data">
                    <button type="submit" class="btn btn-primary" style="float: right;">Lưu</button>
                    <input type="hidden" name="MaTK" value="<?= $_GET['id'] ?>" />
                    <div class="clear-both"></div>
                    <?php foreach ($privilegeGroup as $group) { ?>
                        
                            <div class="privilege-group">
                                <h3 class="group-name"><?= $group['TenNPQ'] ?></h3>
                                <ul>
                                    <?php foreach ($privileges as $privilege) { ?>
                                        <?php if ($privilege['MaNPQ'] == $group['MaNPQ']) { ?>
                                            <li>
                                                <input type="checkbox" <?php if (in_array($privilege['MaPQNV'], $currentPrivilegeList)) { ?> checked="" <?php } ?> value="<?= $privilege['MaPQNV'] ?>" id="privilege_<?= $privilege['MaPQNV'] ?>" name="privileges[]" />
                                                <label for="privilege_<?= $privilege['MaPQNV'] ?>"><?= $privilege['TenPQNV'] ?></label>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <div class="clear-both"></div>
                                </ul>
                            </div>
                    <?php } ?>
                </form>
            <?php } ?>
        </div>
    </div>

<?php
}
include './footer.php';
?>