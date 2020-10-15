var counter = 1;
$(document).on('click', '#add-logo', function () {
    _this = $(this);

    if($('#logo-form').html() === ''){
        $.ajax({
            dataType: 'html',
            url: '/record-card-designs/create',
            data: {'record_card_id': _this.data('record_card_id'), 'new': 1},
            success: function(response){
                $('#logo-form').html(response);
                $('#logo-title').html('Agregar logotipo');
                loadChipsColors();
            }
        });
    }

}).on('click', '#delete-logo', function () {
    _this = $(this);
    _this.closest('li.collection-item').remove();



}).on('submit', '#record_card_logos_form', function (e) {
    e.preventDefault();
    _this = $(this);
    /*var _color_list = [];
    $('.chip').each(function(){
        // Get only the text, avoiding any HTML tags
        _color_list.push($(this).clone().children().remove().end().text());
    });

    var _form_data = getFormData(_this);
    // Add the color sequence
    _form_data['RecordCardDesigns[color_sequence]'] = _color_list.join(',');*/

    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: '/record-card-designs/create-logo',
        data: new FormData( this ),
        processData: false,
        contentType: false,
        success: function (response) {
            if(response !== ''){
                M.toast({'html': 'Logotipo creado correctamente', 'classes': 'success'});
                // Add logo to the list
                $('#logos-list').append(response);
                $('.new-materialboxed').materialbox_new();
                var instance = M.Modal.getInstance(document.getElementById('logos'));
                instance.close();
                $('#logo-form').html('');
            }
        }
    });



    console.log(_form_data);
    console.log(_color_list);
});


function loadChipsColors() {
    $('.chips-autocomplete').chips({
        onChipAdd: () => {
            updateChipsInput();
        },
        onChipDelete: () => {
            updateChipsInput();
        },
        autocompleteOptions: {
            data: color_list,
            limit: Infinity,
            minLength: 1
        }
    });
    $('.autocomplete-techniques').autocomplete({
        data: {
            'Serigrafía': null,
            'Sublimación': null,
            'Vinilo': null,
            'Transfer': null,
            'Tampografía': null,
            'Impresión Directa': null,
        }
    });
}

function updateChipsInput() {
    var _color_list = [];
    $('.chip').each(function(){
        // Get only the text, avoiding any HTML tags
        _color_list.push($(this).clone().children().remove().end().text());
    });
    $('#color_sequence').val(_color_list.join(','));
}

function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

