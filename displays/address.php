<link rel="stylesheet" href="./css/personalInfo.css">
<link rel="stylesheet" href="./css/cart.css">
<?php
$user = $_SESSION['current_user'];
if (!empty($user)) {
?>
    <section class="manage-info">
        <div class="menu">
            <ul>
            <?php if(!isset($user['MaPQ'])==3 || $user['LoaiTK']== 'Thường'){?>
                <li class="select">
                    <a href="?mod=displays/personalInfo" onclick="openInfo(event,'personInfo')"><i class="fa-solid fa-user"></i> Thông tin cá nhân</a>
                </li>
                <?php } ?>
                <li class="select activeMenu">
                    <a href="?mod=displays/address" onclick="openInfo(event,'address')"><i class="fa-solid fa-location-dot"></i> Địa chỉ</a>
                </li>
                <li class="select">
                    <a href="?mod=displays/purchaseOrder" onclick="openInfo(event,'purchaseOrder')"><i class="fa-solid fa-receipt"></i> Đơn mua</a>
                </li>
                <?php
                if (isset($user['LoaiTK']) == 'Google' || $user['TenKH'] == 'admin') {
                ?>
                    <li class="select">
                        <a href="?mod=displays/changepass" onclick="openInfo(event,'changepass')"><i class="fa-solid fa-user"></i> Đổi mật khẩu</a>
                    </li>
               <?php } ?>
            </ul>
        </div>
        <div class="tabcontent" id="address">
            <div class="box-address">
                <div class="header-address">
                    <h1>Địa chỉ nhận hàng</h1>
                    <button class="btn btn-address">+ Thêm mới địa chỉ</button>
                </div>
                <?php
                $sql = "SELECT * FROM nongsansach.thongtinnguoinhan WHERE MaTK=" . $currentUser['MaTK'];
                $query = mysqli_query($connect, $sql);
                $check = mysqli_num_rows($query);
                if (!empty($check)) {
                ?>
                        <table class="table-address">
                            <?php
                            while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                <tbody>
                                    <tr>
                                        <td colspan="3">
                                            <hr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-1">Họ tên:</td>
                                        <td class="col-2"><?= $row['TenNN'] ?></td>
                                        <td class="col-3"></td>
                                    </tr>
                                    <tr>
                                        <td class="col-1">Số điện thoại:</td>
                                        <td class="col-2"><?= $row['SDTNN'] ?></td>
                                        <td style="display: none;"><?= $row['MaNN'] ?></td>
                                        <td class="col-3">
                                            <form action="" method="POST">
                                                <div class="btnedit fa-solid fa-pen"></div>
                                                <div class="btndelete fa-solid fa-trash-can"></div>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-1">Địa chỉ:</td>
                                        <td class="col-2">
                                            <label for=""><?= $row['SoNha'] ?></label>
                                            <br>
                                            <label for=""><?= $row['DiaChi'] ?></label>
                                        </td>
                                        <td class="col-3"></td>
                                    </tr>

                                </tbody>
                            <?php
                            }
                            ?>
                        </table>
                <?php } else { ?>
                    <div class="notify">
                        <div class="notify-content">
                            <img src="./images/document-empty-icon.png" alt="">
                            <span>Chưa có địa chỉ nhận hàng</span>
                        </div>
                    </div>
                <?php } ?>
                <div id="edit" style="display: none;"></div>
            </div>
        </div>
    </section>
<?php
}
?>
<script src="./js/script2.js"></script>
<script>
    jQuery(document).ready(function() {
        $('.btndelete').click(function(event) {
            text = 'Bạn có muốn xóa địa chỉ này';
            if (confirm(text) == true) {
                event.preventDefault();
                Id = $('#edit').val($(this).closest('tr').find('td:nth-child(3)').text()); //Lấy value cột thứ nhất
                $.ajax({
                    type: 'POST',
                    url: './displays/ajax/address/ajaxAddress.php?action=delete',
                    data: {
                        'id': Id.val()
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status == 0) { //Xóa không thành công
                            alert(response.message);
                        } else { //XÓa thành công
                            alert(response.message);
                        }
                    }
                })
                location.reload();
            } else {}
        })
    })
</script>