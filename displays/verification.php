<?php include '../lazy_form/phantrang/header_recovepw.php' ?>


    <nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Xác minh tài khoản</div>
                        <div class="card-body">
                            <form action="#" method="POST">
                                <div class="form-group row">
                                    <label for="email_address" class="col-md-4 col-form-label text-md-right">OTP Code</label>
                                    <div class="col-md-6">
                                        <input type="text" id="otp" class="form-control" name="otp_code" required autofocus>
                                    </div>
                                </div>

                                <div class="col-md-6 offset-md-4">
                                    <input type="submit" value="Verify" name="verify">
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </main>
</body>

</html>
<?php
include('../db/config.php');
if (isset($_POST["verify"])) {
    $otp = $_SESSION['otp'];
    $email = $_SESSION['Email'];
    $otp_code = $_POST['otp_code'];
    $status =0;
    if ($otp != $otp_code) {
?>
        <script>
            alert("Sai mã xác nhận");
        </script>
    <?php
    } else {
        mysqli_query($connect, "UPDATE nongsansach.taikhoan SET TinhTrang='$status' where Email = '$email'");
    ?>
        <script>
            alert("Mã xác nhận chính xác, mời bạn tới trang đăng nhập");
            window.location.replace("../displays/account.php");
        </script>
<?php
    }
}

?>