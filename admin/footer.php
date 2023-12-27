</div>
</div>

</div>
<script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/app-style-switcher.js"></script>
<script src="plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
<!--Wave Effects -->
<script src="js/waves.js"></script>
<!--Menu sidebar -->
<script src="js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="js/custom.js"></script>

<script src="../js//jquery-3.6.0.js"></script>

<!--This page JavaScript -->
<!--chartis chart-->
<script src="plugins/bower_components/chartist/dist/chartist.min.js"></script>
<script src="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
<!-- <script src="js/pages/dashboards/dashboard1.js"></script> -->
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script> -->
<script type="text/javascript">
    $(document).ready(function() {
        thongke();
        var char = new Morris.Bar({

            element: 'myfirstchart',

            xkey: 'date',

            ykeys: ['date', 'order', 'sales', 'quantity'],

            labels: ['Đơn hàng', 'Doanh thu', 'Tổng tiền bán ra', 'Số lượng']
        });

        $('.select-date').change(function() {
            var thoigian = $(this).val();
            if (thoigian == '7ngay') {
                var text = '7 ngày qua';
            } else if (thoigian == '28ngay') {
                var text = '28 ngày qua';
            } else if (thoigian == '90ngay') {
                var text = '90 ngày qua';
            } else {
                var text = '365 ngày qua';
            }

            $.ajax({
                url: "./thongke.php",
                method: "POST",
                dataType: "JSON",
                data: {
                    thoigian: thoigian
                },
                success: function(data) {
                    char.setData(data);
                    $('#text-date').text(text);
                }
            });
        })

        function thongke() {
            var text = '365 ngày qua';
            $('#text-date').text(text);
            $.ajax({
                url: "./thongke.php",
                method: "POST",
                dataType: "JSON",
                success: function(data) {
                    char.setData(data);
                    $('#text-date').text(text);
                }
            });
        }
    });

    jQuery(document).ready(function($) {
        $('#province').change(function(event) {
            provinceId = $('#province').val();
            $.post('district.php', {
                "province": provinceId
            }, function(data) {
                $('#district').html(data);
            });
        });
        $('#district').change(function(event) {
            districtId = $('#district').val();
            $.post('ward.php', {
                "district": districtId
            }, function(data) {
                $('#ward').html(data);
            });
        });
        $('#ward').change(function(event) {
            wardId = $('#ward').val();
        });
    });
</script>

</body>

</html>