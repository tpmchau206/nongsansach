<section class="category wow bounceInUp">
    <div class="bg-box">
        <h1> Danh mục </h1>
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
<!-- end danh muc -->


<!-- product section starts  -->

<section class="product wow bounceInUp" id="product">
    <div class="bg-box">
        <h1 class="heading">Sản phẩm </h1>
        <div class="list">
            <div class="box-container">
                <?php
                $sql = "SELECT sanpham.AnhSP as `AnhSP`,MIN(thuvienanh.AnhTV) as `AnhTV`, donvitinh.TenDV, sanpham.TenSP, sanpham.SoLuong, 
                sanpham.MaSP, donvitinh.TenDV, sanpham.GiaSP
                FROM nongsansach.sanpham
                LEFT JOIN nongsansach.thuvienanh ON sanpham.MaSP = thuvienanh.MaSP 
                inner join nongsansach.donvitinh on donvitinh.MaDV = sanpham.MaDV
                GROUP BY  sanpham.MaSP;";
                // SELECT * FROM nongsansach.sanpham inner join nongsansach.donvitinh on sanpham.MaDV=donvitinh.MaDV ORDER BY MaSP DESC
                $query = mysqli_query($connect, $sql);
                while ($row = mysqli_fetch_assoc($query)) {
                ?>
                    <div class="list-element">
                        <form action="" class="quick-by-form box wow bounceInUp" method="POST" enctype="multipart/form-data">
                            <!-- <span class="discount">-33%</span> -->

                            <a href="?mod=displays/productDetail&id=<?= $row['MaSP'] ?>"><img onmouseover="this.src='data:image/png;base64,<?= $row['AnhSP'] ?>'" onmouseout="this.src='data:image/png;base64,<?= $row['AnhTV'] ?>'" src="data:image/png;base64,<?= $row['AnhSP'] ?>" alt=""></a>
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