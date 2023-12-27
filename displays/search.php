<?php
if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
    $sql1 = "SELECT * FROM nongsansach.sanpham
    inner join nongsansach.danhmuc on sanpham.MaDM=danhmuc.MaDM
    inner join nongsansach.donvitinh on sanpham.MaDV=donvitinh.MaDV
    WHERE LOWER(TenSP) LIKE CONCAT(CONVERT('%$keyword%', BINARY))
    OR LOWER(GiaSP) LIKE CONCAT(CONVERT('%$keyword%', BINARY))";
    $query1 = mysqli_query($connect, $sql1);
}
// if (isset($_POST['keyword'])) {
//     $keyword = $_POST['keyword'];
//     $sql1 = "SELECT * FROM nongsansach.sanpham 
//     inner join nongsansach.danhmuc on sanpham.MaDM=danhmuc.MaDM 
//     inner join nongsansach.donvitinh on sanpham.MaDV=donvitinh.MaDV 
//     WHERE TenSP LIKE '%$keyword%'
//     --  WHERE LOWER(TenSP) LIKE CONCAT(CONVERT('%$keyword%', BINARY))
//     OR TenDM LIKE '[%$keyword%]' ";
//     $query1 = mysqli_query($connect, $sql1);
// }
?>

<section class="product" id="product">
    <div class="bg-box">
        <h1 class="heading">Kết quả tìm kiếm cho: <span>"<?php echo $keyword; ?>"</span></h1>
        <div class="box-container">
            <?php
            $check = mysqli_num_rows($query1);
            if (!empty($check)) {
                while ($row = mysqli_fetch_assoc($query1)) {
            ?>
                    <form action="?mod=displays/cart&action=add" method="POST" class="quick-by-form box">

                        <a href="?mod=displays/productDetail&id= <?= $row['MaSP'] ?>"><img src="data:image/png;base64,<?= $row['AnhSP'] ?>" alt=""></a>
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
                <?php
                }
                ?>
        </div>
    <?php } else { ?>
        <div class="notify">
            <img src="./images/search-icon-product.png" alt="">
            <span>Không có sản phẩm nào</span>
        </div>
    <?php
            }
    ?>
    </div>
</section>