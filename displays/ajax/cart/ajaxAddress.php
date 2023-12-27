<link rel="stylesheet" href="./css/personalInfo.css">
<h3><i class="fa-solid fa-location-dot"></i> Địa chỉ nhận hàng</h2>
    <?php
    if (!isset($_SESSION)) {
        include '../../../db/config.php';
        $currentUser = $_SESSION['current_user'];
    }
    $address = mysqli_query($connect, "SELECT * FROM nongsansach.thongtinnguoinhan where `MaTK`= " . $_POST['idTK']);

    while ($rowaddress = mysqli_fetch_array($address)) {
    ?>

        <p><input class="selectaddress" type="radio" name="checkedaddress" <?php ($_POST['idNN'] == $rowaddress['MaNN']) ? print 'checked' : print '' ?> value="<?= $rowaddress['MaNN'] ?>">&nbsp;
            <strong><?= $rowaddress['TenNN'] ?>&nbsp;&nbsp;<?= $rowaddress['SDTNN'] ?></strong>&nbsp;&nbsp;&nbsp;
            <?= $rowaddress['SoNha'] ?>, <?= $rowaddress['DiaChi'] ?>
        </p>
    <?php } ?>
    <button type="button" id="btn-finish" class="btn">Hoàn Thành</button>
    <button type="button" id="btn-back" class="btn exit">Trở Lại</button>
    <button type="button" class="btn-address">+ Thêm mới địa chỉ</button>
    <script>
        jQuery(document).ready(function() {
            $('.btn-address').click(function() {
                $('#edit').css('display', 'block');
                $.get('./displays/ajax/address/addressadd.php',
                    function(data) {
                        $('#edit').html(data);
                    });
            })
            $('#btn-finish').click(function() {
                idselect = $(".selectaddress");
                for (i = 0; i < idselect.length; i++) {
                    if (idselect[i].checked === true) {
                        valSelect = idselect[i].value;
                    }
                }
                $.post('./displays/ajax/cart/addressContent.php', {
                    'valSelect': valSelect
                }, function(data) {
                    $('#delivery-address').html(data);
                    location.reload();
                })
            })
            $('#btn-back').click(function() {
                $.get('./displays/ajax/cart/addressContent.php',
                    function(data) {
                        $('#delivery-address').html(data);
                        location.reload();

                    })
            })
        })
    </script>