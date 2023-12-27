<link rel="stylesheet" href="./css/cart.css">
<!-- <link rel="stylesheet" href="./css/personalInfo.css"> -->
<style>
  /* HIDE RADIO */
  [type=radio][name='payment'] {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
  }

  /* IMAGE STYLES */
  [type=radio]+img {
    cursor: pointer;
  }

  /* CHECKED STYLES */
  [type=radio]:checked+img {
    outline: 2px solid #f00;
  }
</style>
<section>
  <div class="container-2">
    <?php
    if (isset($_SESSION['current_user'])) {
    ?>
      <div class="line-title"></div>
      <div class="cart-title box">
        <h1>Thanh toán</h1>
      </div>
      <?php
      if (!empty($_SESSION['cart'])) {
        $products = mysqli_query($connect, "SELECT * FROM nongsansach.sanpham WHERE `MaSP` IN (" . implode(",", array_keys($_SESSION['cart'])) . ")");
        $address = mysqli_query($connect, "SELECT * FROM nongsansach.thongtinnguoinhan where `MaTK`= " . $currentUser['MaTK'] . " LIMIT 1");
        $diachi = mysqli_fetch_assoc($address);
      ?>
        <form class="order-content" action="" method="POST">
          <div>
            <div class="delivery-address box" id="delivery-address">
              <?php include './displays/ajax/cart/addressContent.php'; ?>
            </div>
            <div id="edit" style="display: none;"></div>
            <div class="products-order box">
              <table id="cart" class="cart">
                <thead>
                  <tr>
                    <th style="width:52%">Sản phẩm</th>
                    <th style="width:17%">Giá</th>
                    <th style="width:10%">Số lượng</th>
                    <th style="width:17%" class="text-center">Thành tiền</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (!empty($products)) {
                    $total = 0;
                    $num = 1;
                    while ($row = mysqli_fetch_array($products)) {
                  ?>
                      <tr>
                        <td data-th="Product">
                          <div class="row">
                            <div class="img-product">
                              <img src="data:image/png;base64,<?= $row['AnhSP'] ?>" alt="<?= $row['TenSP'] ?>" class="img-responsive" width="100">
                            </div>
                            <div class="name-product">
                              <h4 class="nomargin"><?= $row['TenSP'] ?></h4>
                              <p><?= $row['MoTa'] ?></p>
                            </div>
                          </div>
                        </td>
                        <td data-th="Price"><?= number_format($row['GiaSP'], 0, ',', '.') ?>₫</td>
                        <td data-th="Quantity"><?= $_SESSION['cart'][$row['MaSP']] ?></td>
                        <td data-th="Subtotal" class="text-center"><?= number_format((($_SESSION['cart'][$row['MaSP']]) * $row['GiaSP']), 0, ',', '.') ?>₫</td>
                      </tr>
                    <?php
                      $total += $row['GiaSP'] * $_SESSION['cart'][$row['MaSP']];
                      $num++;
                    }
                    ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td></td>
                    <td></td>
                    <td class="ab">Tổng tiền: </td>
                    <td class="total-products"><?= number_format($total, 0, ',', '.') ?>₫</td>
                  </tr>
                <?php
                  }
                ?>
                </tfoot>
              </table>
            </div>
            <div class="total-payment box">
              <div class="title-payment">
                <div class="title-payment-h">
                  <h1>Hình thức thanh toán</h1>
                  <a class="title-swap">Chọn hình thức thanh toán</a>
                </div>
                <div id="row1">
                  <div class="col-lg-3 radio-group" style="display:inline-flex;">
                    <div class="row2">
                      <label>
                        <input type="radio" name="payment" value="thanhtoankhinhanhang" checked>
                        <img class="pay" src="images/thanhtoanknh.jpg">
                      </label>
                    </div>
                    <div class="row3">
                      <label>
                        <input type="hidden" name="payment" value="Thanh toán VNPAY ATM" class="btn5">
                        <a href="vnpay_php"><img class="pay" src="images/vnpay.png"></a>
                      </label>
                    </div>
                    <div class="row5">
                      <div class="row1 d-flex px-3 radio gray mb-3" name="">
                        <img class="pay" src="https://i.imgur.com/cMk1MtK.jpg">
                        <?php
                        $orderProducts = array();
                        foreach ($orderProducts as $key => $product) {
                          $total += $product['GiaSP'] * $_SESSION['cart'][$product['MaSP']];
                        }
                        ?>
                        <input type="hidden" name="payment" value="<?php echo $total = round($total / 23000) ?>" id="total">
                        <div id="paypal-button-container">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
        </form>

        <div class="grid-payment">
          <?php
          $products = mysqli_query($connect, "SELECT * FROM nongsansach.sanpham WHERE `MaSP` IN (" . implode(",", array_keys($_SESSION['cart'])) . ")");
          ?>
          <?php
          if (!empty($products)) {
            $total = 0;
            $num = 1;
            while ($row = mysqli_fetch_array($products)) {
          ?>
            <?php
              $total += $row['GiaSP'] * $_SESSION['cart'][$row['MaSP']];
              $num++;
            }
            ?>
            <div class="ab bc1 cd">Tổng tiền hàng:</div>
            <div class="ab bc1 de"><?= number_format($total, 0, ',', '.') ?>₫</div>
            <?php
            if ($diachi != null) {
              if (isset($_SESSION['address'])) {
                $arrAddress = explode(',', $rowaddress['DiaChi'])[2];
              } else {
                $arrAddress = explode(',', $diachi['DiaChi'])[2];
              }
              $query = mysqli_query($connect, "SELECT * FROM nongsansach.vanchuyen where TenTP='" . trim($arrAddress) . "' ORDER BY MaVC");
              $row_delivery = mysqli_fetch_assoc($query);
            }
            if ($diachi != null) {
              $ship = $row_delivery['Phiship'];
            } else {
              $ship = 0;
            }
            ?>
            <div class="ab bc2 cd">Phí Vận chuyển:</div>
            <div class="ab bc2 de"><?= number_format($ship, 0, ',', '.') ?>₫</div>
            <?php
            $tong = $total + $ship;
            ?>
            <div class="ab bc3 cd">Tổng thanh toán:</div>
            <div class="ab bc3 de total-price"><?= number_format($tong, 0, ',', '.') ?>đ</div>
            <?php //} 
            ?>
          <?php } ?>
          <div class="f-payment">
            <button type="submit" class="btn-order" name="thanhtoan">Đặt Hàng</button>
          </div>
        </div>
  </div>
  </div>
  </div>
<?php
      } else {
?>
  <div class="notify">
    <img src="./images/shop-cart-icon.png" alt="">
    <span>Giỏ hàng của bạn còn trống</span>
    <a href="?mod=displays/products" class="btn">Mua ngay</a>
  </div>
<?php
      }
    } else {
?>
<div class="notify">
  <div class="fas fa-user-circle"></div>
  <span>Vui lòng đăng nhập để sử dụng chức năng giỏ hàng</span>
  <a href="displays/account.php" class="btn">Đăng nhập</a>
</div>
<?php
    }
