<?php
$result = mysqli_query($connect, "SELECT * FROM nongsansach.sanpham WHERE MaSP=" . $_GET['id']);
$product = mysqli_fetch_assoc($result);
$imgLibrary = mysqli_query($connect, "SELECT * FROM nongsansach.thuvienanh WHERE nongsansach.thuvienanh.MaSP  = ' $_GET[id]' LIMIT 4");
$product['imagesps'] = mysqli_fetch_all($imgLibrary, MYSQLI_ASSOC);
$products = mysqli_query($connect, "SELECT * FROM nongsansach.sanpham inner join nongsansach.donvitinh on sanpham.MaDV=donvitinh.MaDV  ORDER BY MaSP DESC");
$unit = mysqli_fetch_assoc($products);

?>
<section class="product">
    <div class="bg-box">
        <div class="small-container single-product">
            <div class="row">
                <div class="col-1">
                    <div class="slider-for">
                        <div class="">
                            <img src="data:image/png;base64,<?= $product['AnhSP'] ?>" class="small-img" width="100">
                        </div>
                        <?php foreach ($product['imagesps'] as $img) { ?>
                            <div class="small-img-col">
                                <img src="data:image/png;base64,<?= $img['AnhTV'] ?>" class="small-img">
                            </div>
                        <?php } ?>
                    </div>
                    <div class="slider-nav">
                        <div class="small-img-col">
                            <img src="data:image/png;base64,<?= $product['AnhSP'] ?>" class="small-img" width="100">
                        </div>
                        <?php foreach ($product['imagesps'] as $img) { ?>
                            <div class="small-img-col">
                                <img src="data:image/png;base64,<?= $img['AnhTV'] ?>" class="small-img">
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-2">
                    <h1 style="color: var(--green);"><?= $product['TenSP'] ?></h1>
                    <h2 class="text-5xl leading-loose"><?= number_format($product['GiaSP'], 0, ',', '.') ?> ₫</h2>
                    <h2 class="text-3xl">Tồn kho: <?= $product['SoLuong'] ?></h2>
                    <?php
                    if ($product['SoLuong'] > 0) {
                    ?>
                        <form action="" method="POST" id="add-to-cart" class="pt-3.5">
                            <input type="number" min="1" max="10" value="1" name="quantity[<?= $product['MaSP'] ?>]">
                            <span class="text-2xl"> /<?= $unit['TenDV'] ?></span>
                            <br>
                            <label id="quantity[<?= $product['MaSP'] ?>]-error" class="error" for="quantity[<?= $product['MaSP'] ?>]"></label>
                            <br>
                            <button type="submit" class="btn">Thêm vào giỏ</button>
                        </form>
                    <?php
                    } else {
                    ?>
                        <h1 style="color: red;font-size: 20px;"><strong>Hết hàng</strong></h1>
                    <?php
                    }
                    ?>
                    <br>
                    <br>
                    <h2 class="text-3xl">Chi tiết sản phẩm</h2>
                    <br>
                    <div class="clear-both"></div>
                    <span class="text-3xl"><?= $product['MoTa'] ?></span>
                </div>
                <!-- Latest Product Section Begin -->
            </div>
        </div>
    </div>
</section>
<section class="product">
    <div class="bg-box">
        <?php
        include './lazy_form/latest_product/similar_product.php';
        ?>
    </div>
</section>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>