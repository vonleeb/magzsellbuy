$(function () {
    var sort = $('#cur_sort').html();
    $('option[value="'+sort+'"]').attr('selected', true);
});
$('#buy').click(function (e) {
    e.preventDefault();
    var href = $('#buy').data('href');
    var user = $('#buy').data('user');
    var product = $('#buy').data('product');
    var check = $('#buy').attr('disabled');
    console.log(check);
    if (user === '' && check === 'disabled'){
    //nothing
    }else{
    $.ajax({
       type: 'GET',
       url: href,
       data: 'user='+user+'&id='+product,
        success: function (data) {
            alert(data);
        },
        error: function (data) {
            console.log('error:' + data);
        }
    });
    }
});
$('#sel_sort').on('change',function (e) {
   $('#form_sort').submit();
});