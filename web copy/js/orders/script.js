$("form#confirm-form").submit(function(e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    var showAlert = false;
    var manufacture = 0;
    var purchase = 0;
    $.when(
        $('input.manufacture').each(function(){
            // Check to-manufacture pieces values
            if($(this).val()){
                manufacture = parseInt($(this).val());
            } else {
                manufacture = parseInt($(this).attr('placeholder'));
            }
            // Check to-purchase pieces values
            var name = $(this).attr('name');
            var ipName = name.replace("Manufacture", "Purchase");
            var purInput = $('input[name="'+ipName+'"]');
            if(purInput.val()){
                purchase = parseInt(purInput.val());
            } else {
                purchase = 0;
            }
            if((manufacture + purchase) < parseInt($(this).attr('placeholder'))){
              showAlert = true;
            }
        })
    ).then(
        function () {
            if(showAlert === true){
                Swal.fire({
                    title: 'No se puede continuar',
                    text: 'La suma de las piezas a fabricar y comprar no cumple con al menos la cantidad solicitada en la orden.',
                    type: 'error',
                });
            } else {
                $("form#confirm-form").off('submit').submit();
                //alert('the form would submit now gj');
            }
        }
    );
    return false;
});