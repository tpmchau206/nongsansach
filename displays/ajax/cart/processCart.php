<?php
include '../../../db/config.php';
include 'func_getTotalQuantity.php';

use Carbon\Carbon;
use Carbon\CarbonInterval;

require('../../../carbon/autoload.php');



$GLOBALS['connection'] = $connect;

switch ($_GET['action']) {
   case 'add':
      $result = update_cart(true);
      $totalQuantity = getTotalQuantity();
      $result['total_quantity'] = $totalQuantity;
      echo json_encode($result);
      break;
   case 'update':
      $result = update_cart();
      $totalQuantity = getTotalQuantity();
      $result['total_quantity'] = $totalQuantity;
      echo json_encode($result);
      break;
   case 'delete':
      if (isset($_POST['id'])) {
         unset($_SESSION['cart'][$_POST['id']]);
      }
      echo json_encode(array(
         'status' => 1,
         'message' => 'Xóa sản phẩm thành công',
         'total_quantity' => getTotalQuantity()

      ));
      break;
   case 'submit':
      // if (empty($_SESSION['cart'])) {
      //    echo json_encode(array(
      //       'status' => 0,
      //       'message' => "Giỏ hàng rỗng. Bạn vui lòng lựa chọn sản phẩm vào giỏ hàng."
      //    ));
      //    exit;
      // }
      cart_checkout();
      break;
   case 'cancel':
      cancel_purchase();
      break;
   default:
      break;
}
function cancel_purchase()
{
   $products = mysqli_query($GLOBALS['connection'], "SELECT * FROM nongsansach.chitietdonhang INNER JOIN nongsansach.sanpham ON chitietdonhang.MaSP = sanpham.MaSP WHERE MaDH='" . $_POST['id'] . "' ORDER BY chitietdonhang.MaCTDH DESC");
   while ($row = mysqli_fetch_array($products)) {
      $soluonghoi = $row['SoLuong'] + $row['SoLuongMua'];
      mysqli_query($GLOBALS['connection'], "UPDATE nongsansach.sanpham set SoLuong = '$soluonghoi' WHERE MaSP =" . $row['MaSP']);
   }
   mysqli_query($GLOBALS['connection'], "UPDATE nongsansach.donhang SET TrangThai='3' WHERE MaDH=" . $_POST['id']);
}

