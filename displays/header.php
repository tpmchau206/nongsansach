<header>
    <div class="header-1">
        <a href="?mod=displays/home" class="logo"></i><img class="logo-header" src="images/logo1.jpg" alt=""></a>
        <form action="?mod=displays/search" method="post" class="search-box-container">
            <input type="text" id="search-box" pattern="[^'\x22]+" autocomplete="off" name="keyword" placeholder="Tìm kiếm ở đây..." minlength="1" required>
            <button type="submit" class="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="header-2">

        <div id="menu-bar" class="fas fa-bars"></div>
        <nav class="navbar">
            <a href="?mod=displays/home">Trang chủ</a>
            <a href="?mod=displays/products">Sản phẩm</a>
            <a href="?mod=displays/contact">Liên hệ</a>
            <a href="?mod=displays/introduce">Giới thiệu</a>
        </nav>

        <div class="icons">
            <?php
            include './displays/ajax/cart/func_getTotalQuantity.php';
            $getTotalQuantity = getTotalQuantity();
            ?>
            <a href="?mod=displays/cart">
                <div class="relative inline-flex">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="flex h-max w-max absolute quantity-cart">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-full w-full bg-red-500 text-white text-xl p-2 leading-none" id="quantity-cart"><?= $getTotalQuantity ?></span>
                    </span>
                </div>
            </a>


            <?php
            if (!empty($_SESSION['current_user'])) {
                $currentUser = $_SESSION['current_user'];
                $sql = "SELECT * FROM nongsansach.taikhoan WHERE MaTK=" . $currentUser['MaTK'];
                $query = mysqli_query($connect, $sql);
                $data = mysqli_fetch_assoc($query);
            ?>
                <div class="dropdown">
                    <img src="<?= $data['AnhDD'] ?>" alt="" height="40" width="40">
                    <div class="dropdown-contents">
                        <div class="display-info">
                            <img src="<?= $data['AnhDD'] ?>" alt="">
                            <h1><?= $data['TenKH'] ?></h1>
                        </div>
                        <hr>
                        <ul>
                            <li><a href="?mod=displays/personalInfo"><i class="fa-solid fa-user"></i> Thông tin cá nhân</a></li>
                            <li><a href="?mod=displays/purchaseOrder"><i class="fa-solid fa-receipt"></i> Đơn mua</a></li>
                            <?php if ($data['MaPQ'] == '1') { ?>
                                <li><a href="./admin/category.php"><i class="fa-solid fa-lock"></i> Quản lý Website</a></li>
                            <?php } ?>

                            <li><a href="displays/logout.php" class=""><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></li>
                        </ul>
                    </div>

                </div>
            <?php
            } else {
            ?>
                <a href="displays/account.php" class="fas fa-user-circle"></a>';
            <?php
            }
            ?>
        </div>
    </div>
</header>