$("body").on('click', '#add_size', function () {

    $.post("/sizes/get-other-sizes", function (data) {
        Swal.fire({
            title: 'Selecciona una talla para agregar',
            input: 'select',
            inputOptions: data,
            inputAttributes: {'id': 'new_size'},
            html:
                '<div class="input-field col s12">\n' +
                '    <input id="quantity" type="number" class="validate" required>\n' +
                '    <label for="quantity">Cantidad</label>\n' +
                '</div>',
            showCancelButton: true,
            confirmButtonText: 'Agregar',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve) => {
                    resolve({
                        quantity: $('#quantity').val(),
                        size_id : $('select#new_size').val(),
                        size: $('select#new_size option:selected').text(),
                    });
                });
            }
        }).then((result) => {
            let r = result.value;

            _elem = $( "th:contains('"+r.size+"')" );

            if(_elem.length>0){
                M.toast({'html': 'Ya has agregado esa talla antes', 'classes': 'error'});
            } else {
                head_text = $("#head_text");

                // Remove the button column

                // Add sie column and restore the button column
                $("#sizes_row").append('<td><input type="number" class="center" name="Sizes['+r.size_id+'][qty]" autocomplete="off" value="'+r.quantity+'"></td>');
                $("#head_row").append('<th>'+r.size+'</th>');

                _price = $('#orderdetails-price').val();
                $("#prices_row").append('<td><input type="number" class="center" name="Sizes['+r.size_id+'][price]" autocomplete="off" step="any" value="'+_price+'"></td>');

            }

        })
    });

}).on('input', '.size-input', function () {
    _id = $(this).data("id");
    _price = $('#orderdetails-price').val();

    $('.price-input#price_'+_id).val(_price);
});