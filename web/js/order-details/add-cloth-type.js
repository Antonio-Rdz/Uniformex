$("body").on('click', '#add_cloth_type', function () {

    $.post("/cloth-types/list", function (data) {
        Swal.fire({
            title: 'Selecciona una tela para agregar',
            input: 'select',
            inputOptions: data,
            inputAttributes: {'id': 'new_cloth_type'},
            /*html:
                '<div class="input-field col s12">\n' +
                '    <input id="quantity" type="number" class="validate" required>\n' +
                '    <label for="quantity">Cantidad</label>\n' +
                '</div>',*/
            showCancelButton: true,
            confirmButtonText: 'Agregar',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            footer: '<a href="#!" class="btn-flat" style="color:#1e88e5;" id="create_cloth_type"><i class="material-icons left">add</i> Nueva tela</a>',
            preConfirm: () => {
                return new Promise((resolve) => {
                    resolve({
                        quantity: $('#quantity').val(),
                        cloth_type_id : $('select#new_cloth_type').val(),
                        name: $('select#new_cloth_type option:selected').text(),
                    });
                });
            }
        }).then((result) => {

            if(result.value) {
                let r = result.value;
                let _cloth = r.name.split(" ");

                _elem1 = $("#clothes_types tbody td:contains('" + _cloth[0] + "')");
                _elem2 = $("#clothes_types tbody td:contains('" + _cloth[1] + "')");

                if (_elem1.length > 0 && _elem2.length > 0) {
                    M.toast({'html': 'Ya has agregado esa tela antes', 'classes': 'error'});
                } else {
                    M.toast({'html': 'Tela agregada correctamente', 'classes': 'success'});
                    $('#clothes_types tbody tr:last').after("<tr> <td>" + _cloth[0] + "" +
                        "<input type='hidden' name='ClothTypes[" + r.cloth_type_id + "][name]' class='cloth-input' value='" + _cloth[0] + "'> </td> <td>"
                        + _cloth[1] +
                        "<input type='hidden' name='ClothTypes[" + r.cloth_type_id + "][color]' class='cloth-input' value='" + _cloth[1] + "'> </td> " +
                        " <td> <a href='#!' class='remove-cloth-type'><i class='material-icons'>delete</i></a> </td> </tr>");
                }
            }

        });
        // Sort options alphabetically
        var options = $('select#new_cloth_type option');
        var arr = options.map(function(_, o) { return { t: $(o).text(), v: o.value }; }).get();
        arr.sort(function(o1, o2) { return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0; });
        options.each(function(i, o) {
            o.value = arr[i].v;
            $(o).text(arr[i].t);
        });
    });

}).on('click', '#create_cloth_type', function () {

    $.get("/cloth-types/form", function (html) {
        Swal.fire({
            title: 'Crear una tela y agregarla',
            html: html,
            showCancelButton: true,
            confirmButtonText: 'Agregar',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve) => {
                    resolve({
                        'ClothTypes[name]' : $('#clothtypes-name').val(),
                        'ClothTypes[color]' : $('#clothtypes-color').val(),
                    });
                });
            }
        }).then((_data) => {
            if(_data.value) {
                $.post("/cloth-types/form", _data.value, function (html) {
                    M.toast({'html': 'La tela se ha creado y ha sido agregada correctamente', 'classes': 'success'});
                    // Add html to form
                    $('#clothes_types tr:last').after(html);
                });
            }
        });
    });
}).on('click', '.remove-cloth-type', function () {
    $(this).closest('tr').remove();
});

$('#ord-dtl').submit(function (e) {
    e.preventDefault();
    _elem = $(".cloth-input");
    _hasValue = hasValue(".size-input");
    if(_elem.length > 0 && _hasValue === true){
        $(this)[0].submit();
    } else if(_hasValue){
        M.toast({'html': 'Por favor agrega al menos una tela', 'classes': 'error'});
        $('html,body').animate({scrollTop: $("#clothes_types_card").offset().top}, 'slow');
    } else {
        M.toast({'html': 'Por favor agrega al menos una pieza de alguna talla', 'classes': 'error'});
    }
});

function hasValue(elem) {
    return $(elem).filter(function() { return $(this).val() > 0; }).length > 0;
}
