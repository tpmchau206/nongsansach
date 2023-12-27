<?php
include '../../../db/config.php';

if (isset($_POST['id'])) {
    $sql4 = "DELETE FROM nongsansach.thongtinnguoinhan WHERE MaNN='" . $_POST['id'] . "'";
    $query4 = mysqli_query($connect, $sql4);
}
?>
<aside class="focus">
    <form class="alert-box" action="" method="POST">
        <legend>Bạn có chắc muốn xóa địa chỉ này?</legend>

        <button type="submit" class="btn">XÓA</button>
        <button type="button" class="btn exit">TRỞ LẠI</button>
    </form>
</aside>
<script>
    jQuery(document).ready(function() {
        $('.exit').click(function() {
            $('#edit').text('');
            $('#edit').css('display', 'none');
        })
    })
</script>