<?php
include '../../../db/config.php';
$GLOBALS['connect'] = $connect;

switch ($_GET['action']) {
    case 'add':
        $result = insert_address(true);
        echo json_encode($result);
        break;
    case 'delete':
        $result = delete_address(true);
        echo json_encode($result);
        break;
    case 'update':
        $result = update_address(true);
        echo json_encode($result);
        break;
    default:
        break;
}
function update_address($upd = false)
{
    if ($upd) {
        if (isset($_POST['editname'])) {
            $mann = $_POST['editmann'];
            $name = $_POST['editname'];
            $sdt = $_POST['editsdt'];
            $sonha = $_POST['editsonha'];
            $diachi = array_reverse(explode(',', $_POST['editaddress']));
            $update = "UPDATE nongsansach.thongtinnguoinhan SET `TenNN`='$name', `SDTNN`='$sdt', `SoNha`='$sonha', `DiaChi`='" . implode(',', $diachi) . "' where `MaNN`='$mann'";
            $query_update = mysqli_query($GLOBALS['connect'], $update);
        }
    } else {
        return array(
            'status' => 0,
            'message' => 'Cập nhật không thành công'
        );
    }
}
function delete_address($del = false)
{
    if ($del) {
        if (isset($_POST['id'])) {
            $delete = "DELETE FROM nongsansach.thongtinnguoinhan WHERE MaNN='" . $_POST['id'] . "'";
            $query_delete = mysqli_query($GLOBALS['connect'], $delete);
            unset($_SESSION['address']);
        }
    } else {
        return array(
            'status' => 0,
            'message' => 'Xóa không thành công'
        );
    }
}
function insert_address($add = false)
{
    if ($add) {
        if (isset($_POST['addname'])) {
            $addname = $_POST['addname'];
            $addsdt = $_POST['addsdt'];
            $addsonha = $_POST['addsonha'];
            $adddiachi = array_reverse(explode(',', $_POST['adddiachi']));
            $insert = "INSERT INTO nongsansach.thongtinnguoinhan(`TenNN`,`SDTNN`,`SoNha`,`DiaChi`,`MaTK`) VALUES ('$addname','$addsdt','$addsonha','" . implode(',', $adddiachi) . "','" . $_SESSION['current_user']['MaTK'] . "')";
            $query_insert = mysqli_query($GLOBALS['connect'], $insert);
        }
    } else {
        return array(
            'status' => 0,
            'message' => "Thêm không thành công",
        );
    }
}
