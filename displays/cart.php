<link rel="stylesheet" href="./css/cart.css">
<?php

if (isset($_SESSION['current_user'])) {
  $currentUser = $_SESSION['current_user'];
?>
<?php
}
if (!isset($_SESSION)) {
  include '../db/config.php';
}
?>
<section>
  <div class="container-2">
    <div class="line-title"></div>
    <div class="cart-title box">
      <h1>Giỏ Hàng</h1>
    </div>
    <div class="cart-content">
      <div id="ajax-cart">
        <?php include './displays/ajax/cart/cartContent.php'; ?>
      </div>
    </div>
  </div>
</section>
<?php
include './lazy_form/latest_product/latest_product.php';
?>