<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Ample lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Ample admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description" content="Ample Admin Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>Trang quản trị</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
    <!-- Custom CSS -->
    <link href="plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
    <!-- Custom CSS -->
    <link href="css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/account.css">
    <link rel="stylesheet" href="../css/admin_css.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="../js/fontawesome.js" crossorigin="anonymous"></script>
    <script src="../js/jquery-3.6.0.js"></script>
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!-- <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div> -->
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->

        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="#">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!-- Dark Logo icon -->
                            <img src="plugins/images/logo-icon.png" alt="homepage" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="plugins/images/logo-text.png" alt="homepage" />
                        </span>
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">

                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav ms-auto d-flex align-items-center">

                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">

                        <!-- User Profile-->
                        <?php
                        include '../db/config.php';
                        include '../lazy_form/function.php';
                        $regexResult = checkPrivilege(); //Kiểm tra quyền thành viên
                        if (!$regexResult) {
                            echo "<script>alert('Bạn không có quyền truy cập chức năng này');window.location='../displays/account.php'</script>";
                            exit;
                        }

                        if (!empty($_SESSION['current_user'])) { //Kiểm tra xem đã đăng nhập chưa?
                        ?>
                            <li class="sidebar-item pt-2">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="../index.php" aria-expanded="false">
                                    <i class="fa-solid fa-house"></i>
                                    <span class="hide-menu">Về trang chủ</span>
                                </a>
                            </li>
                            <?php if (checkPrivilege('category.php')) { ?>
                                <li class="sidebar-item pt-2">
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="category.php" aria-expanded="false">
                                        <i class="fa fa-table" aria-hidden="true"></i>
                                        <span class="hide-menu">Quản lý danh mục</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (checkPrivilege('unit.php')) { ?>
                                <li class="sidebar-item pt-2">
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="unit.php" aria-expanded="false">
                                        <i class="fa fa-table" aria-hidden="true"></i>
                                        <span class="hide-menu">Quản lý đơn vị</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (checkPrivilege('product.php')) { ?>
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="product.php" aria-expanded="false">
                                        <i class=" fa fa-shopping-bag" aria-hidden="true"></i>
                                        <span class="hide-menu">Quản lý sản phẩm</span>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPrivilege('order.php')) { ?>
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="order.php" aria-expanded="false">
                                        <i class=" fa fa-truck" aria-hidden="true"></i>
                                        <span class="hide-menu">Danh sách đơn hàng</span>
                                    </a>
                                </li>
                            <?php } ?>



                            <?php if (checkPrivilege('customer.php')) { ?>
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="customer.php" aria-expanded="false">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        <span class="hide-menu">Danh sách khách hàng</span>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPrivilege('statistic.php')) { ?>
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="statistic.php" aria-expanded="false">
                                        <i class="fa fa-signal" aria-hidden="true"></i>
                                        <span class="hide-menu">Báo cáo thống kê</span>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (checkPrivilege('member_listing.php')) { ?>
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="member_listing.php" aria-expanded="false">
                                        <i class="fa fa-user-md" aria-hidden="true"></i>
                                        <span class="hide-menu">Quản lý nhân viên</span>
                                    </a>
                                </li>
                            <?php } ?>



                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                    <i class="fa fa-user-md"></i>
                                    <span class="hide-menu">Quản lý trang web</span>
                                </a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    <?php if (checkPrivilege('slider.php')) { ?>
                                        <li class="sidebar-item">
                                            <a href="slider.php" class="sidebar-link waves-effect waves-dark sidebar-link" href="slider.php" aria-expanded="false">
                                                <i class="fa fa-sliders-h" aria-hidden="true"></i>
                                                <span class="hide-menu">Quản lý slide</span>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <?php if (checkPrivilege('transport.php')) { ?>
                                        <li class="sidebar-item">
                                            <a href="transport.php" class="sidebar-link waves-effect waves-dark sidebar-link" href="transport.php" aria-expanded="false">
                                                <i class="fa fa-user-md" aria-hidden="true"></i>
                                                <span class="hide-menu">Quản lý vận chuyển</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li class="sidebar-item logout">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link " href="../displays/logout.php">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                    <?php
                                    if (isset($_SESSION['current_user'])) {
                                    ?>
                                        <span class="hide-menu">Đăng xuất: <?php echo $_SESSION['current_user']['TenKH']; ?></span><?php } ?></a>
                            </li>
                        <?php
                        } ?>

                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>

            <!-- End Sidebar scroll-->
        </aside>

        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- Container fluid  -->
            <!-- ============================================================== -->