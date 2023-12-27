<?php
include '../../../db/config.php';
// var_dump($_POST);
// exit;
$id = (array_keys($_POST['quantity']))[0];
$quantity = $_POST['quantity'][$id];
$addProduct = mysqli_query($connect, "SELECT `SoLuong` FROM nongsansach.sanpham WHERE `MaSP` = " . $id);
$addProduct = mysqli_fetch_assoc($addProduct);
if (isset($_SESSION['cart'][$id])) {
    $quantity += $_SESSION['cart'][$id];
}
if ($quantity > $addProduct['SoLuong']) {
    echo json_encode("Số lượng sản phẩm tồn kho không đủ. Bạn chỉ có thể mua tối đa " . $addProduct['SoLuong'] . " sản phẩm. Vui lòng kiểm tra lại giỏ hàng.");
} else {
    echo json_encode(true);
}
