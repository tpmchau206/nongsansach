   <link rel="stylesheet" href="./css/personalInfo.css">
   <h3><i class="fa-solid fa-location-dot"></i> Địa chỉ nhận hàng</h2>
       <?php
        if (!isset($_SESSION)) {
            include '../../../db/config.php';
            $currentUser = $_SESSION['current_user'];
            if (isset($_POST['valSelect'])) {
                $_SESSION['address'] = $_POST['valSelect'];
            }
        }

        if (isset($_SESSION['address'])) {
            $address = mysqli_query($connect, "SELECT * FROM nongsansach.thongtinnguoinhan where `MaTK`= " . $currentUser['MaTK'] . " AND `MaNN`=" . $_SESSION['address'] . "");
        } else {
            $address = mysqli_query($connect, "SELECT * FROM nongsansach.thongtinnguoinhan where `MaTK`= " . $currentUser['MaTK'] . " LIMIT 1");
        }
        $rowaddress = mysqli_fetch_array($address);
        if ($rowaddress != null) {
        ?>
           <input type="hidden" id="valMaNN" value="<?= $rowaddress['MaNN'] ?>">
           <input type="hidden" id="valMaTK" value="<?= $rowaddress['MaTK'] ?>">
           <p><strong><?= $rowaddress['TenNN'] ?>&nbsp;&nbsp;<?= $rowaddress['SDTNN'] ?></strong>&nbsp;&nbsp;&nbsp;
               <?= $rowaddress['SoNha'] ?>, <?= $rowaddress['DiaChi'] ?>
               <a class="swap">THAY ĐỔI</a>
           </p>
       <?php } else { ?>
           <div>Bạn chưa có địa chỉ nhận. Vui lòng thêm địa chỉ.</div>
           <button type="button" class="btn-address">+ Thêm mới địa chỉ</button>
       <?php } ?>
       <script>
           jQuery(document).ready(function() {
               $('.btn-address').click(function() {
                   $('#edit').css('display', 'block');
                   $.get('./displays/ajax/address/addressadd.php',
                       function(data) {
                           $('#edit').html(data);
                       });
               })
               // $('#btn-finish').click(function(event) {
               //     event.preventDefault();
               //     valMaNN = $('#valMaNN')
               //     $.post('./displays/ajax/cart/ajaxAddress.php', {
               //         'valMaNN': valMaNN
               //     }, function(data) {
               //         $('#delivery-address').html(data);

               //     })
               // })
           })
       </script>