<!-- Load page -->
<!-- <div class="loader-container">
    <img src="images/loader2.gif" alt="">
</div> -->

<section class="home" id="home">
    <div class="img-slider">
        <?php
        $slider = "SELECT * FROM nongsansach.slide";
        $query = mysqli_query($connect, $slider);
        while ($row_slider = mysqli_fetch_assoc($query)) {
        ?>
            <div class="slide active">
                <img src="data:image/png;base64,<?= $row_slider['HinhSlide'] ?>" alt="">
                <div class="info">
                    <h2><?= $row_slider['NoiDung'] ?></h2>
                    <p><?= $row_slider['NoiDungTT'] ?></p>
                </div>
            </div>

        <?php } ?>
        <div class="navigation">
            <?php $i = 0  ?>
            <?php foreach ($query as $slider) { ?>
                <div class="btn2"></div>
                <?php $i++ ?>
            <?php } ?>
        </div>
    </div>
</section>
<br>
<div class="clear"></div>
<section class="category wow bounceInUp" id="category">
    <div class="bg-box">
        <h1 class="heading">Những sản phẩm trong <span>danh mục</span></h1>
        <div class="box-container">
            <?php
            $sql = "SELECT * FROM nongsansach.danhmuc;";
            $query = mysqli_query($connect, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
            ?>

                <div class="box">
                    <h3><?= $row['TenDM'] ?></h3>
                    <img src="data:image/png;base64,<?= $row['HinhDD'] ?>" alt="">
                    <a href="?mod=displays/productlist&id=<?= $row['MaDM'] ?>" class="btn">Xem ngay</a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>
<?php
$products = mysqli_query($connect, "SELECT sanpham.AnhSP as `AnhSP`,MIN(thuvienanh.AnhTV) as `AnhTV`, donvitinh.TenDV, sanpham.TenSP, sanpham.SoLuong, 
sanpham.MaSP, donvitinh.TenDV, sanpham.GiaSP
FROM nongsansach.sanpham
LEFT JOIN nongsansach.thuvienanh ON sanpham.MaSP = thuvienanh.MaSP 
inner join nongsansach.donvitinh on donvitinh.MaDV = sanpham.MaDV
GROUP BY  sanpham.MaSP;");
?>
<section class="product wow bounceInUp" id="product">
    <div class="bg-box">
        <h1 class="heading">Sản phẩm <span>mới</span></h1>
        <div class="list">
            <div class="box-container">
                <?php
                while ($row = mysqli_fetch_assoc($products)) {
                ?>
                    <div class="list-element">
                        <form action="" class="quick-by-form box wow bounceInUp" method="POST">

                            <a href="?mod=displays/productDetail&id=<?= $row['MaSP'] ?>"><img onmouseover="this.src='data:image/png;base64,<?= $row['AnhSP'] ?>'" onmouseout="this.src='data:image/png;base64,<?= $row['AnhTV'] ?>'" alt="" src="data:image/png;base64,<?= $row['AnhSP'] ?>"></a>
                            <h3><?= $row['TenSP'] ?></h3>
                            
                            <div class="price"><?= number_format($row['GiaSP'], 0, ',', '.') ?>₫</div>
                            <?php
                            if ($row['SoLuong'] > 0) {
                            ?>
                                <div class="quantity">
                                    <span>Số lượng : </span>
                                    <input type="number" min="1" max="10" value="1" name="quantity[<?= $row['MaSP'] ?>]">
                                    <span> /<?= $row['TenDV'] ?></span>
                                </div>
                                <button type="submit" class="btn">Thêm vào giỏ</button>
                            <?php
                            } else {
                            ?>

                                <div>
                                    <h1 style="color: red;font-size: 20px;"><strong>Hết hàng</strong></h1>
                                </div>
                            <?php
                            }
                            ?>
                        </form>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <!-- Load More Button -->
        <button id="loadmore">Xem thêm...</button>
    </div>
</section>
<?php
include './lazy_form/latest_product/latest_product.php';
?>
<script src="./js/slick-slide.js"></script>
<script src="./js/script.js"></script>