function cart_checkout()
{

   $products = mysqli_query($GLOBALS['connection'], "SELECT * FROM nongsansach.sanpham WHERE MaSP IN (" . implode(",", array_keys($_SESSION['cart'])) . ")");
   $total = 0;
   $orderProducts = array();
   $updateString = "";
   $changeQuantity = false;
   $trangthai = 0;
   $card_payment = $_POST["idPay"];
   while ($row = mysqli_fetch_array($products)) {
      $orderProducts[] = $row;
      if ($_SESSION['cart'][$row['MaSP']] > $row['SoLuong']) { //Thay đổi số lượng sản phẩm trong giỏ hàng
         $_SESSION['cart'][$row['MaSP']] = $row['SoLuong'];
         $changeQuantity = true;
      } else {
         $total += $row['GiaSP'] * $_SESSION['cart'][$row['MaSP']];
         $updateString .= " when MaSP = " . $row['MaSP'] . " then SoLuong - " . $_SESSION['cart'][$row['MaSP']]; //Trừ đi sản phẩm tồn kho
      }
   }

   if ($changeQuantity == false) {
      if (isset($_SESSION['current_user'])) {
         $currentUser = $_SESSION['current_user'];
?>
      <?php
      }
      $now = Carbon::now('Asia/Ho_Chi_Minh');
      $updateQuantity = mysqli_query($GLOBALS['connection'], "UPDATE nongsansach.sanpham set SoLuong = CASE" . $updateString . " END where MaSP in (" . implode(",", array_keys($_SESSION['cart'])) . ")");
      $address = mysqli_query($GLOBALS['connection'], "SELECT * FROM nongsansach.thongtinnguoinhan");
      $diachi = mysqli_fetch_assoc($address);
      if (isset($_SESSION['address'])) {
         $address = mysqli_query($GLOBALS['connection'], "SELECT * FROM nongsansach.thongtinnguoinhan where `MaTK`= " . $currentUser['MaTK'] . " AND `MaNN`=" . $_SESSION['address'] . "");
      } else {
         $address = mysqli_query($GLOBALS['connection'], "SELECT * FROM nongsansach.thongtinnguoinhan where `MaTK`= " . $currentUser['MaTK'] . " LIMIT 1");
      }
      $rowaddress = mysqli_fetch_array($address);
      $customer = "SELECT * FROM nongsansach.thongtinnguoinhan where MaNN=" . $rowaddress['MaNN'] . "";
      if (isset($_POST['idNN'])) {
         $arrAddress = explode(',', $rowaddress['DiaChi'])[2];
      } else {
         $arrAddress = explode(',', $diachi['DiaChi'])[2];
      }
      $query = mysqli_query($GLOBALS['connection'], "SELECT * FROM nongsansach.vanchuyen where TenTP='" . trim($arrAddress) . "' ORDER BY MaVC");
      while ($row_delivery = mysqli_fetch_assoc($query)) {
         $tongphiship = $row_delivery['Phiship'];
         $tongtien = $total + $row_delivery['Phiship'];
         $query = mysqli_query($GLOBALS['connection'], $customer);
         while ($row = mysqli_fetch_assoc($query)) {
            $matk = $row['MaTK'];
            $mann = $row['MaNN'];
            $dulieu =  $row['TenNN'] . ", " . $row['SDTNN'] . ", " . $row['SoNha'] . ", " . $row['DiaChi'] . ", " . $tongphiship;
            $insertOrder = "INSERT INTO nongsansach.donhang(`MaNN`,`MaTK`,`TrangThai`,`PTThanhToan`,`NgayDatHang`,`ThanhTien`,`DuLieu`)
                  VALUES ('" . $mann . "','" . $matk . "','" . $trangthai . "','" . $card_payment . "','" . $now . "','" . $tongtien . "','" . $dulieu . "')";
            $cart_query = mysqli_query($GLOBALS['connection'], $insertOrder);
            $last_id = mysqli_insert_id($GLOBALS['connection']);
            $orderID = $GLOBALS['connection']->insert_id;
            $insertString = "";
            foreach ($orderProducts as $key => $product) {
               $insertString .= "(NULL,'" . $orderID . "', '" . $product['MaSP'] . "', '" . $_SESSION['cart'][$product['MaSP']] . "', '" . $product['GiaSP'] . "')";
               if ($key != count($orderProducts) - 1) {
                  $insertString .= ",";
               }
            }
         }
      }
      $insertOrder = "INSERT INTO nongsansach.chitietdonhang(MaCTDH,MaDH,MaSP,SoLuongMua,GiaSPMua) VALUES " . $insertString . ";";
      $cart_detail = mysqli_query($GLOBALS['connection'], $insertOrder);
      if ($rowaddress['MaNN'] == null) {
         echo json_encode(array(
            'status' => 0,
            'message' => "Bạn chưa nhập địa chỉ."
         ));
      } elseif ($rowaddress['MaNN'] >= 0) {
         unset($_SESSION['cart']);
      }
      echo json_encode(array(
         'status' => 1,
         'message' => "Đặt hàng thành công."
      ));
   } else {
      echo json_encode(array(
         'status' => 0,
         'message' => "Đặt hàng không thành công do số lượng sản phẩm tồn kho không đủ. Bạn vui lòng kiểm tra lại giỏ hàng"
      ));
   }
}
function update_cart($add = false)
{
   $changeQuantity = false;
   //foreach biến POST['quantity'] với key là id(mã sản phẩm), gán số lượng vào biến $quantity
   foreach ($_POST['quantity'] as $id => $quantity) {
      //nếu số lượng của sản phẩm được sửa thành 0 thì unset session['cart'] với id sản phẩm
      if ($quantity == 0) {
         unset($_SESSION['cart'][$id]);
      } else {
         if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = 0;
         }
         if ($add) {
            $_SESSION['cart'][$id] += $quantity;
         } else {
            $_SESSION['cart'][$id] = $quantity;
         }
         //Kiểm tra  tồn kho
         $addProduct = mysqli_query($GLOBALS['connection'], "SELECT `SoLuong` FROM nongsansach.sanpham WHERE `MaSP` = " . $id);
         $addProduct = mysqli_fetch_assoc($addProduct);
         if ($_SESSION['cart'][$id] > $addProduct['SoLuong']) {
            $_SESSION['cart'][$id] = $addProduct['SoLuong'];
            if ($add) {
               return array(
                  'status' => 0,
                  'message' => "Số lượng sản phẩm tồn kho chỉ còn: " . $addProduct['SoLuong'] . " sản phẩm."
               );
            } else {
               $changeQuantity = true;
            }
         }
         if ($add) {
            return array(
               'status' => 1,
               'message' => "Thêm sản phẩm thành công."
            );
         }
      }
   }
   if ($changeQuantity) {
      return array(
         'status' => 0,
         'message' => "Số lượng sản phẩm giỏ hàng đã thay đổi do sô lượng tồn kho không đủ. Ban vui lòng kiểm tra lại giỏ hàng.",
      );
   } else {
      return array(
         'status' => 1,
         'message' => "Cập nhật thành công.",
      );
   }
}
