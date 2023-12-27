<?php
if (isset($_SESSION['current_user'])) {
    $currentuser = $_SESSION['current_user'];
?>

    <link rel="stylesheet" href="./css/personalInfo.css">
    <link rel="stylesheet" href="./css/cart.css">
    <?php
    $user = $_SESSION['current_user'];
    if (!empty($user)) {
    ?>
        <section class="manage-info">
            <div class="menu">
                <ul>
                    <?php if (!isset($user['MaPQ']) == 3 || $user['LoaiTK'] == 'Thường') { ?>
                        <li class="select">
                            <a href="?mod=displays/personalInfo" onclick="openInfo(event,'personInfo')"><i class="fa-solid fa-user"></i> Thông tin cá nhân</a>
                        </li>
                    <?php } ?>
                    <li class="select">
                        <a href="?mod=displays/address" onclick="openInfo(event,'address')"><i class="fa-solid fa-location-dot"></i> Địa chỉ</a>
                    </li>
                    <li class="select activeMenu">
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
            <?php
            $sqlPurchase = mysqli_query($connect, "SELECT * FROM nongsansach.donhang WHERE MaDH=" . $_GET['id']);
            $detail = mysqli_fetch_assoc($sqlPurchase);
            $arr = explode(',', $detail['DuLieu']);
            ?>
            <div class="tabcontent">
                <div class="tab-purchase" style="display: block;">
                    <div class="header-detail">
                        <div class="header-left" onclick="history.back()">
                            <span class="icon-back"></span>
                            <span>Trở Lại</span>
                        </div>
                        <div class="header-right">
                            <span>Mã Đơn Hàng: <?= $detail['MaDH'] ?></span>|
                            <span class="status">
                                <?php if ($detail['TrangThai'] == 0) {
                                    echo 'Chờ xác nhận';
                                } elseif ($detail['TrangThai'] == 1) {
                                    echo  'Đang giao';
                                } elseif ($detail['TrangThai'] == 2) {
                                    echo 'Đã giao';
                                } elseif ($detail['TrangThai'] == 3) {
                                    echo 'Đã hủy';
                                } ?>
                            </span>
                        </div>
                    </div>
                    <div class="line-title"></div>
                    <div class="delivery-address flex123">
                        <div class="address">
                            <h3>Địa chỉ nhận hàng</h3>
                            <div><?= $arr[0] ?></div>
                            <div><?= $arr[1] ?></div>
                            <div><?= $arr[2] ?>, <?= $arr[3] ?>, <?= $arr[4] ?>, <?= $arr[5] ?></div>
                        </div>
                        <div class="action">
                            <?php if ($detail['TrangThai'] == 3) {
                            } else {
                            ?>
                                <button type="button" class="btn btncancel" onclick="cancel_purchase(<?= $detail['MaDH'] ?>)">Hủy đơn hàng</button>
                            <?php
                            } ?>
                        </div>
                    </div>
                    <div class="box-purchase">
                        <?php
                        $total = 0;
                        $queryDetail = mysqli_query($connect, "SELECT * FROM nongsansach.chitietdonhang INNER JOIN nongsansach.sanpham on chitietdonhang.MaSP=sanpham.MaSP where `MaDH` = '" . $_GET['id'] . "'");
                        while ($rowDetail = mysqli_fetch_assoc($queryDetail)) {
                        ?>
                            <div class="product-purchase">
                                <div class="product-purchase2">
                                    <div class="product-img">
                                        <img src="data:image/png;base64,<?= $rowDetail['AnhSP'] ?>" alt="">
                                    </div>
                                    <div class="product-content">
                                        <div class="product-name"><span><?= $rowDetail['TenSP'] ?></span></div>
                                        <div class="quantity">x<?= $rowDetail['SoLuongMua'] ?></div>
                                    </div>
                                </div>
                                <div class="total-money">
                                    <div class="price">
                                        <span> <?= number_format($rowDetail['GiaSPMua'], 0, ',', '.') ?>₫</span>
                                    </div>
                                </div>
                            </div>
                        <?php
                            $total += $rowDetail['GiaSPMua'] * $rowDetail['SoLuongMua'];
                        }
                        ?>
                    </div>
                    <div class="footer-detail">
                        <div class="total-payment box">
                            <div class="title-payment">
                                <div class="grid-payment">
                                    <?php
                                    ?>
                                    <div class="ab bc1 cd">Tổng tiền hàng:</div>
                                    <div class="ab bc1 de"><?= number_format($total, 0, ',', '.') ?>₫</div>
                                    <div class="ab bc2 cd">Phí Vận chuyển:</div>
                                    <div class="ab bc2 de"><?= number_format($arr[6], 0, ',', '.') ?>₫</div>
                                    <?php
                                    $tong = $total + $arr[6];
                                    ?>
                                    <div class="ab bc3 cd">Tổng thanh toán:</div>
                                    <div class="ab bc3 de total-price"><?= number_format($tong, 0, ',', '.') ?>đ</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php
    }
    ?>
<?php
}
?>