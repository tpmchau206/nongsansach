<section class="footer" id="contact">
    <div class="box-container">
        <div class="box">
            <a href="#" class="logo"></i>Nông trại organic</a>
            <p>Địa chỉ: 600 Trần Cao Vân, Hải Châu, Đà Nẵng</p>
            <p>Số điện thoại: 09857483999</p>
            <p>Email: nhuanquang00@gmail.com</p>
            <p>Shopnongsansach.com</p>
            <div class="share">
                <a href="https://www.facebook.com/Website-B%C3%A1n-N%C3%B4ng-S%E1%BA%A3n-110447918298430" class="btn fab fa-facebook-f"></a>
                <a href="#" class="btn fab fa-twitter"></a>
                <a href="#" class="btn fab fa-instagram"></a>
                <a href="#" class="btn fab fa-linkedin"></a>
            </div>
        </div>
        <div class="box">
            <h3>Cam kết</h3>
            <p> - Giá ưu đãi nhất. </p>
            <p> - Sản phẩm chất lượng.</p>
            <p> - Truy xuất nguồn gốc rõ ràng.</p>
        </div>
        <div class="box">
            <h3>CHÍNH SÁCH & BẢO MẬT</h3>
            <div class="links">
                <a href="#">Chính sách thanh toán</a>
                <a href="#">Chính sách vận chuyển</a>
            </div>
        </div>
    </div>
    <h1 class="credit"> Copyright © 2021 Nông Sản Sạch</h1>
</section>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<!-- Messenger Plugin chat Code -->
<div id="fb-root"></div>

<!-- Your Plugin chat code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "110447918298430");
    chatbox.setAttribute("attribution", "biz_inbox");
</script>

<!-- Your SDK code -->
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml: true,
            version: 'v13.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!-- <script>
    $("#cart-content").validate({
        submitHandler: function(form) {

            $.ajax({
                type: "POST",
                url: './displays/ajax/cart/processCart.php?action=submit',
                data: $(form).serializeArray(),
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == 0) { //Đăng nhập lỗi
                        alert(response.message);
                    } else { //Đăng nhập thành công
                        alert(response.message);
                        location.href = '?mod=displays/cart';


                    }
                }
            });
        }
    });
</script> -->
<script>
    function updateQuantity(quantity) {
        if (quantity != "" && quantity <= 10) {
            $.ajax({
                type: 'POST',
                url: './displays/ajax/cart/processCart.php?action=update',
                data: $('#cart-content').serializeArray(),
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == 0) {
                        alert(response.message);
                        location.reload();
                    } else {
                        $('#quantity-cart').html(response.total_quantity);
                        $.get('./displays/ajax/cart/cartContent.php', function(cartContentHTML) {
                            $('#ajax-cart').html(cartContentHTML);
                        });
                    }
                }
            });
        }
    }

    function deleteCart(productId) {
        $.ajax({
            type: 'POST',
            url: './displays/ajax/cart/processCart.php?action=delete',
            data: {
                "id": productId
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.status == 0) {
                    alert(response.message);
                } else {
                    alert(response.message);
                    $('#quantity-cart').html(response.total_quantity);
                    $.get('./displays/ajax/cart/cartContent.php', function(cartContentHTML) {
                        $('#ajax-cart').html(cartContentHTML);
                    });
                }
            }
        });
    }

    $('#add-to-cart').validate({
        rules: {
            "quantity[<?= isset($row['MaSP']) ? $row['MaSP'] : 0 ?>]": {
                required: true,
                remote: {
                    url: './displays/ajax/cart/checkQuantity.php',
                    type: 'post',
                }
            }
        },
        submitHandler: function(form) {
            $.ajax({
                type: 'POST',
                url: './displays/ajax/cart/processCart.php?action=add',
                data: $(form).serializeArray(),
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == 0) { //mua ko thành công
                        alert(response.message);
                    } else { //mua thành công
                        alert(response.message);
                        $('#quantity-cart').html(response.total_quantity);
                        $.get('./displays/ajax/cart/cartContent.php', function(cartContentHTML) {
                            $('#ajax-cart').html(cartContentHTML);
                        });
                    }
                }
            })
        }
    });
    // Hủy đơn hàng
    function cancel_purchase(idDH) {
        text = 'Bạn có chắc muốn hủy đơn hàng này chứ?';
        if (confirm(text) == true) {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: './displays/ajax/cart/processCart.php?action=cancel',
                data: {
                    "id": idDH
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == 0) { //Hủy đơn hàng không thành công
                        alert(response.message);
                    } else { //Hủy đơn hàng thành công
                        alert(response.message);
                    }
                }
            })
            location.reload();
        } else {}
    }
</script>
<script>
    $('.quick-by-form').submit(function(event) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: './displays/ajax/cart/processCart.php?action=add',
            data: $(this).serializeArray(),
            success: function(response) {
                response = JSON.parse(response);
                if (response.status == 0) { //thêm vào giỏ không thành công
                    alert(response.message);
                } else { //thêm vào giỏ thành công
                    alert(response.message);
                    $('#quantity-cart').html(response.total_quantity);

                }
            }
        })
    })
</script>