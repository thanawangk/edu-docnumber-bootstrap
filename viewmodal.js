$(document).ready(function () {
    $("input").not('input[type=submit]').addClass('form-control');
    $('.view-detail').click(function () {

        // get data form view btn
        var id = $(this).attr('data-id');
        var date = $(this).attr('data-date');
        var num = $(this).attr('data-num');
        var sentname = $(this).attr('data-sentname');
        var resvname = $(this).attr('data-resvname');
        var text = $(this).attr('data-text');
        var status = $(this).attr('data-status');
        var fname = $(this).attr('data-fname');

        // set value to modal
        $('#id').val(id);
        $('#date').val(date);
        $('#num').val(num);
        $('#sentname').val(sentname);
        $('#resvname').val(resvname);
        $('#text').val(text);
        $('#fname').val(fname);
        
        if (status == 0) {
            document.getElementById('status').innerHTML = "<span style='color: red;'>ยกเลิก</span>";
        }
        else {
            document.getElementById('status').innerHTML = "<span style='color: green;'>ใช้งาน</span>";
        }
     

        // open modal
        $('#view-detailModal').modal('show');
    });
});