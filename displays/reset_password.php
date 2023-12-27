<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/account.css">
  <script src="../js/fontawesome.js"></script>
  <style>
    .form-control {
      display: inline-block !important;
    }

    .show1 {
      position: absolute;
      right: 25px;
      line-height: 2.5;
    }

    .show2 {
      position: absolute;
      right: 25px;
      line-height: 2.5;
    }
  </style>

</head>

<body>
    <div class="container">
      <div class="card">
        <div class="card-header text-center">
          Reset Password
        </div>
        <div class="card-body">
          <?php
          if ($_GET['key'] && $_GET['token']) {
            include "../db/config.php";

            $email = $_GET['key'];
            $token = $_GET['token'];
            $query = mysqli_query(
              $connect,
              "SELECT * FROM nongsansach.taikhoan WHERE `Email`='" . $email . "';"
            );
            //   $curDate = date("Y-m-d H:i:s");
            if (mysqli_num_rows($query) > 0) {
              $row = mysqli_fetch_array($query);
              //   if($row['exp_date'] >= $curDate 
          ?>
              <form action="update-forget-password.php" method="post">
                <input type="hidden" name="email" value="<?php echo $email; ?>">
                <input type="hidden" name="reset_link_token" value="<?php echo $token; ?>">
                <input type="hidden" name='passcu' value="<?php echo $row['Pass']?>">
                <div class="form-group">
                  <label for="exampleInputEmail1">Mật khẩu</label>
                  <input type="password" name='password' class="form-control field1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                  <span class="show1" onclick="show_Pass(1)"><i class="fa-solid fa-eye"></i></span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Nhập lại mật khẩu</label>
                  <input type="password" name='cpassword' class="form-control field2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                  <span class="show2" onclick="show_Pass(2)"><i class="fa-solid fa-eye"></i></span>
                </div>
                <input type="submit" name="new-password" class="btn btn-primary">
              </form>
          <?php
              // <p>This forget password link has been expired</p>
            }
          }
          ?>
        </div>
      </div>
    </div>
  <script>
    function show_Pass(p) {
      const passField = document.querySelector(".form-group .field" + p);
      const showBtn = document.querySelector(".show" + p + " i");
      if (passField.type === "password") {
        passField.type = "text";
        showBtn.classList.replace("fa-eye", "fa-eye-slash");
      } else {
        passField.type = "password";
        showBtn.classList.replace("fa-eye-slash", "fa-eye");
      }

    }
  </script>
</body>

</html>