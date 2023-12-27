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