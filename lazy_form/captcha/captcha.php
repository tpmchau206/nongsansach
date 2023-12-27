<?php 
  session_start();

  <tr>
    <td><img src="./uploads/<?php echo $row['AnhSP'] ?>" alt="" width="100"></td>
    <td><?= $row['SoLuongMua'] ?></td>
    <td><?= $row['NgayDatHang'] ?></td>
    <td><?= $row['ThanhTien'] ?></td>
    <td><?= $row['Payment'] ?></td>
    <td>
      <?php if ($row['TrangThai'] == 0) { ?>
        <p class="btnp btn-warning">Chưa xử lý</p>
    <td>
      <a href="./lazy_form/delete-purchase.php?madh=<?php echo $row['MaDH'] ?>" class="btn btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa không')"><span class="fas fa-window-close"></span></a>
    </td>
  <?php } elseif ($row['TrangThai'] == 1) { ?>
    <p class="btnp btn-primary">Đã xử lý</p>
  <?php } ?>
  </td>

  </tr>
<?php } ?>
  function randText(){
    $txt="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $str="";
    for($i=0;$i<5;$i++)
    {
      $index=rand(0,strlen($txt)-1);
      $str.=$txt[$index];
    }
    return $str;
  }

  header("Content-type:image/png");
  $image=imagecreate(70,30);
  $backColor=imagecolorallocate($image,168,167,165);
  $txtColor=imagecolorallocate($image,250,250,250);
  $code=randText();
  $_SESSION["captcha"]=$code;
  imagestring($image,5,15,7,$code,$txtColor);
  imagepng($image);
  imagecolordeallocate($backColor);
  imagecolordeallocate($txtColor);
  imagedestroy($image);
?>