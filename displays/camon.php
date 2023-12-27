<link rel="stylesheet" href="./css/cart.css">

<?php

use Carbon\Carbon;
use Carbon\CarbonInterval;

require('./carbon/autoload.php');
$now = Carbon::now('Asia/Ho_Chi_Minh');
// Tai khoan Test PAYPAL
// TK: hai888880@personal.example.com
// MK: Hai0987994431
if (isset($_GET['thanhtoan']) == 'paypal') {
  $card_payment = 'paypal';
  $products = mysqli_query($connect, "SELECT * FROM nongsansach.sanpham WHERE MaSP IN (" . implode(",", array_keys($_SESSION['cart'])) . ")");
  if (isset($_SESSION['address'])) {
    $address = mysqli_query($connect, "SELECT * FROM nongsansach.thongtinnguoinhan where `MaTK`= " . $currentUser['MaTK'] . " AND `MaNN`=" . $_SESSION['address'] . "");
  } else {
    $address = mysqli_query($connect, "SELECT * FROM nongsansach.thongtinnguoinhan where `MaTK`= " . $currentUser['MaTK'] . " LIMIT 1");
  }
  $rowaddress = mysqli_fetch_array($address);
  $total = 0;
  $orderProducts = array();
  $updateString = "";
  $changeQuantity = false;
  $trangthai = 0;
  while ($row = mysqli_fetch_array($products)) {
    $orderProducts[] = $row;
    if ($_SESSION['cart'][$row['MaSP']] > $row['SoLuong']) { //Thay đổi số lượng sản phẩm trong giỏ hàng
      $_SESSION['cart'][$row['MaSP']] = $row['SoLuong'];
      $changeQuantity = true;
    } else {
      $total += $row['GiaSP'] * $_SESSION['cart'][$row['MaSP']];
      if($rowaddress == null){
        $updateString .= " when MaSP = " . $row['MaSP'] . " then SoLuong"; //Giữ nguyên số lượng sản phẩm tồn kho
      }elseif($rowaddress >=0){
        $updateString .= " when MaSP = " . $row['MaSP'] . " then SoLuong - " . $_SESSION['cart'][$row['MaSP']]; //Trừ đi sản phẩm tồn kho
      }
    }
  }
  if ($changeQuantity == false) {
    $updateQuantity = mysqli_query($connect, "UPDATE nongsansach.sanpham set SoLuong = CASE" . $updateString . " END where MaSP in (" . implode(",", array_keys($_SESSION['cart'])) . ")");
    $address = mysqli_query($connect, "SELECT * FROM nongsansach.thongtinnguoinhan");
    $diachi = mysqli_fetch_assoc($address);
    if (isset($_SESSION['address'])) {
      $address = mysqli_query($connect, "SELECT * FROM nongsansach.thongtinnguoinhan where `MaTK`= " . $currentUser['MaTK'] . " AND `MaNN`=" . $_SESSION['address'] . "");
    } else {
      $address = mysqli_query($connect, "SELECT * FROM nongsansach.thongtinnguoinhan where `MaTK`= " . $currentUser['MaTK'] . " LIMIT 1");
    }
    $rowaddress = mysqli_fetch_array($address);
    $customer = "SELECT * FROM nongsansach.thongtinnguoinhan where `MaNN`='" . $rowaddress['MaNN'] . "'";
    if (isset($rowaddress['MaNN'])) {
      $arrAddress = explode(',', $rowaddress['DiaChi'])[2];
    } else {
      $arrAddress = explode(',', $diachi['DiaChi'])[2];
    }
    $query = mysqli_query($connect, "SELECT * FROM nongsansach.vanchuyen where TenTP='" . trim($arrAddress) . "' ORDER BY MaVC");
    while ($row_delivery = mysqli_fetch_assoc($query)) {
      $tongphiship = $row_delivery['Phiship'];
      $tongtien = $total + $row_delivery['Phiship'];
      $query = mysqli_query($connect, $customer);
      while ($row = mysqli_fetch_assoc($query)) {
        $matk = $row['MaTK'];
        $mann = $row['MaNN'];
        $dulieu =  $row['TenNN'] . ", " . $row['SDTNN'] . ", " . $row['SoNha'] . ", " . $row['DiaChi'] . ", " . $tongphiship;
        $insertOrder = "INSERT INTO nongsansach.donhang(`MaNN`,`MaTK`,`TrangThai`,`PTThanhToan`,`NgayDatHang`,`ThanhTien`,`DuLieu`)
       VALUES ('" . $mann . "','" . $matk . "','" . $trangthai . "','" . $card_payment . "','" . $now . "','" . $tongtien . "','" . $dulieu . "')";
        $cart_query = mysqli_query($connect, $insertOrder);
        $last_id = mysqli_insert_id($connect);
        $orderID = $connect->insert_id;
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
    $cart_detail = mysqli_query($connect, $insertOrder);
    if ($rowaddress['MaNN'] == null) {
      echo "<script>alert('Bạn chưa có địa chỉ nhận hàng. Vui lòng thêm địa chỉ nhận hàng');window.location='?mod=displays/order'</script>";
    } elseif ($cart_query) {
      unset($_SESSION['cart']);
      echo "<script>alert('Giao dịch thanh toán bằng PAYPAL thành công');window.location='index.php'</script>";
    } else {
      echo "<script>alert('Giao dịch thất bại');window.location='?mod=displays/order'</script>";
    }
  } else {
    echo '<script>alert("Đặt hàng không thành công do số lượng sản phẩm tồn kho không đủ. Bạn vui lòng kiểm tra lại giỏ hàng")</script>';
  }
}
?>
<!-- <div class="section" style=text-align:center;>
  <tr>
    <td class="resume-buys"><a href="?mod=displays/products" class="btn btn-warning"><i class="fa fa-angle-left"></i>
        Tiếp tục mua hàng</a>
    </td>
  </tr>
</div> -->
<div class="clear"></div>