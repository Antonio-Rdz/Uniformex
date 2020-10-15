$(document).on('click', '#load_cloth_types', function () {

    $.ajax({
        dataType: 'html',
        url: '/cloth-types-record-cards/list',
        data: {'record_card_id': $(this).data('id')},
        success: function(response){
            $('#ajax_content').html(response)
        }
    });

});