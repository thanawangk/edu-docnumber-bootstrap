$(document).ready(function () {
    $("input").not('input[type=submit]').addClass('form-control');
    $('.view-detail').click(function () {
        // get data form view btn
        var id = $(this).attr('data-id');
        var num = $(this).attr('data-num');
        var sentname = $(this).attr('data-sentname');
        var resvname = $(this).attr('data-resvname');
        var text = $(this).attr('data-text');
        var status = $(this).attr('data-status');
        // set value to modal
        $('#id').val(id);
        $('#num').val(num);
        $('#sentname').val(sentname);
        $('#resvname').val(resvname);
        $('#text').val(text);
        $('#status').val(status);
        // open modal
        $('#view-detailModal').modal('show');
    });
});