?>

</div>
</section>
<script>
  jQuery(document).ready(function() {
    $('.swap').click(function() {
      idTK = $('#valMaTK').val();
      idNN = $('#valMaNN').val();
      $.post('./displays/ajax/cart/ajaxAddress.php', {
        'idTK': idTK,
        'idNN': idNN
      }, function(data) {
        $('#delivery-address').html(data);
      })
    });
  })
</script>
<script>
  $('.order-content').submit(function(event) {
    event.preventDefault();
    idNN = $('#valMaNN').val();
    if (idNN == undefined) {
      alert('Bạn chưa có địa chỉ nhận hàng. Vui lòng thêm địa chỉ nhận hàng.');
      window.scrollTo(0, 200)
    } else {
      idPay = $("input[type='radio'][name='payment']:checked").val();
      $.ajax({
        type: 'POST',
        url: './displays/ajax/cart/processCart.php?action=submit',
        data: {
          'idNN': idNN,
          'idPay': idPay
        },
        success: function(response) {
          response = JSON.parse(response);
          if (response.status == 0) { //Đặt hàng không thành công
            alert(response.message);
          } else { //Đặt hàng thành công
            alert(response.message);
            location.href = 'index.php?mod=displays/cart';
          }
        }
      })
    }
  })
</script>
<script src="./js/script2.js"></script>