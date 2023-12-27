<?php
include '../db/config.php';
include '../api/google_source.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $pass = md5($_POST['pass']);
    $queryEmail = mysqli_query($connect, "SELECT * FROM nongsansach.taikhoan WHERE Email='" . $email . "' LIMIT 1");
    $data = mysqli_fetch_assoc($queryEmail);
    $checkEmail = mysqli_num_rows($queryEmail);
    if ($checkEmail == 1) {
        if ($data['Pass'] == $pass) {
            $userPrivileges = mysqli_query($connect, "SELECT * FROM nongsansach.taikhoan_phanquyen INNER JOIN nongsansach.phanquyen_nhanvien ON taikhoan_phanquyen.MaPQNV = phanquyen_nhanvien.MaPQNV 
            WHERE taikhoan_phanquyen.MaTK = " . $data['MaTK']);
            $userPrivileges = mysqli_fetch_all($userPrivileges, MYSQLI_ASSOC);
            if (!empty($userPrivileges)) {
                $data['privileges'] = array();
                foreach ($userPrivileges as $privilege) {
                    $data['privileges'][] = $privilege['DuongDanUrl'];
                }
            }
            if ($data['TinhTrang'] == 0) {
                $_SESSION['current_user'] = $data['TinhTrang'];
                $_SESSION['current_user'] = $data;

                if ($data['MaPQ'] == '1' || $data['MaPQ'] == '2') {
                    header('location: ../admin/category.php');
                } elseif ($data['MaPQ'] == '3') {
                    header('location: ../index.php');
                }
                if (isset($_POST['remember'])) {
                    setcookie('email', $email, time() + 999999999, '/', '', 0, 0);
                    setcookie('pass', $_POST['pass'], time() + 999999999, '/', '', 0, 0);
                }
            } else {
                $err['Email'] = 'Tài khoản của bạn đã bị khóa';
            }
        } else {
            $err['Pass'] = 'Không đúng mật khẩu';
        }
    } else {
        $err['Email'] = 'Email không tồn tại';
    }
}
if (isset($_POST['rName'])) {
    $rname = $_POST['rName'];
    $remail = $_POST['rEmail'];
    $rpass = md5($_POST['rPass']);
    $rrpass = md5($_POST['rrPass']);
    if (empty($rname)) {
        $err['rName'] = 'Bạn chưa nhập tên';
    }
    if (empty($remail)) {
        $err['rEmail'] = 'Bạn chưa nhập email';
    }
    if (empty($rpass)) {
        $err['rPass'] = 'Bạn chưa nhập mật khẩu';
    }
    if ($rpass != $rrpass) {
        $err['rrPass'] = 'Mật khẩu nhập lại không đúng';
    }
    $sql2 = "SELECT * FROM nongsansach.taikhoan WHERE Email='$remail'";
    $query2 = mysqli_query($connect, $sql2);
    $data2 = mysqli_fetch_array($query2);
    $checkEmail2 = mysqli_num_rows($query2);
    if ($remail == $data2['Email']) {
        echo "<script>alert('Tài khoản này đã tồn tại')</script>";
    } else if (empty($err)) {
        $sql3 = "INSERT INTO nongsansach.taikhoan(Email,Pass,TenKH,AnhDD,LoaiTK,TinhTrang,NgayTao,MaPQ) VALUES ('$remail','$rpass','$rname','images/User-blue-icon.png','Thường','1',NOW(),'3')";
        GuiMail($remail, $rname);
        $query3 = mysqli_query($connect, $sql3);
        if ($query3) {
            echo "<script>alert('Đăng ký thành công, mã OTP đã được gửi tới gmail của bạn');window.location='../displays/verification.php'</script>";
            // header('location: ../displays/verification.php');
        } else {
            echo '<script>alert("Đăng ký thất bại")</script>';
        }
    }
}
?>

