<section class="product wow bounceInUp">
    <div class="bg-box">
        <div class="latest-product">
            <div class="latest-product__text">
                <h4>Sản phẩm tương tự</h4>
                <div class="is-divider"></div>
            </div>
        </div>
        <div class="image-slider">
            <?php
            $slider = "SELECT * FROM nongsansach.sanpham ORDER BY MaSP;";
            $query = mysqli_query($connect, $slider);
            ?>
            <?php foreach ($query as $row) { ?>
                <div class="image-item">
                    <div class="image-latest">
                        <a href="?mod=displays/productDetail&id=<?= $row['MaSP'] ?>"><img src="data:image/png;base64,<?= $row['AnhSP'] ?>" alt="" /></a>
                    </div>
                    <h3 class="image-title"><?= $row['TenSP'] ?></h3>
                    <h3 class="image-price"><?= number_format($row['GiaSP'], 0, ',', '.') ?>₫</h3>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- Latest Product Section Begin -->
<section class="product wow bounceInUp">
    <div class="bg-box">
        <div class="latest-product">
            <div class="box-container1">
                <div class="col1">
                    <div class="latest-product__text">
                        <h4>Sản Phẩm Mới</h4>
                        <!-- <div class="is-divider"></div> -->
                    </div>
                    <?php
                    $sql1 = "SELECT MaSP, TenSP, GiaSP, AnhSP FROM nongsansach.sanpham  ORDER BY MaSP DESC LIMIT 5";
                    $query = mysqli_query($connect, $sql1);

                    while ($row1 = mysqli_fetch_assoc($query)) {
                    ?>
                        <form action="" class="min-h-[150px] wow bounceInUp" method="POST" enctype="multipart/form-data">
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <a href="?mod=displays/productDetail&id=<?= $row1['MaSP'] ?>"><img src="data:image/png;base64,<?= $row1['AnhSP'] ?>" alt=""></a>
                                </div>
                                <div class="latest-product__item__text">
                                    <a href="?mod=displays/productDetail&id=<?= $row1['MaSP'] ?>">
                                        <h6><?= $row1['TenSP'] ?></h6>
                                    </a>
                                    <span><?= number_format($row1['GiaSP'], 0, ',', '.') ?>₫</span>
                                </div>
                            </a>
                        </form>

                    <?php
                    }
                    ?>
                </div>
            </div>

            <div class="box-container1" style="display: none">
                <div class="col1">
                    <div class="latest-product__text">
                        <h4>Sản Phẩm Nổi Bật</h4>
                        <!-- <div class="is-divider"></div> -->
                    </div>
                    <?php
                    $sql1 = "SELECT MaSP, TenSP, GiaSP, AnhSP FROM nongsansach.sanpham ORDER BY RAND() LIMIT 5";
                    $query = mysqli_query($connect, $sql1);

                    while ($row1 = mysqli_fetch_assoc($query)) {
                    ?>
                        <form action="" class="min-h-[150px] wow bounceInUp" data-wow-delay="0.3s" method="POST" enctype="multipart/form-data">
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <a href="?mod=displays/productDetail&id=<?= $row1['MaSP'] ?>"><img src="data:image/png;base64,<?= $row1['AnhSP'] ?>" alt=""></a>
                                </div>
                                <div class="latest-product__item__text">
                                    <a href="?mod=displays/productDetail&id=<?= $row1['MaSP'] ?>">
                                        <h6><?= $row1['TenSP'] ?></h6>
                                    </a>
                                    <span><?= number_format($row1['GiaSP'], 0, ',', '.') ?>₫</span>
                                </div>
                            </a>
                        </form>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <div class="box-container1">
                <div class="col1">
                    <div class="latest-product__text">
                        <h4>Sản Phẩm HOT</h4>
                        <!-- <div class="is-divider"></div> -->
                    </div>
                    <?php
                    $query = mysqli_query($connect, "SELECT sanpham.MaSP,TenSP,AnhSP,GiaSP,SUM(SoLuongMua) FROM nongsansach.sanpham INNER JOIN nongsansach.chitietdonhang ON chitietdonhang.MaSP=sanpham.MaSP GROUP BY MaSP ORDER BY SoLuongMua DESC LIMIT 5;");
                    while ($row1 = mysqli_fetch_assoc($query)) {
                    ?>
                        <form action="" class="min-h-[150px] wow bounceInUp" data-wow-delay="0.6s" method="POST" enctype="multipart/form-data">
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <a href="?mod=displays/productDetail&id=<?= $row1['MaSP'] ?>"><img src="data:image/png;base64,<?= $row1['AnhSP'] ?>" alt=""></a>
                                </div>
                                <div class="latest-product__item__text">
                                    <a href="?mod=displays/productDetail&id=<?= $row1['MaSP'] ?>">
                                        <h6><?= $row1['TenSP'] ?></h6>
                                    </a>
                                    <span><?= number_format($row1['GiaSP'], 0, ',', '.') ?>₫</span>
                                </div>
                            </a>
                        </form>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <div class="box-container1">
                <div class="col1">
                    <div class="latest-product__text">
                        <h4>Sản Phẩm</h4>
                        <!-- <div class="is-divider"></div> -->
                    </div>
                    <?php
                    $sql1 = "SELECT MaSP, TenSP, GiaSP, AnhSP FROM nongsansach.sanpham ORDER BY RAND() LIMIT 5";
                    $query = mysqli_query($connect, $sql1);

                    while ($row1 = mysqli_fetch_assoc($query)) {
                    ?>
                        <form action="" class="min-h-[150px] wow bounceInUp" data-wow-delay="0.9s" method="POST" enctype="multipart/form-data">
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <a href="?mod=displays/productDetail&id=<?= $row1['MaSP'] ?>"><img src="data:image/png;base64,<?= $row1['AnhSP'] ?>" alt=""></a>
                                </div>
                                <div class="latest-product__item__text">
                                    <a href="?mod=displays/productDetail&id=<?= $row1['MaSP'] ?>">
                                        <h6><?= $row1['TenSP'] ?></h6>
                                    </a>
                                    <span><?= number_format($row1['GiaSP'], 0, ',', '.') ?>₫</span>
                                </div>
                            </a>
                        </form>
                    <?php
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</section>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>