let color_list = {
    'Acero': null,
    'Agua': null,
    'Aguacate': null,
    'Aguamarina': null,
    'Albaricoque': null,
    'Almagre': null,
    'Almendra': null,
    'Aluminio': null,
    'Amaranto': null,
    'Amarillo (estándar)': null,
    'Amarillo (puro)': null,
    'Amarillo (CMYK)': null,
    'Amarillo azufre': null,
    'Amarillo cadmio': null,
    'Amarillo chino': null,
    'Amarillo de cobalto': null,
    'Amarillo de cromo': null,
    'Amarillo fluorescente': null,
    'Amarillo monoazo': null,
    'Amarillo naranja': null,
    'Amarillo Hansa': null,
    'Amarillo indio': null,
    'Amarillo Nápoles': null,
    'Amarillo patito': null,
    'Amarillo selectivo': null,
    'Amarillo tráfico': null,
    'Amarillo verdoso': null,
    'Amatista': null,
    'Ámbar': null,
    'Anaranjado': null,
    'Ante': null,
    'Añil': null,
    'Arena': null,
    'Asfalto': null,
    'Aureolina': null,
    'Avellana': null,
    'Azabache': null,
    'Azafrán': null,
    'Azul': null,
    'Azul (puro)': null,
    'Azul acero': null,
    'Azul aciano': null,
    'Azul Alicia': null,
    'Azul celeste': null,
    'Azul cerúleo': null,
    'Azul cian': null,
    'Azul cobalto': null,
    'Azul Columbia': null,
    'Azul egipcio': null,
    'Azul eléctrico': null,
    'Azul Eton': null,
    'Azul ftalo': null,
    'Azul glauco': null,
    'Azul Klein': null,
    'Azul lavanda': null,
    'Azul lino': null,
    'Azul Majorelle': null,
    'Azul marino': null,
    'Azul maya': null,
    'Azul monastral': null,
    'Azul persa': null,
    'Azul de Prusia': null,
    'Azul púrpura': null,
    'Azul real': null,
    'Azul Tiffany': null,
    'Azul ultramar': null,
    'Azul verde': null,
    'Azul violeta': null,
    'Azur': null,
    'Banana': null,
    'Barbecho': null,
    'Begonia': null,
    'Beige': null,
    'Berenjena': null,
    'Bermejo': null,
    'Bermellón': null,
    'Bígaro': null,
    'Bistre': null,
    'Bistre marrón': null,
    'Blanco (puro)': null,
    'Blanco de cinc': null,
    'Blanco humo': null,
    'Blanco navajo': null,
    'Borgoña': null,
    'Bronce': null,
    'Bronceado': null,
    'Burdeos': null,
    'Café': null,
    'Calabaza': null,
    'Calipso': null,
    'Café con leche': null,
    'Camello': null,
    'Canela': null,
    'Caoba': null,
    'Caqui': null,
    'Caramelo': null,
    'Carbón': null,
    'Cardenal': null,
    'Cardenillo': null,
    'Cardo': null,
    'Carmesí': null,
    'Carmín': null,
    'Carmín alizarina': null,
    'Carne': null,
    'Cartujo': null,
    'Castaña': null,
    'Celeste (estándar)': null,
    'Celeste (espectral)': null,
    'Ceniza': null,
    'Cerceta': null,
    'Cereza': null,
    'Cerúleo': null,
    'Cetrino': null,
    'Champán': null,
    'Chartreuse': null,
    'Chocolate': null,
    'Cian (puro)': null,
    'Cian (CMYK)': null,
    'Ciruela': null,
    'Cobre': null,
    'Concha': null,
    'Conchevino': null,
    'Coral': null,
    'Cordobán': null,
    'Corinto': null,
    'Crema': null,
    'Cuarzo': null,
    'Damasco': null,
    'Dorado': null,
    'Durazno': null,
    'Ébano': null,
    'Elefante': null,
    'Encaje antiguo': null,
    'Escarlata': null,
    'Espinaca': null,
    'Esmeralda': null,
    'Fandango': null,
    'Feldgrau': null,
    'Frambuesa': null,
    'Fucsia': null,
    'Gamuza': null,
    'Geranio': null,
    'Glauco': null,
    'Grafito': null,
    'Grana': null,
    'Granate': null,
    'Gris': null,
    'Gris acorazado': null,
    'Gris cadete': null,
    'Gris ceniza': null,
    'Gris de Davy': null,
    'Gris frío': null,
    'Gris de Payne': null,
    'Gules': null,
    'Gualda': null,
    'Guinda': null,
    'Guta': null,
    'Habano': null,
    'Herrumbre': null,
    'Hígado': null,
    'Hueso': null,
    'Humo': null,
    'Índigo': null,
    'Iris': null,
    'Jazmín': null,
    'Junquillo': null,
    'Jade': null,
    'Kalua': null,
    'Kaki': null,
    'Kiwi': null,
    'Lacre': null,
    'Lapislázuli': null,
    'Latón': null,
    'Lava': null,
    'Lava fundida': null,
    'Lavanda': null,
    'León': null,
    'Lila': null,
    'Lima': null,
    'Lima-limón': null,
    'Limón': null,
    'Lino': null,
    'Lirio': null,
    'Llama': null,
    'Lombarda': null,
    'Lúcuma': null,
    'Magenta (puro)': null,
    'Magenta (CMYK)': null,
    'Maíz': null,
    'Malaquita': null,
    'Malva': null,
    'Mamey': null,
    'Mandarina': null,
    'Marfil': null,
    'Marrón': null,
    'Marrón dorado': null,
    'Marrón cuero': null,
    'Melocotón': null,
    'Melón': null,
    'Menta': null,
    'Miel': null,
    'Morado': null,
    'Mostaza': null,
    'Musgo': null,
    'Naranja (estándar)': null,
    'Naranja (espectral)': null,
    'Naranja cadmio': null,
    'Naranja caqui': null,
    'Naranja persa': null,
    'Negro (absoluto)': null,
    'Negro (CMYK)': null,
    'Negro de humo': null,
    'Negro bujía': null,
    'Níquel': null,
    'Ocaso': null,
    'Ocre': null,
    'Ocre amarillo': null,
    'Ocre dorado': null,
    'Ocre pardo': null,
    'Ocre rojo': null,
    'Oro': null,
    'Oro viejo': null,
    'Orquídea': null,
    'Oliva': null,
    'Rojo': null,
    'Rojo (puro)': null,
    'Rojo anaranjado': null,
    'Rojo coral': null,
    'Rojo Falun': null,
    'Rojo Ferrari': null,
    'Rojo fucsia': null,
    'Rojo indio': null,
    'Rojo magenta': null,
    'Rojo neón': null,
    'Rojo óxido': null,
    'Rojo persa': null,
    'Rojo púrpura': null,
    'Rojo sangre': null,
    'Rojo toscano': null,
    'Rojo Upsdell': null,
    'Rojo veneciano': null,
    'Rojo violeta': null,
    'Rosa': null,
    'Rosa coral': null,
    'Rosa lavanda': null,
    'Rosa malva': null,
    'Rosa mexicano': null,
    'Rosa naranja': null,
    'Rubí': null,
    'Rufo': null,
    'Salmón': null,
    'Sangría': null,
    'Secuoya': null,
    'Sepia': null,
    'Siena': null,
    'Sinople': null,
    'Té verde': null,
    'Teja': null,
    'Tomate': null,
    'Torcaza': null,
    'Trigo': null,
    'Turquí': null,
    'Turquesa': null,
    'Ultramar': null,
    'Uva': null,
    'Vainilla': null,
    'Verde (estándar)': null,
    'Verde (puro)': null,
    'Verde amarillo': null,
    'Verde azulado': null,
    'Verde bosque': null,
    'Verde botella': null,
    'Verde británico de carreras': null,
    'Verde ceniza': null,
    'Verde cian': null,
    'Verde claro': null,
    'Verde esmeralda': null,
    'Verde ftalo': null,
    'Verde Hooker': null,
    'Verde limón': null,
    'Verde loro': null,
    'Verde manzana': null,
    'Verde mar': null,
    'Verde menta': null,
    'Verde militar': null,
    'Verde oliva': null,
    'Verde oscuro': null,
    'Verde petróleo': null,
    'Verde primavera': null,
    'Verde': null,
    'Verdete': null,
    'Vino': null,
    'Violeta': null,
    'Violeta (espectral)': null,
    'Violín': null,
    'Viridián': null,
    'Wasabi': null,
    'Wengué': null,
    'Xanadú': null,
    'Xántico ': null,
    'Yema': null,
    'Yeso': null,
    'Zafiro': null,
    'Zanahoria': null,
    'Zinc': null
};