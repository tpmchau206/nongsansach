<?php
$sqlCat = "SELECT * FROM nongsansach.danhmuc WHERE MaDM =" . $_GET['id'];
$kqCat = mysqli_query($connect, $sqlCat);
$datacat = mysqli_fetch_row($kqCat);

?>

<section class="product" id="product">
    <div class="bg-box">

        <h1 class="heading">Sản phẩm <?php echo $datacat[1] ?> </h1>

        <div class="box-container">

            <?php
            $sql = "SELECT * FROM nongsansach.sanpham inner join nongsansach.donvitinh on sanpham.MaDV=donvitinh.MaDV
        where MaDM = " . $_GET['id'];
            $query = mysqli_query($connect, $sql);
            while ($row = mysqli_fetch_array($query)) {

            ?>
                <form action="" method="POST" class="quick-by-form box">
                    <!-- <span class="discount">-33%</span> -->

                    <a href="?mod=displays/productDetail&id= <?= $row['MaSP'] ?>"><img src="data:image/png;base64,<?= $row['AnhSP'] ?>" alt=""></a>
                    <h3><?= $row['TenSP'] ?></h3>

                    <div class="price"><?= number_format($row['GiaSP'], 0, ',', '.') ?>₫</div>
                    <?php
                    if ($row['SoLuong'] > 0) {
                    ?>
                        <div class="quantity">
                            <span>Số lượng : </span>
                            <input type="number" min="1" max="1000" value="1" name="quantity[<?= $row['MaSP'] ?>]">
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
            <?php
            }
            ?>
        </div>
    </div>
</section>