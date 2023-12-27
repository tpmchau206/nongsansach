<?php
if (isset($_POST['password-reset-token']) && $_POST['email']) {
  include "../db/config.php";

  $emailId = $_POST['email'];
  $result = mysqli_query($connect, "SELECT * FROM nongsansach.taikhoan WHERE Email='" . $emailId . "'");
  $query = mysqli_num_rows($result);
  $row = mysqli_fetch_array($result);
  
  if (mysqli_num_rows($result) <= 0) {
?>
    <script>
      alert("<?php echo "Xin lỗi, gửi mail không thành công " ?>");
      window.location.replace("../displays/account.php");
    </script>
  <?php
  } else if ($row["TinhTrang"] == 1) {
  ?>
    <script>
      alert("Vui lòng xác minh tài khoản của bạn, trước khi bạn khôi phục mật khẩu của mình !");
      window.location.replace("../displays/account.php");
    </script>
    <?php
  } elseif ($row) {

    $token = md5($emailId) . rand(10, 9999);

    $update = mysqli_query($connect, "UPDATE nongsansach.taikhoan set  Pass='" . $password . "' WHERE Email='" . $emailId . "' and Pass=".$old_pass."");
    $link = "<a href='http://localhost/nongsansach/displays/reset_password.php?key=" . $emailId . "&token=" . $token . "'>Click To Reset password</a>";
    require "../Mail/phpmailer/PHPMailerAutoload.php";
    $mail = new PHPMailer();
    $mail->CharSet =  "utf-8";
    $mail->IsSMTP();
    // enable SMTP authentication
    $mail->SMTPAuth = true;
    // GMAIL username
    $mail->Username = "ngochai777890@gmail.com";
    // GMAIL password
    $mail->Password = "yjkonjbapbqqeoin";
    $mail->SMTPSecure = "ssl";
    // sets GMAIL as the SMTP server
    $mail->Host = "smtp.gmail.com";
    // set the SMTP port for the GMAIL server
    $mail->Port = "465";
    $mail->From = 'ngochai777890@gmail.com';
    $mail->FromName = 'Website nongsansach.vn';
    $mail->AddAddress($_POST["email"]);
    $mail->Subject  =  'Khoi phuc mat khau';
    $mail->IsHTML(true);
    $mail->Body    = 'Nhấp vào liên kết này để đặt lại mật khẩu ' . $link . '';
    if (!$mail->send()) {
    ?>
      <script>
        alert("<?php echo " Email không hợp lệ " ?>");
      </script>
    <?php
    } else {
    ?>
      <script>
        window.location.replace("../lazy_form/captcha/notification.html");
      </script>
<?php
    }
  }
}
?>