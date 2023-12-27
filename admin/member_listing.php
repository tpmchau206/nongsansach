<?php
include '../db/config.php';
include './header.php';
$config_name = "member";
$config_title = "nhân viên";
if (!empty($_SESSION['current_user'])) {
	$where = "MaTK != " . $_SESSION['current_user']['MaTK'];
	// $item_per_page = (!empty($_GET['per_page'])) ? $_GET['per_page'] : 10;
	// $current_page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
	// $offset = ($current_page - 1) * $item_per_page;
	if (!empty($where)) {
		$totalRecords = mysqli_query($connect, "SELECT * FROM nongsansach.taikhoan where (" . $where . ")");
	} else {
		$totalRecords = mysqli_query($connect, "SELECT * FROM nongsansach.taikhoan");
	}
	$totalRecords = $totalRecords->num_rows;
	$totalPages = ceil($totalRecords );
	// / $item_per_page
	if (!empty($where)) {
		$products = mysqli_query($connect, "SELECT * FROM nongsansach.taikhoan where (" . $where . ") and MaPQ='2' ORDER BY `MaTK` DESC" );
		// . $item_per_page . " OFFSET " . $offset
	} else {
		$products = mysqli_query($connect, "SELECT * FROM nongsansach.taikhoan where MaPQ='2' ORDER BY `MaTK` DESC" );
		// . $item_per_page . " OFFSET " . $offset
	}
	mysqli_close($connect);
?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Phân quyền nhân viên</h3>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Danh sách <?= $config_title ?></h3>
					</div>
					<div class="panel-search">
						<input type="text" id="myInput" placeholder="Tìm kiếm">
						<script>
							$(document).ready(function() {
								$("#myInput").on("keyup", function() {
									var value = $(this).val().toLowerCase();
									$("#table-employee tbody tr").filter(function() {
										$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
									});
								});
							});
						</script>
					</div>
					<div class="panel-body">
						<a href="./add-member.php" class="btn btn-info">Thêm <?= $config_title ?></a>
					</div>
				</div>
				<div class="table-list">
					<table class="table table-bordered table-hover" id="table-employee">
						<thead>
							<tr>
								<th>Tên đăng nhập</th>
								<th>Họ tên</th>
								<th>Xóa</th>
								<th>Sửa</th>
								<th>Phân quyền</th>
								<th>Trạng thái</th>

							</tr>
						</thead>
						<tbody>
							<?php
							while ($row = mysqli_fetch_array($products)) {
							?>
								<tr>
									<td><?= $row['Email'] ?></td>
									<td><?= $row['TenKH'] ?></td>
									<td><a href="./<?= $config_name ?>_delete.php?id=<?= $row['MaTK'] ?>" class="btn btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa không')"><span class="fas fa-window-close"></span></a></td>
									<td><a href="./<?= $config_name ?>_editing.php?id=<?= $row['MaTK'] ?>" class="btn btn-outline-success" title="Sửa"><span class="fas fa-edit"></span></a></td>
									<td><a href="./<?= $config_name ?>_privilege.php?id=<?= $row['MaTK'] ?>" class="btn btn-primary" title="Phân quyền"><span class="fa fa-users"></a></td>
									<td>
										<?php
										if ($row['TinhTrang'] == 0) {
											echo '<p><a class="label label-success" href="status-member.php?MaTK=' . $row['MaTK'] . '&TinhTrang=1">Đang sử dụng</a></p>';
										} else {
											echo  '<p><a class="label label-danger" href="status-member.php?MaTK=' . $row['MaTK'] . '&TinhTrang=0">Vô hiệu hóa</a></p>';
										}
										?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="clear-both"></div>
<?php
}
include './footer.php';
?>