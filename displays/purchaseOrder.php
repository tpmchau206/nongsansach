<?php
if (isset($_SESSION['current_user'])) {
   $currentuser = $_SESSION['current_user'];
?>

   <link rel="stylesheet" href="./css/personalInfo.css">
   <?php
   $user = $_SESSION['current_user'];
   if (!empty($user)) {
   ?>
      <section class="manage-info">
         <div class="menu">
            <ul>
               <?php if (!isset($user['MaPQ']) == 3 || $user['LoaiTK'] == 'Thường') { ?>
                  <li class="select ">
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

         <div class="tabcontent">
            <div class="head-tabs-purchase">
               <?php
               $queryCheck1 = mysqli_query($connect, "SELECT * FROM nongsansach.donhang where `MaTK` = '" . $user['MaTK'] . "'");
               $queryCheck2 = mysqli_query($connect, "SELECT * FROM nongsansach.donhang where `MaTK` = '" . $user['MaTK'] . "' AND TrangThai=0");
               $queryCheck3 = mysqli_query($connect, "SELECT * FROM nongsansach.donhang where `MaTK` = '" . $user['MaTK'] . "' AND TrangThai=1");
               $queryCheck4 = mysqli_query($connect, "SELECT * FROM nongsansach.donhang where `MaTK` = '" . $user['MaTK'] . "' AND TrangThai=2");
               $queryCheck5 = mysqli_query($connect, "SELECT * FROM nongsansach.donhang where `MaTK` = '" . $user['MaTK'] . "' AND TrangThai=3");

               $numberPurchase1 = mysqli_num_rows($queryCheck1);
               $numberPurchase2 = mysqli_num_rows($queryCheck2);
               $numberPurchase3 = mysqli_num_rows($queryCheck3);
               $numberPurchase4 = mysqli_num_rows($queryCheck4);
               $numberPurchase5 = mysqli_num_rows($queryCheck5);
               ?>
               <a class="tab-link" id="defaultOpen" onclick="openPurchase(event,'all')">Tất cả <?= $numberPurchase1 ? '(' . $numberPurchase1 . ')' : '' ?></a>
               <a class="tab-link" onclick="openPurchase(event,'wai-conf')">Chờ xác nhận <?= $numberPurchase2 > 0 ? '(' . $numberPurchase2 . ')' : '' ?></a>
               <a class="tab-link" onclick="openPurchase(event,'delivering')">Đang giao <?= $numberPurchase3 > 0 ? '(' . $numberPurchase3 . ')' : '' ?></a>
               <a class="tab-link" onclick="openPurchase(event,'delivered')">Đã giao <?= $numberPurchase4 > 0 ? '(' . $numberPurchase4 . ')' : '' ?></a>
               <a class="tab-link" onclick="openPurchase(event,'cancelled')">Đã hủy <?= $numberPurchase5 > 0 ? '(' . $numberPurchase5 . ')' : '' ?></a>
            </div>
            <!-- tất cả đơn hàng -->
            <div class="tab-purchase" id="all">
               <?php
               $check1 = mysqli_num_rows($queryCheck1);
               if ($check1 > 0) {
               ?>
                  <?php
                  $queryPurchase = mysqli_query($connect, "SELECT * FROM nongsansach.donhang where `MaTK` = '" . $user['MaTK'] . "' ORDER BY `donhang`.`NgayDatHang` DESC");
                  while ($row = mysqli_fetch_assoc($queryPurchase)) {
                  ?>
                     <div class="box-purchase">
                        <div class="header-purchase">
                           <p><a href="?mod=displays/purchaseDetail&id=<?= $row['MaDH'] ?>">Mã Đơn hàng: <?= $row['MaDH'] ?></a></p>
                           <?php if ($row['TrangThai'] == 0) { ?>
                              <p class="total-status">Chờ xác nhận</p>
                           <?php } elseif ($row['TrangThai'] == 1) { ?>
                              <p class="total-status">Đang giao</p>
                           <?php } elseif ($row['TrangThai'] == 2) { ?>
                              <p class="total-status">Đã giao</p>
                           <?php } elseif ($row['TrangThai'] == 3) { ?>
                              <p class="total-status">Đã hủy</p>
                           <?php } ?>
                        </div>
                        <?php
                        $queryDetail = mysqli_query($connect, "SELECT * FROM nongsansach.chitietdonhang INNER JOIN nongsansach.sanpham on chitietdonhang.MaSP=sanpham.MaSP where `MaDH` = '" . $row['MaDH'] . "'");
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
                                    <span><?= number_format($rowDetail['GiaSPMua'], 0, ',', '.') ?>₫</span>
                                 </div>
                              </div>
                           </div>
                        <?php
                        }
                        ?>
                        <div class="f-purchase1">
                           <div class="total-purchase">
                              Thành tiền:
                              <span class="total"><?= number_format($row['ThanhTien'], 0, ',', '.') ?>₫</span>
                           </div>
                        </div>
                        <div class="f-purchase2">
                           <div class="date-buys">
                              Ngày đặt hàng: <?= date_format(date_create($row['NgayDatHang']), "H:i:s d-m-Y"); ?>
                           </div>
                           <?php
                           if ($row['TrangThai'] == 0) {
                           ?>
                              <div class="cancel">
                                 <button type="button" class="btncancel" onclick="cancel_purchase(<?= $row['MaDH'] ?>)">Hủy đơn hàng</button>
                              </div>
                           <?php
                           }
                           ?>
                        </div>
                     </div>
                  <?php
                  }
               } else {
                  ?>
                  <div class="notify">
                     <div class="notify-content">
                        <img src="images/chuacodon.jpg" alt="">
                        <span>Chưa có đơn hàng</span>
                     </div>
                  </div>
               <?php
               }
               ?>
            </div>
            <!-- đơn hàng chờ xác nhận -->
            <div class="tab-purchase" id="wai-conf">
               <?php
               // $queryCheck = mysqli_query($connect, "SELECT * FROM nongsansach.donhang where `MaTK` = '" . $user['MaTK'] . "' AND TrangThai=0");
               $check1 = mysqli_num_rows($queryCheck2);
               if ($check1 > 0) {
               ?>
                  <?php
                  $queryPurchase = mysqli_query($connect, "SELECT * FROM nongsansach.donhang where `MaTK` = '" . $user['MaTK'] . "' AND TrangThai=0 ORDER BY `donhang`.`NgayDatHang` DESC");
                  while ($row = mysqli_fetch_assoc($queryPurchase)) {
                  ?>
                     <div class="box-purchase">
                        <div class="header-purchase">
                           <p><a href="?mod=displays/purchaseDetail&id=<?= $row['MaDH'] ?>">Mã Đơn hàng: <?= $row['MaDH'] ?></a></p>
                           <?php if ($row['TrangThai'] == 0) { ?>
                              <p class="total-status">Chờ xác nhận</p>
                           <?php } elseif ($row['TrangThai'] == 1) { ?>
                              <p class="total-status">Đang giao</p>
                           <?php } elseif ($row['TrangThai'] == 2) { ?>
                              <p class="total-status">Đã giao</p>
                           <?php } elseif ($row['TrangThai'] == 3) { ?>
                              <p class="total-status">Đã hủy</p>
                           <?php } ?>
                        </div>
                        <?php
                        $queryDetail = mysqli_query($connect, "SELECT * FROM nongsansach.chitietdonhang INNER JOIN nongsansach.sanpham on chitietdonhang.MaSP=sanpham.MaSP where `MaDH` = '" . $row['MaDH'] . "'");
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
                                    <span><?= number_format($rowDetail['GiaSPMua'], 0, ',', '.') ?>₫</span>
                                 </div>
                              </div>
                           </div>
                        <?php
                        }
                        $totalItem = 0;
                        $totalItem += $rowDetail
                        ?>
                        <div class="f-purchase1">
                           <div class="total-purchase">
                              Thành tiền:
                              <span class="total"><?= number_format($row['ThanhTien'], 0, ',', '.') ?>₫</span>
                           </div>
                        </div>
                        <div class="f-purchase2">
                           <div class="date-buys">
                              Ngày đặt hàng: <?= date_format(date_create($row['NgayDatHang']), "H:i:s d-m-Y"); ?>
                           </div>
                           <?php
                           if ($row['TrangThai'] == 0) {
                           ?>
                              <div class="cancel">
                                 <button type="button" class="btncancel" onclick="cancel_purchase(<?= $row['MaDH'] ?>)">Hủy đơn hàng</button>
                              </div>
                           <?php
                           }
                           ?>
                        </div>
                     </div>
                  <?php
                  }
               } else {
                  ?>
                  <div class="notify">
                     <div class="notify-content">
                        <img src="images/chuacodon.jpg" alt="">
                        <span>Chưa có đơn hàng</span>
                     </div>
                  </div>
               <?php
               }
               ?>
            </div>
            <!-- đơn hàng đang giao -->
            <div class="tab-purchase" id="delivering">
               <?php
               // $queryCheck = mysqli_query($connect, "SELECT * FROM nongsansach.donhang where `MaTK` = '" . $user['MaTK'] . "' AND TrangThai=1");
               $check1 = mysqli_num_rows($queryCheck3);
               if ($check1 > 0) {
               ?>
                  <?php
                  $queryPurchase = mysqli_query($connect, "SELECT * FROM nongsansach.donhang where `MaTK` = '" . $user['MaTK'] . "' AND TrangThai=1 ORDER BY `donhang`.`NgayDatHang` DESC");
                  while ($row = mysqli_fetch_assoc($queryPurchase)) {
                  ?>
                     <div class="box-purchase">
                        <div class="header-purchase">
                           <p><a href="?mod=displays/purchaseDetail&id=<?= $row['MaDH'] ?>">Mã Đơn hàng: <?= $row['MaDH'] ?></a></p>
                           <?php if ($row['TrangThai'] == 0) { ?>
                              <p class="total-status">Chờ xác nhận</p>
                           <?php } elseif ($row['TrangThai'] == 1) { ?>
                              <p class="total-status">Đang giao</p>
                           <?php } elseif ($row['TrangThai'] == 2) { ?>
                              <p class="total-status">Đã giao</p>
                           <?php } elseif ($row['TrangThai'] == 3) { ?>
                              <p class="total-status">Đã hủy</p>
                           <?php } ?>
                        </div>
                        <?php
                        $queryDetail = mysqli_query($connect, "SELECT * FROM nongsansach.chitietdonhang INNER JOIN nongsansach.sanpham on chitietdonhang.MaSP=sanpham.MaSP where `MaDH` = '" . $row['MaDH'] . "'");
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
                                    <span><?= number_format($rowDetail['GiaSPMua'], 0, ',', '.') ?>₫</span>
                                 </div>
                              </div>
                           </div>
                        <?php
                        }
                        ?>
                        <div class="f-purchase1">
                           <div class="total-purchase">
                              Thành tiền:
                              <span class="total"><?= number_format($row['ThanhTien'], 0, ',', '.') ?>₫</span>
                           </div>
                        </div>
                        <div class="f-purchase2">
                           <div class="date-buys">
                              Ngày đặt hàng: <?= date_format(date_create($row['NgayDatHang']), "H:i:s d-m-Y"); ?>
                           </div>
                           <?php
                           if ($row['TrangThai'] == 0) {
                           ?>
                              <div class="cancel">
                                 <button type="button" class="btncancel" onclick="cancel_purchase(<?= $row['MaDH'] ?>)">Hủy đơn hàng</button>
                              </div>
                           <?php
                           }
                           ?>
                        </div>
                     </div>
                  <?php
                  }
               } else {
                  ?>
                  <div class="notify">
                     <div class="notify-content">
                        <img src="images/chuacodon.jpg" alt="">
                        <span>Chưa có đơn hàng</span>
                     </div>
                  </div>
               <?php
               }
               ?>
            </div>
            <!-- đơn hàng đã giao -->
            <div class="tab-purchase" id="delivered">
               <?php
               $check1 = mysqli_num_rows($queryCheck4);
               if ($check1 > 0) {
               ?>
                  <?php
                  $queryPurchase = mysqli_query($connect, "SELECT * FROM nongsansach.donhang where `MaTK` = '" . $user['MaTK'] . "' AND TrangThai=2 ORDER BY `donhang`.`NgayDatHang` DESC");
                  while ($row = mysqli_fetch_assoc($queryPurchase)) {
                  ?>
                     <div class="box-purchase">
                        <div class="header-purchase">
                           <p><a href="?mod=displays/purchaseDetail&id=<?= $row['MaDH'] ?>">Mã Đơn hàng: <?= $row['MaDH'] ?></a></p>
                           <?php if ($row['TrangThai'] == 0) { ?>
                              <p class="total-status">Chờ xác nhận</p>
                           <?php } elseif ($row['TrangThai'] == 1) { ?>
                              <p class="total-status">Đang giao</p>
                           <?php } elseif ($row['TrangThai'] == 2) { ?>
                              <p class="total-status">Đã giao</p>
                           <?php } elseif ($row['TrangThai'] == 3) { ?>
                              <p class="total-status">Đã hủy</p>
                           <?php } ?>
                        </div>
                        <?php
                        $queryDetail = mysqli_query($connect, "SELECT * FROM nongsansach.chitietdonhang INNER JOIN nongsansach.sanpham on chitietdonhang.MaSP=sanpham.MaSP where `MaDH` = '" . $row['MaDH'] . "'");
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
                                    <span><?= number_format($rowDetail['GiaSPMua'], 0, ',', '.') ?>₫</span>
                                 </div>
                              </div>
                           </div>
                        <?php
                        }
                        ?>
                        <div class="f-purchase1">
                           <div class="total-purchase">
                              Thành tiền:
                              <span class="total"><?= number_format($row['ThanhTien'], 0, ',', '.') ?>₫</span>
                           </div>
                        </div>
                        <div class="f-purchase2">
                           <div class="date-buys">
                              Ngày đặt hàng: <?= date_format(date_create($row['NgayDatHang']), "H:i:s d-m-Y"); ?>
                           </div>
                           <?php
                           if ($row['TrangThai'] == 0) {
                           ?>
                              <div class="cancel">
                                 <button type="button" class="btncancel" onclick="cancel_purchase(<?= $row['MaDH'] ?>)">Hủy đơn hàng</button>
                              </div>
                           <?php
                           }
                           ?>
                        </div>
                     </div>
                  <?php
                  }
               } else {
                  ?>
                  <div class="notify">
                     <div class="notify-content">
                        <img src="images/chuacodon.jpg" alt="">
                        <span>Chưa có đơn hàng</span>
                     </div>
                  </div>
               <?php
               }
               ?>
            </div>
            <!-- Đơn hàng đã hủy -->
            <div class="tab-purchase" id="cancelled">
               <?php
               $check1 = mysqli_num_rows($queryCheck5);
               if ($check1 > 0) {
               ?>
                  <?php
                  $queryPurchase = mysqli_query($connect, "SELECT * FROM nongsansach.donhang where `MaTK` = '" . $user['MaTK'] . "' AND TrangThai=3 ORDER BY `donhang`.`NgayDatHang` DESC");
                  while ($row = mysqli_fetch_assoc($queryPurchase)) {
                  ?>
                     <div class="box-purchase">
                        <div class="header-purchase">
                           <p><a href="?mod=displays/purchaseDetail&id=<?= $row['MaDH'] ?>">Mã Đơn hàng: <?= $row['MaDH'] ?></a></p>
                           <?php if ($row['TrangThai'] == 0) { ?>
                              <p class="total-status">Chờ xác nhận</p>
                           <?php } elseif ($row['TrangThai'] == 1) { ?>
                              <p class="total-status">Đang giao</p>
                           <?php } elseif ($row['TrangThai'] == 2) { ?>
                              <p class="total-status">Đã giao</p>
                           <?php } elseif ($row['TrangThai'] == 3) { ?>
                              <p class="total-status">Đã hủy</p>
                           <?php } ?>
                        </div>
                        <?php
                        $queryDetail = mysqli_query($connect, "SELECT * FROM nongsansach.chitietdonhang INNER JOIN nongsansach.sanpham on chitietdonhang.MaSP=sanpham.MaSP where `MaDH` = '" . $row['MaDH'] . "'");
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
                                    <span><?= number_format($rowDetail['GiaSPMua'], 0, ',', '.') ?>₫</span>
                                 </div>
                              </div>
                           </div>
                        <?php
                        }
                        ?>
                        <div class="f-purchase1">
                           <div class="total-purchase">
                              Thành tiền:
                              <span class="total"><?= number_format($row['ThanhTien'], 0, ',', '.') ?>₫</span>
                           </div>
                        </div>
                        <div class="f-purchase2">
                           <div class="date-buys">
                              Ngày đặt hàng: <?= date_format(date_create($row['NgayDatHang']), "H:i:s d-m-Y"); ?>
                           </div>
                           <?php
                           if ($row['TrangThai'] == 0) {
                           ?>
                              <div class="cancel">
                                 <button type="button" class="btncancel" onclick="cancel_purchase(<?= $row['MaDH'] ?>)">Hủy đơn hàng</button>
                              </div>
                           <?php
                           }
                           ?>
                        </div>
                     </div>
                  <?php
                  }
               } else {
                  ?>
                  <div class="notify">
                     <div class="notify-content">
                        <img src="images/chuacodon.jpg" alt="">
                        <span>Chưa có đơn hàng</span>
                     </div>
                  </div>
               <?php
               }
               ?>
            </div>
         </div>
      </section>
   <?php
   }
   ?>
<?php
}
?>
<script>
   function openPurchase(evt, purchase) {
      var i, tab_purchase, tab_link;
      tab_purchase = document.getElementsByClassName("tab-purchase");
      for (i = 0; i < tab_purchase.length; i++) {
         tab_purchase[i].style.display = "none";
      }
      tab_link = document.getElementsByClassName("tab-link");
      for (i = 0; i < tab_link.length; i++) {
         tab_link[i].className = tab_link[i].className.replace(" activeP", "");
      }
      document.getElementById(purchase).style.display = "block";
      evt.currentTarget.className += " activeP";
   }
   document.getElementById("defaultOpen").click();
</script>
<script src="./js/script2.js"></script>