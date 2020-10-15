$('#recordcardcomponents-material_id').on('change', function () {
    let _this = $(this);

    $.get('/record-card-components/get-unit', {'material_id' : _this.val()}, function (r) {
        $('#l_quantity').text('Cantidad ('+r.unit+'s)');
    });
});