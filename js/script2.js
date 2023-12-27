
jQuery(document).ready(function () {
    $('.btnedit').click(function () {
        $('#edit').css('display', 'block');
        Id = $('#edit').val($(this).closest('tr').find('td:nth-child(3)').text()); //Lấy value cột thứ nhất
        $.post('./displays/ajax/address/addressedit.php', {
            'id': Id.val()
        }, function (data) {
            $('#edit').html(data);
        });
    });
    $('.btn-address').click(function () {
        $('#edit').css('display', 'block');
        $.post('./displays/ajax/address/addressadd.php', {

        }, function (data) {
            $('#edit').html(data);
        });
    })
    $('.btndelete').click(function () {
        $('#edit').css('display', 'block');
        Id = $('#edit').val($(this).closest('tr').find('td:nth-child(3)').text()); //Lấy value cột thứ nhất
        $.post('./displays/ajax/address/addressdelete.php', {
            'id': Id.val()
        }, function (data) {
            $('#edit').html(data);
        });
    });
});

function openCity(evt, cityName) {
    var i, tabdiachi, tablinks;
    tabdiachi = document.getElementsByClassName("tabdiachi");
    for (i = 0; i < tabdiachi.length; i++) {
        tabdiachi[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" activeTab", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " activeTab";
}

function openTransfer(evt, cityName) {
    var i, tabdiachi, tablinks;
    tabdiachi = document.getElementsByClassName("tabdiachi");
    for (i = 0; i < tabdiachi.length; i++) {
        tabdiachi[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" activeTab", "");
    }
    document.getElementById(cityName).style.display = "block";


}


$(function () {
    //Năm tự động điền vào select 
    var seYear = $('#year');
    var date = new Date();
    var cur = date.getFullYear();
    seYear.append('<option value="">---------</option>');
    for (i = cur; i >= 1900; i--) {
        seYear.append('<option value="' + i + '">' + i + '</option>');
    };

    //Tháng tự động điền vào select
    var seMonth = $('#month');
    var date = new Date();
    var month = new Array();
    month[1] = "Tháng 1";
    month[2] = "Tháng 2";
    month[3] = "Tháng 3";
    month[4] = "Tháng 4";
    month[5] = "Tháng 5";
    month[6] = "Tháng 6";
    month[7] = "Tháng 7";
    month[8] = "Tháng 8";
    month[9] = "Tháng 9";
    month[10] = "Tháng 10";
    month[11] = "Tháng 11";
    month[12] = "Tháng 12";

    seMonth.append('<option value="">-- Tháng --</option>');
    for (i = 12; i > 0; i--) {
        seMonth.append('<option value="' + i + '">' + month[i] + '</option>');
    };

    //Ngày tự động điền vào select
    function dayList(month, year) {
        var day = new Date(year, month, 0);
        return day.getDate();
    }

    $('#year, #month').change(function () {
        //Đoạn code lấy id không viết bằng jQuery để phù hợp với đoạn code bên dưới
        var y = document.getElementById('year');
        var m = document.getElementById('month');
        var d = document.getElementById('day');

        var year = y.options[y.selectedIndex].value;
        var month = m.options[m.selectedIndex].value;
        var day = d.options[d.selectedIndex].value;
        if (day != '') {
            var days = (year == ' ' || month == ' ') ? 31 : dayList(month, year);
            d.options.length = 0;
            d.options[d.options.length] = new Option('-- Ngày --', ' ');
            for (var i = 1; i <= days; i++) d.options[d.options.length] = new Option(i, i);
        }
    });
});

// thanh toán
// sự kiện click img thanh toán
$(document).ready(function () {

    $('.radio-group .radio').click(function () {
        $('.radio').addClass('gray');
        $(this).removeClass('gray');
    });

    $('.plus-minus .plus').click(function () {
        var count = $(this).parent().prev().text();
        $(this).parent().prev().html(Number(count) + 1);
    });

    $('.plus-minus .minus').click(function () {
        var count = $(this).parent().prev().text();
        $(this).parent().prev().html(Number(count) - 1);
    });

});

// giao diện thanh toán
jQuery(document).ready(function () {
    $('.title-swap').click(function () {
        document.getElementById('row1').style.display = "block";

    });
})

jQuery(document).ready(function () {
    $('.row2').click(function () {
        document.getElementById('paypal-button-container').style.display = "none";
    });
    $('.row3').click(function () {
        document.getElementById('paypal-button-container').style.display = "none";
    });


})
jQuery(document).ready(function () {
    $('.row5').click(function () {
        document.getElementById('paypal-button-container').style.display = "block";
    });
})


