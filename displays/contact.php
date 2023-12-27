<section class="contact wow bounceInUp">
    <div class="bg-box">
        <div class="icons-container">
            <div class="icons wow bounceInUp" data-wow-delay="0.3s">
                <i class="fas fa-phone"></i>
                <h3>Số điện thoại</h3>
                <p>+84398753790</p>
                <p>+84915037790</p>
            </div>
            <div class="icons wow bounceInUp" data-wow-delay="0.6s">
                <i class="fas fa-envelope"></i>
                <h3>Email</h3>
                <p>shopnongsansach@gmail.com</p>
                <p>duytanbui0600@gmail.com</p>
            </div>
            <div class="icons wow bounceInUp" data-wow-delay="0.9s">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Địa chỉ</h3>
                <p>326 Hà Huy Tâp, Thanh Khuê, Đà Nẵng</p>
            </div>
        </div>
        <?php
        require "Mail/phpmailer/PHPMailerAutoload.php";
           
            $email = "SELECT * FROM nongsansach.taikhoan where Email = 'ngochai777890@gmail.com'";
            $query_email = mysqli_query($connect, $email);
            while ($row_email = mysqli_fetch_assoc($query_email)) {
                if (isset($_POST["noidungcb"])) {
                    if (empty($_POST['noidungcb'])) { //Kiểm tra xem trường content có rỗng không?
                        $error = "Bạn phải nhập nội dung";
                    }
                    if (!isset($error)) {
                        include 'lazy_form/library.php';
                        require 'carbon/vendor/autoload.php';
                        $mail = new PHPMailer(true);
                        try {
                            //Server settings
                            $mail->CharSet = "UTF-8";
                            $mail->SMTPDebug = 0;
                            $mail->isSMTP();
                            $mail->Host = SMTP_HOST;
                            $mail->SMTPAuth = true;
                            $mail->Username = SMTP_UNAME;
                            $mail->Password = SMTP_PWORD;
                            $mail->SMTPSecure = 'ssl';
                            $mail->Port = SMTP_PORT;
                            //Recipients
                            $user = $_SESSION['current_user'];
                            $email = $user['Email'];
                            $mail->setFrom(SMTP_UNAME, $email);
                            $mail->addAddress(SMTP_UNAME, 'Tên người nhận');
                            $mail->addReplyTo(SMTP_UNAME, 'Tên người trả lời');
                            //  $mail->addCC('CCemail@gmail.com');
                            //  $mail->addBCC('BCCemail@gmail.com');
                            $mail->isHTML(true);
                            $mail->Subject = $_POST['chudecb'];
                            $mail->Body = $_POST['noidungcb'];
                            $mail->AltBody = $_POST['noidungcb'];
                            $result = $mail->send();
                            if (!$result) {
                                $error = "Có lỗi xảy ra trong quá trình gửi mail";
                            }
                        } catch (Exception $e) {
                            echo 'Không thể gửi tin nhắn. Lỗi người gửi thư: ', $mail->ErrorInfo;
                        }
                    }
                   
        ?>
                    <div class="container">
                        <?php echo '<script>alert("Gửi email thành công")</script>' ?>;
                    </div>
            <?php
                }
            ?>
                <div class="row wow bounceInUp" data-wow-delay="1.2s">
                    <form id="send-email-form" method="POST">
                        <h3>Liên hệ</h3>
                        <div class="inputBox">
                             <input type="email" name="email" placeholder="Nhập email" class="box" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                            <input type="text" name="sdtcb" placeholder="Nhập số điện thoại" class="box" pattern="((09|03|07|08|05)+([0-9]{8}))">
                            <input type="text" name="chudecb" placeholder="Nhập chủ đề" class="box">
                            <input type="text" name="tencb" placeholder="Nhập tên của bạn" class="box">
                        </div>
                        <textarea placeholder="Nội dung" id="noidungcb" name="noidungcb" cols="30" rows="10"></textarea>
                        <input type="submit" value="Gửi" name="sendmail" class="btn">
                    </form>
                    <img src="./images/download (1).png" alt="">
                </div>
        <?php
            }
        ?>
    </div>
</section>