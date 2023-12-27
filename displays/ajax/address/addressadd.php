<?php
include '../../../db/config.php';
?>
<aside class="focus">
    <form action="" method="POST" class="edit-add">
        <table>
            <tr>
                <td colspan="2">
                    <h1>Chỉnh sửa địa chỉ</h1>
                    <input type="hidden" name="addmann" value="">
                </td>
            </tr>
            <tr>
                <td class="hoten" colspan="1">
                    <input type="text" name="addname" placeholder="Họ và tên" id="addname" pattern=".{3,}" required autocomplete="off">
                </td>
                <td class="sdt" colspan="1">
                    <input type="text" name="addsdt" placeholder="Số điện thoại" pattern="((09|03|07|08|05)+([0-9]{8}))" required autocomplete="off">
                </td>
            </tr>
            <tr>
                <td colspan="2" class="diachi">
                    <div class="dropdown-diachi">
                        <input type="text" name="adddiachi" id="edtaddress" pattern=".{3,}" class="address" placeholder="Tỉnh/Thành phố, Quận/Huyện, Phường/Xã" required autocomplete="off">
                        <div class="dropdown-content">
                            <div class="tab">
                                <label for="province" class="tablinks activeTab" onclick="openCity(event,'province')">Tỉnh/Thành phố</label>
                                <label for="district" class="tablinks" onclick="openCity(event,'district')">Quận/Huyện</label>
                                <label for="ward" class="tablinks" onclick="openCity(event,'ward')">Phường/Xã</label>
                            </div>
                            <select id="province" class="tabdiachi" multiple="">
                                <?php
                                $query4 = mysqli_query($connect, "SELECT * FROM nongsansach.tinhthanh ORDER BY `TenTT`");
                                $province = mysqli_fetch_all($query4, 1);
                                foreach ($province as $row2) {
                                ?>
                                    <option onclick="openTransfer(event,'district')" value="<?= trim($row2['TenTT']) ?>"><?= trim($row2['TenTT']) ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <select id="district" class="tabdiachi" multiple>
                            </select>
                            <select id="ward" class="tabdiachi" multiple>
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="sonha">
                    <input type="text" name="addsonha" placeholder="Địa chỉ cụ thể" pattern=".{3,}" required autocomplete="off">
                </td>
            </tr>
            <tr>
                <td colspan="2" class="action-btn">
                    <div class="btn exit">TRỞ LẠI</div>
                    <button type="submit" name="submit" class="btn">HOÀN THÀNH</button>
                </td>
            </tr>
        </table>
    </form>
</aside>

<script>
    var diachi = document.querySelector('.address');
    var dropdown = document.querySelector('.dropdown-content');
    diachi.onclick = function() {
        dropdown.classList.toggle('activeAdress');
    };

    jQuery(document).ready(function($) {
        $('.exit').click(function() {
            $('#edit').text('');
            $('#edit').css('display', 'none');
        })
        $('#province').change(function(event) {
            provinceId = $('#province').val();
            $('#edtaddress').val(provinceId);
            $.post('./displays/ajax/address/district.php', {
                "provinceid": provinceId[0]
            }, function(data) {
                $('#district').html(data);
            });
        });
        $('#district').change(function(event) {
            districtId = $('#district').val();
            $('#edtaddress').val(provinceId + ', ' + districtId);
            $.post('./displays/ajax/address/ward.php', {
                "districtid": districtId[0]
            }, function(data) {
                $('#ward').html(data);
            });
        });
        $('#ward').change(function(event) {
            wardId = $('#ward').val();
            $('#edtaddress').val(provinceId + ', ' + districtId + ', ' + wardId);
            $('.dropdown-content').removeClass('activeAdress')
        });
    });
</script>
<script>
    $('.edit-add').submit(function(event) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: './displays/ajax/address/ajaxAddress.php?action=add',
            data: $(this).serializeArray(),
            success: function(response) {
                response = JSON.parse(response);
                if (response.status == 0) { //thêm không thành công
                    alert(response.message);
                } else { //thêm thành công
                    alert(response.message);
                }
            }
        })
        location.reload();
    })
</script>