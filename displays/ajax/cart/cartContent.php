<?php
if (!isset($_SESSION)) {
    include '../../../db/config.php';
}


?>
<?php
if (!empty($_SESSION['cart'])) {
    $products = mysqli_query($connect, "SELECT * FROM nongsansach.sanpham WHERE `MaSP` IN (" . implode(",", array_keys($_SESSION['cart'])) . ")");

    $total = 0;
    // $num = 1;
?>
    <form action="?mod=displays/order" id="cart-content" method="POST">

        <table id="cart" class="cart">
            <thead>
                <tr>
                    <th style="width:45%">Sản phẩm</th>
                    <th style="width:20%">Giá</th>
                    <th style="width:10%">Số lượng</th>
                    <th style="width:20%" class="text-center">Thành tiền</th>
                    <th style="width:5%"> </th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($products)) {
                ?>
                    <tr>
                        <td data-th="Product">
                            <div class="row">
                                <div class="img-product">
                                    <a href="?mod=displays/productDetail&id=<?= $row['MaSP'] ?>"><img src="data:image/png;base64,<?= $row['AnhSP'] ?>" alt="<?= $row['TenSP'] ?>" class="img-responsive" width="100"></a>
                                </div>
                                <div class="name-product">
                                    <h4 class="nomargin"><?= $row['TenSP'] ?></h4>
                                    <p class=""><?= $row['MoTa'] ?></p>
                                </div>
                            </div>
                        </td>
                        <td data-th="Price"><?= number_format($row['GiaSP'], 0, ',', '.') ?>₫</td>
                        <td data-th="Quantity"><input onchange="javascript:updateQuantity(this.value)" class="form-control text-center" id="quantity_<?= $row['MaSP'] ?>" value="<?= $_SESSION['cart'][$row['MaSP']] ?>" min="0" max="10" type="number" name="quantity[<?= $row['MaSP'] ?>]">
                        </td>
                        <td data-th="Subtotal" class="text-center"><?= number_format((($_SESSION['cart'][$row['MaSP']]) * $row['GiaSP']), 0, ',', '.') ?>₫</td>
                        <td class="actions" data-th="">
                            <a class="btn btn-danger fa fa-trash-alt" href="javascript: deleteCart(<?= $row['MaSP'] ?>)"></a>
                        </td>
                    </tr>
                <?php
                    $total += $row['GiaSP'] * $_SESSION['cart'][$row['MaSP']];
                    // $num++;
                }

                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="resume-buys"><a href="?mod=displays/products" class="btn btn-warning"><i class="fa fa-angle-left"></i>
                            Tiếp tục mua hàng</a>
                    </td>
                    <td><strong>Tổng tiền: </strong></td>
                    <td class="text-center"><strong><?= number_format($total, 0, ',', '.') ?>₫</strong>
                    </td>
                    <td><button type="submit" class="btn btn-success btn-block">Thanh toán <i class="fa fa-angle-right"></i></button>
                    </td>
                </tr>
            </tfoot>

        </table>
    </form>
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
?>