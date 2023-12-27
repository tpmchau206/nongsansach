<!-- Latest Product Section Begin -->
<div class="latest-product">
    <div class="box-container1">
        <div class="col1">
            <div class="latest-product__text">
                <h4>Ưu Đãi</h4>
                <div class="is-divider"></div>
            </div>
            <?php
            $sql1 = "SELECT MaSP, TenSP, GiaSP, AnhSP FROM nongsansach.sanpham  ORDER BY RAND() LIMIT 5";
            $query = mysqli_query($connect, $sql1);

            while ($row1 = mysqli_fetch_assoc($query)) {
            ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <a href="#" class="latest-product__item">
                        <div class="latest-product__item__pic">
                            <a href="?mod=displays/productDetail&id=<?= $row1['MaSP'] ?>"><img src="uploads/<?= $row1['AnhSP'] ?>" alt=""></a>
                        </div>
                        <div class="latest-product__item__text">
                            <a href="?mod=displays/productDetail&id=<?= $row1['MaSP'] ?>">
                                <h6><?= $row1['TenSP'] ?></h6>
                            </a>
                            <span><?= number_format($row1['GiaSP'], 0, ',', '.') ?>₫</span>
                        </div>
                    </a>
                    <div class="is-divider__dr"></div>
                </form>

            <?php
            }
            ?>
        </div>
    </div>

    <div class="box-container1">
        <div class="col1">
            <div class="latest-product__text">
                <h4>Sản Phẩm Nổi Bật</h4>
                <div class="is-divider"></div>
            </div>
            <?php
            $sql1 = "SELECT MaSP, TenSP, GiaSP, AnhSP FROM nongsansach.sanpham ORDER BY RAND() LIMIT 5";
            $query = mysqli_query($connect, $sql1);

            while ($row1 = mysqli_fetch_assoc($query)) {
            ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <a href="#" class="latest-product__item">
                        <div class="latest-product__item__pic">
                            <a href="?mod=displays/productDetail&id=<?= $row1['MaSP'] ?>"><img src="uploads/<?= $row1['AnhSP'] ?>" alt=""></a>
                        </div>
                        <div class="latest-product__item__text">
                            <a href="?mod=displays/productDetail&id=<?= $row1['MaSP'] ?>">
                                <h6><?= $row1['TenSP'] ?></h6>
                            </a>
                            <span><?= number_format($row1['GiaSP'], 0, ',', '.') ?>₫</span>
                        </div>
                    </a>
                    <div class="is-divider__dr"></div>
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
                <div class="is-divider"></div>
            </div>
            <?php
            $sql1 = "SELECT MaSP, TenSP, GiaSP, AnhSP FROM nongsansach.sanpham ORDER BY RAND() LIMIT 5";
            $query = mysqli_query($connect, $sql1);

            while ($row1 = mysqli_fetch_assoc($query)) {
            ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <a href="#" class="latest-product__item">
                        <div class="latest-product__item__pic">
                            <a href="?mod=displays/productDetail&id=<?= $row1['MaSP'] ?>"><img src="uploads/<?= $row1['AnhSP'] ?>" alt=""></a>
                        </div>
                        <div class="latest-product__item__text">
                            <a href="?mod=displays/productDetail&id=<?= $row1['MaSP'] ?>">
                                <h6><?= $row1['TenSP'] ?></h6>
                            </a>
                            <span><?= number_format($row1['GiaSP'], 0, ',', '.') ?>₫</span>
                        </div>
                    </a>
                    <div class="is-divider__dr"></div>
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
                <div class="is-divider"></div>
            </div>
            <?php
            $sql1 = "SELECT MaSP, TenSP, GiaSP, AnhSP FROM nongsansach.sanpham ORDER BY RAND() LIMIT 5";
            $query = mysqli_query($connect, $sql1);

            while ($row1 = mysqli_fetch_assoc($query)) {
            ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <a href="#" class="latest-product__item">
                        <div class="latest-product__item__pic">
                            <a href="?mod=displays/productDetail&id=<?= $row1['MaSP'] ?>"><img src="uploads/<?= $row1['AnhSP'] ?>" alt=""></a>
                        </div>
                        <div class="latest-product__item__text">
                            <a href="?mod=displays/productDetail&id=<?= $row1['MaSP'] ?>">
                                <h6><?= $row1['TenSP'] ?></h6>
                            </a>
                            <span><?= number_format($row1['GiaSP'], 0, ',', '.') ?>₫</span>
                        </div>
                    </a>
                    <div class="is-divider__dr"></div>
                </form>
            <?php
            }
            ?>
        </div>
    </div>

</div>