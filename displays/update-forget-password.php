<?php
if(isset($_POST['password']) && $_POST['reset_link_token'] && $_POST['email'])
{
  include "../db/config.php";
  
  $emailId = $_POST['email'];
  $token = $_POST['reset_link_token'];

  $old_pass = md5($_POST['passcu']);
  $password = md5($_POST['password']);
  $re_pass = md5($_POST['cpassword']);
  $query = mysqli_query($connect,"SELECT * FROM nongsansach.taikhoan where Email= '" . $emailId . "'");
   $row = mysqli_num_rows($query);
   if($row){
   if($password == $re_pass){
    mysqli_query($connect,"UPDATE nongsansach.taikhoan set  Pass='" . $password . "'  WHERE Email = '" . $emailId ."'");
   }else{
    echo "<script>alert('Mật khẩu mới và mật khẩu nhập lại của bạn không khớp');window.location='../displays/passwordrecove.php'</script>";
   }
?>
<script>
         window.location.replace("../displays/account.php");
         alert("<?php echo "Cập nhật lại mật khẩu thành công" ?>");
     </script>
 <?php
 } else {
 ?>
     <script>
         alert("<?php echo "Vui lòng thử lại" ?>");
     </script>
<?php
}
}
?>