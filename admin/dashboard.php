<?php include './header.php' ?>

<p style="font-size:1.2rem;">Thống kê đơn hàng theo : <span id="text-date"></span></p>
<p>
	<select class="select-date">
		<option value="7ngay">1 tuần</option>
		<option value="28ngay">1 tháng</option>
		<option value="90ngay">3 tháng</option>
		<option value="365ngay">1 năm</option>
	</select>
</p>
<div id="myfirstchart" style="height: 250px;"></div>

<?php include './footer.php' ?>