<?php
include '../db/config.php';

$delivery = mysqli_query($connect, "SELECT * FROM nongsansach.vanchuyen ORDER BY Phiship ASC");


if (isset($_POST['provinces'])) {
  $province = $_POST['provinces'];
  $feeship = $_POST['phiship'];

  $sql2 = "SELECT * FROM nongsansach.vanchuyen WHERE TenTP='$province'";
  $query2 = mysqli_query($connect, $sql2);
  $data2 = mysqli_fetch_array($query2);
  $checkvc = mysqli_num_rows($query2);
  if ($province == $data2['TenTP']) {
    echo "<script>alert('Tên vận chuyển đã tồn tại');window.location='./transport.php'</script>";
    $err['provinces'] = '';
  }
  if (empty($err)) {
    $sql = "INSERT INTO nongsansach.vanchuyen(TenTP, Phiship) 
  VALUES ('$province','$feeship')";
    $delivery_query = mysqli_query($connect, $sql);
    if ($delivery_query) {
?>
      <script>
        window.location.replace("./transport.php");
        alert("<?php echo "Thêm thành công" ?>");
      </script>
    <?php
    } else {
    ?>
      <script>
        alert("<?php echo "Thêm không thành công" ?>");
      </script>
<?php
    }
  }
}
?>
<?php include './header.php' ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-4">
      <div class="panel-info">

        <div class="table-list">
          <div class="panel-body">
            <form action="" method="POST" role="form">
              <legend>Thêm mới vận chuyển</legend>

              <div class="form-group">
                <label for="">Chọn thành phố</label>
                <?php
                $query = mysqli_query($connect, "SELECT * FROM nongsansach.tinhthanh ORDER BY `TenTT`");
                $province = mysqli_fetch_all($query, 1);
                ?>
                <select class="form-control" name="provinces" id="province">
                  <option value="">--Chọn tỉnh thành phố--</option>
                  <?php
                  foreach ($province as $value) {
                  ?>
                    <option value="<?php echo $value['TenTT'] ?>"><?php echo $value['TenTT'] ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group">
                <label for="">Phí ship</label>
                <input type="number" class="form-control" id="" min="1" max="50000" placeholder="Input field" name="phiship" value="<?php echo $trans['Phiship'] ?>" required>
              </div>

              <button type="submit" class="btn btn-primary">Thêm mới</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title">Danh sách vận chuyển</h3>
        </div>
        <div class="panel-search">
          <input type="text" id="myInput" placeholder="Tìm kiếm">
          <script>
            $(document).ready(function() {
              $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#table-transport tbody tr").filter(function() {
                  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
              });
            });
          </script>
        </div>
      </div>
      <div class="table-list">
        <table class="table table-bordered table-hover" id="table-transport">
          <thead>
            <tr>
              <th>Tên thành phố</th>
              <th>Phí ship</th>

            </tr>
          </thead>
          <tbody>
            <?php foreach ($delivery as $key => $value) : ?>
              <tr>
                <td><?php echo $value['TenTP'] ?></td>
                <td><?php echo number_format($value['Phiship'], 0, ',', '.') ?>₫</td>

                <td>
                  <a href="./edit-transport.php?mavc=<?php echo $value['MaVC'] ?>" class="btn btn-outline-success" title="Sửa"><span class="fas fa-edit"></span></a>
                  <a href="./delete-transport.php?mavc=<?php echo $value['MaVC'] ?>" class="btn btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa không')"><span class="fas fa-window-close"></span></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php include './footer.php' ?>