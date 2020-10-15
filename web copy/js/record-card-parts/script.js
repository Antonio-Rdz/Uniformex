$('#recordcardparts-part_id').on('change', function () {
    let _this = $(this);

    $.get('/record-card-parts/get-unit', {'part_id' : _this.val()}, function (r) {
        $('#l_quantity').text('Cantidad ('+r.unit+'s)');
    });
});