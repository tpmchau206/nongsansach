<?php
include '../db/config.php';
?>
<?php include './header.php' ?>
<div class="row" style="padding: 0 20px; margin-top:20px;">
	<div class="col-lg-4 col-sm-6 col-xs-12">
		<div class="white-box analytics-info">
			<?php
			$querydh = mysqli_query($connect, "SELECT * FROM nongsansach.donhang");
			$numberdh = mysqli_num_rows($querydh);
			?>
			<h3 class="box-title">Tổng số đơn hàng</h3>
			<ul class="list-inline two-part">
				<li>
					<div id="sparklinedash"></div>
				</li>
				<li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success"><?= $numberdh ? '' . $numberdh . '' : '' ?></span></li>
			</ul>
		</div>
	</div>
	<?php
	$user = $_SESSION['current_user'];
	if (!empty($user)) {
	?>
		<div class="col-lg-4 col-sm-6 col-xs-12">
			<div class="white-box analytics-info">
				<?php
				$querytk = mysqli_query($connect, "SELECT * FROM nongsansach.taikhoan where MaPQ='3'");
				$numberstk = mysqli_num_rows($querytk);
				?>
				<h3 class="box-title">Tổng tài khoản khách hàng</h3>
				<ul class="list-inline two-part">
					<li>
						<div id="sparklinedash2"></div>
					</li>
					<li class="text-right"><i class="ti-arrow-up text-purple"></i> <span class="counter text-purple"><?= $numberstk ? '' . $numberstk . '' : '' ?></span></li>
				</ul>
			</div>
		</div>
	<?php
	}
	?>
	<?php
	$sql = mysqli_query($connect,"SELECT  sum(DoanhThu)
	FROM nongsansach.thongke
	WHERE month(NgayDat)=5 AND year(NgayDat)=2022
	GROUP BY month(NgayDat)");
	$numberdt = mysqli_fetch_assoc($sql);
	$doanht = implode(" ",$numberdt);
	?>
	<div class="col-lg-4 col-sm-6 col-xs-12">
		<div class="white-box analytics-info">
			<h3 class="box-title">Doanh thu theo tháng</h3>
			<ul class="list-inline two-part">
				<li>
					<div id="sparklinedash3"></div>
				</li>
				<li class="text-right"><i class="ti-arrow-up text-info"></i> <span class="counter text-info"><?= number_format($doanht)?></span></li>
			</ul>
		</div>
	</div>
</div>
<div class="static" style="padding:0 20px;">
	<p style="font-size:1.2rem;">Thống kê đơn hàng theo: <span id="text-date"></span></p>
	<p>
		<select class="select-date">
			<option value="7ngay">1 tuần</option>
			<option value="28ngay">1 tháng</option>
			<option value="90ngay">3 tháng</option>
			<option value="365ngay">1 năm</option>
		</select>
	</p>
	<div id="myfirstchart" style="height: 250px;"></div>
</div>

<?php include './footer.php' ?>