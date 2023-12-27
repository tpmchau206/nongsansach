<?php
include '../db/config.php';
include './header.php';
if (!empty($_SESSION['current_user'])) {
?>
	<h1><?= !empty($_GET['id'])?></h1>
	<div id="content-box">
		<?php
		if (isset($_GET['action']) && ($_GET['action'] == 'add')) {
			if (isset($_POST['tenam'])) {
				$rname = $_POST['tenam'];
				$remail = $_POST['emailam'];
				$rpass = md5($_POST['matkhauam']);
				$rrpass = md5($_POST['matkhauamm']);
				if (empty($rname)) {
					$err['tenam'] = 'Bạn chưa nhập tên';
				}
				if (empty($remail)) {
					$err['emailam'] = 'Bạn chưa nhập email';
				}
				if (empty($rpass)) {
					$err['matkhauam'] = 'Bạn chưa nhập mật khẩu';
				}
				if ($rpass != $rrpass) {
					$err['matkhauamm'] = 'Mật khẩu nhập lại không đúng';
				}
				if (!isset($error)) {
					$checkExistUser = mysqli_query($connect, "SELECT * FROM nongsansach.taikhoan WHERE Email = '" . $remail . "'");
					if ($checkExistUser->num_rows != 0) { //tồn tại user rồi
						$error = "Email đã tồn tại. Bạn vui lòng chọn email khác";
					} elseif($rpass == $rrpass) {
						if ($_GET['action'] == 'add') { //thêm nhân viên
                            $result = mysqli_query($connect, "INSERT INTO nongsansach.taikhoan(Email,Pass,TenKH,AnhDD,TinhTrang,MaPQ) VALUES ('$remail','$rpass','$rname','images/User-blue-icon.png','0','2')");
						}
					}else{
						echo "<script>alert('Mật khẩu mới và mật khẩu nhập lại của bạn không khớp');window.location='member_listing.php'</script>";
					}
					
				}
			} else {
				$error = "Bạn chưa nhập thông tin nhân viên.";
			}
		?>
			<div class="container">
				<div class="error"><?= isset($error) ? $error : "Thêm mới thành công" ?></div>
				<a href="member_listing.php">Quay lại danh sách nhân viên</a>
			</div>
		<?php
		} else {
			if (!empty($_GET['id'])) {
				$result = mysqli_query($connect, "SELECT * FROM nongsansach.taikhoan WHERE MaTK = " . $_GET['id']);
				$user = $result->fetch_assoc();
			}
		?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6">
						<div class="panel-info">
							<div class="table-list">
								<div class="panel-body">
									<form id="editing-form" method="POST" action="<?= (!empty($user) && !isset($_GET['task'])) ? $_GET['id'] : "?action=add" ?>" enctype="multipart/form-data">
										<legend>Đăng ký tài khoản</legend>
										<div class="form-group">
											<label>Tên đăng ký: </label>
											<input type="text" class="form-control" id="" placeholder="Nhập tên đăng ký" value="<?= !empty($user) ? $user['TenKH'] : "" ?>" name="tenam" required>
										</div>

										<div class="form-group">
											<label>Email đăng ký: </label>
											<input type="text" class="form-control" id="" placeholder="Nhập email đăng ký" value="<?= (!empty($user) ? $user['Email'] : "") ?>" name="emailam" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
										</div>

										<div class="form-group">
											<label for="">Nhập mật khẩu: </label>
											<input type="password" class="form-control" id="" placeholder="Nhập mật khẩu" name="matkhauam" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
										</div>

										<div class="form-group">
											<label for="">Nhập lại mật khẩu: </label>
											<input type="password" class="form-control" id="" placeholder="Nhập lại mật khẩu" name="matkhauamm" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
										</div>
										<button type="submit" class="btn btn-primary">Đăng ký</button>
										</form>
									<div class="clear-both"></div>
								<?php } ?>
								</div>
							</div>

						<?php
					}
					include './footer.php';
						?>