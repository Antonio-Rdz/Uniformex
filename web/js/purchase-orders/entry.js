$(function () {

    $('.entry-type').on('change', function () {

        var th = {material:'Material', part: 'Avío', cloth: 'Prenda'};
        var detailid = $(this).data('detailid');
        var selected = $(this).val();
        $("#entry_type_col_"+detailid).html("<a href='#!' id='entry_element_selection_trigger' class='btn modal-trigger' data-target='entry_element_selection_modal' data-element='"+selected+"' data-detailid='"+detailid+"'>Seleccionar "+th[selected]+"</a>");
        $('.modal').modal();
    });
    
    
    $(document).on('click', '#entry_element_selection_trigger', function () {
       var element = $(this).data('element');
       var detailid = $(this).data('detailid');

       sessionStorage.setItem('entry_detail_id', detailid);

       var urls = {material: 'select-material', part: 'select-part', cloth: 'select-cloth'};
       $.ajax({
           'url': urls[element],
           'dataType': 'html',
           'beforeSend': function () {
               $('#entry_element_selection').html('<div class="progress"><div class="indeterminate"></div></div>');
           },
           'success': function (result) {
               $('#entry_element_selection').removeClass('valign-wrapper').html(result);
           }
       });
    }).on('click', '.select-element-button', function () {
        var _this = $(this);
        var type = _this.data('type');
        var id = _this.data('id');

        var _element = capitalize(type);

        $.ajax({
            'url': 'get-element-details',
            'data': {'id': id, 'type': type},
            'dataType': 'json',
            'success': function (result) {
                var detailid = sessionStorage.getItem('entry_detail_id');
                $("#entry_type_col_"+detailid).html(result.description+
                    '<a href="#!" class="remove-entry-element" data-detailid="'+detailid+'" data-type="'+type+'">' +
                        '<i class="material-icons right">remove_circle_outline</i>' +
                    '</a>' +
                    '<input type="hidden" name="'+_element+'['+detailid+']" value="'+id+'">'
                );
            }
        });
    }).on('click', '.remove-entry-element', function () {
        var _this = $(this);
        var th = {material:'Material', part: 'Avío', cloth: 'Prenda'};
        var detailid = _this.data('detailid');
        var type = _this.data('type');

        console.log({detailid, type});

        $("#entry_type_col_"+detailid).html("<a href='#!' id='entry_element_selection_trigger' class='btn modal-trigger' data-target='entry_element_selection_modal' data-element='"+type+"' data-detailid='"+detailid+"'>Seleccionar "+th[type]+"</a>");
    })

});


function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}