<?php
function GuiMail($remail, $rname)
{
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['Email'] = $remail;
    require "../Mail/phpmailer/PHPMailerAutoload.php";
    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';

    $mail->Username = 'ngochai777890@gmail.com';
    $mail->Password = 'yjkonjbapbqqeoin';

    $mail->setFrom('ngochai777890@gmail.com', 'OTP Verification');
    $mail->addAddress($remail, $rname);

    $mail->isHTML(true);
    $mail->Subject = "Ma xac minh cua ban";
    $mail->Body = "<h3>Mã OTP của bạn là $otp <br></h3>";

    if (!$mail->send()) {
?>
<?php
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/account.css">
    <script src="../js/fontawesome.js"></script>
    <!-- <script src="./js/jquery-3.6.0.js"></script> -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <title>Nông sản sạch</title>
</head>

<body>
    <div class="banner">
        <div class="form-box">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn" onclick="login()">Đăng Nhập</button>
                <button type="button" class="toggle-btn" onclick="register()">Đăng Ký</button>
            </div>
            <form action="" method="POST" class="input-group" id="login">
                <div class="email">
                    <input type="email" class="input-field" placeholder="Email" name="email" id="email" value="<?php if (isset($_COOKIE['email'])) echo $_COOKIE['email']; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                    <span class="login-sp"><?= (isset($err['Email'])) ? $err['Email'] : '' ?></span>
                </div>
                <div class="password">
                    <input type="password" class="input-field field1" placeholder="Mật Khẩu" name="pass" id="pass" value="<?php if (isset($_COOKIE['pass'])) echo $_COOKIE['pass']; ?>" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                    <span class="btn-show show1" onclick="show_Pass(1)"><i class="fa-solid fa-eye"></i></span>
                </div>
                <span class="login-sp"><?php echo (isset($err['Pass'])) ? $err['Pass'] : '' ?></span>
                <br>
                <input type="checkbox" id="remember" name="remember" value="" <?php isset($_COOKIE['email']) ? print 'checked' : print ''; ?>><label for="remember"> Nhớ mật khẩu</label>
                <br>
                <br>
                <button type="submit" class="submit-btn" id="login">Đăng Nhập</button>
                <p style="margin-top: 1.2rem; text-align:center">
                    <a href="../displays/passwordrecove.php">Quên mật khẩu?</a>.
                </p>
            </form>

            <form action="" method="POST" class="input-group" id="register">
                <div class="name">
                    <input type="text" class="input-field" minlength="2" placeholder="Họ và tên" name="rName" required>
                </div>
                <span class="login-sp"><?php echo (isset($err['Email'])) ? $err['Email'] : '' ?></span>
                <div class="email">
                    <input type="email" class="input-field" placeholder="Địa chỉ email" name="rEmail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                </div>
                <span class="login-sp"><?php echo (isset($err['rEmail'])) ? $err['rEmail'] : '' ?></span>
                <!-- ràng buộc: Phải chứa ít nhất một số và một chữ cái viết hoa và viết thường và ít nhất 8 ký tự trở lên -->
                <div class="password">
                    <input type="password" id="password" class="input-field field2" placeholder="Mật Khẩu" name="rPass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength="8" required>
                    <span class="btn-show show2" onclick="show_Pass(2)"><i class="fa-solid fa-eye"></i></span>
                </div>
                <span class="login-sp"><?php echo (isset($err['rPass'])) ? $err['rPass'] : '' ?></span>
                <div class="password">
                    <input type="password" id="rpassword" class="input-field field3" placeholder="Nhập Lại Mật Khẩu" name="rrPass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                    <span class="btn-show show3" onclick="show_Pass(3)"><i class="fa-solid fa-eye"></i></span>
                </div>
                <span class="login-sp" id="notifyPass"><?php echo (isset($err['rrPass'])) ? $err['rrPass'] : '' ?></span>
                <br>
                <br>
                <button type="submit" class="submit-btn">Đăng Ký</button>

            </form>
            <div class="social-icons">
                <div class="or">
                    <div class="hr"></div>
                    <span>Hoặc</span>
                    <div class="hr"></div>
                </div>
                <a href="<?= $authUrl ?>">
                    <div class="btn-gg">
                        <img src="../images/google.png">Đăng nhập với Google
                    </div>
                </a>
            </div>
        </div>
    </div>
    <script src="../js/jquery-3.6.0.js"></script>
    <script>
        var x = document.getElementById("login");
        var y = document.getElementById("register");
        var z = document.getElementById("btn")

        function register() {
            x.style.left = "-400px";
            y.style.left = "50px";
            z.style.left = "140px";
        }

        function login() {
            x.style.left = "50px";
            y.style.left = "450px";
            z.style.left = "0px";
        }
    </script>
    <script>
        function show_Pass(p) {
            const passField = document.querySelector(".password .field" + p);
            const showBtn = document.querySelector(".show" + p + " i");
            if (passField.type === "password") {
                passField.type = "text";
                showBtn.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                passField.type = "password";
                showBtn.classList.replace("fa-eye-slash", "fa-eye");
            }

        }
        // const password = document.getElementById("password");
        // const rpassword = document.getElementById("rpassword");
        // const notify = "Mật khẩu nhập lại không đúng!"
        // if (rpassword != password) {
        //     document.getElementById('notifyPass').innerText = notify;
        // }
    </script>

</body>

</html>