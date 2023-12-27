<?php
require('db/config.php');
error_reporting(E_ALL);
$mod = '';
// (isset($_SESSION['current_user']) ? $user = $_SESSION['current_user'] : []);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nông sản sạch</title>
  <link rel="icon" type="ico" sizes="16x16" href="leaf.ico">
  <!-- font awesome cdn link  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/animate.css" />
  <script src="js/wow.min.js"> </script>
  <script>
    new WOW().init();
  </script>

  <!-- <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" /> -->

  <!-- custom css file link  -->
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/cart_detail.css">
  <link rel="stylesheet" href="css/details-product.css">
  <link rel="stylesheet" href="css/phantrang.css">
  <link rel="stylesheet" type="text/css" href="css/slider.css">
  <script src="js/fontawesome.js" crossorigin="anonymous"></script>
  <script src="js/gsap.min.js"></script>
  <script src="js/jquery-3.6.0.min.js"></script>
  <script src="js/jquery.validate.min.js"></script>

  <?php
  if (isset($_GET['mod'])) {
    $mod = $_GET['mod'];
  }
  if ($mod == '') {
    $mod = 'displays/home';
  }
  ?>
</head>

<body>

  <!-- header section starts  -->
  <?php include 'displays/header.php' ?>

  <!-- header section ends -->

  <!-- home section starts  -->

  <!-- home section ends -->



  <!-- category section starts  -->


  <!-- category section ends -->

  <!-- product section starts  -->

  <?php
  if (isset($_GET['mod'])) {
    $mod = $_GET['mod'];
  }
  if ($mod == '') $mod = 'home';
  $mod = str_replace('../', '', $mod);
  if (is_file("{$mod}.php"))
    include("{$mod}.php");
  else
    echo 'Invalid URL';
  ?>

  <!-- product section ends -->


  <!-- footer section starts  -->

  <?php include 'displays/footer.php' ?>
  <a href="#" class="fas fa-angle-up" id="scroll-top"></a>


  <!-- footer section ends -->
  <script src="js/wow.min.js"> </script>
  <script>
    new WOW().init();
  </script>
  <script src="js/script.js"></script>
  <script src="js/slick-slide.js"></script>
  <script src="https://www.paypal.com/sdk/js?client-id=AdPi3eQJ-Tl5NqE3ILr5Rr55ROt8iJgjSVCF1HT7WvvYv_oVn2hac3Gc4V1C4Tl57ZiYxxHrHXnXQv7q&currency=USD"></script>
  <script>
    paypal.Buttons({

      // Sets up the transaction when a payment button is clicked
      createOrder: function(data, actions) {
        var total = document.getElementById('total').value;
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: total // Can reference variables or functions. Example: `value: document.getElementById('...').value`
            }
          }]
        });
      },

      // Finalize the transaction after payer approval
      onApprove: function(data, actions) {
        return actions.order.capture().then(function(orderData) {
          // Successful capture! For dev/demo purposes:
          console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
          var transaction = orderData.purchase_units[0].payments.captures[0];
          alert('Transaction ' + transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');
          window.location.replace('http://nongsansach.vn/nongsansach/index.php?mod=displays/camon&thanhtoan=paypal');
          // When ready to go live, remove the alert and show a success message within this page. For example:
          // var element = document.getElementById('paypal-button-container');
          // element.innerHTML = '';
          // element.innerHTML = '<h3>Thank you for your payment!</h3>';
          // Or go to another URL:  actions.redirect('thank_you.html');
        });
      },
      onCancle: function(data) {
        window.location.replace('http://nongsansach.vn/nongsansach/index.php?mod=displays/cart');
      }
    }).render('#paypal-button-container');
  </script>

</body>

</html>