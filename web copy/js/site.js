$('input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=number], input[type=search], input[type=date], input[type=time], textarea')
.keydown(function () {
    $(this).trigger("change");
    $(this).siblings('label').addClass('active');
}).focusout(function () {
    if($(this).val() === ''){
        $(this).siblings('label').removeClass('active');
    }
}).focusin(function () {
    $(this).siblings('label').addClass('active');
});


$('input.datepicker').on('change', function () {
    var name = $(this).attr('name');
    $('#'+name+'').val($(this).val());
});

$(document).on('click', '#btn-logout', function () {
    $('#logout-form').submit();
}).on('click', '.select-all', function () {
    let _this = $(this);
    let _selector = $("."+_this.data('selector'));
    if($("."+_this.data('selector')+':checked').lenght > 0){
        _selector.removeProp("checked");
    } else {
        _selector.prop("checked", true);
    }
}).on('click', 'tr.collapse-header', function(e){
    if(!$(e.target).hasClass('ignore')){
        _this = $(this);
        _this.next('.collapse-body').toggleClass('active');
    }
});

// Change default yii2 alert for sweetalert2
yii.confirm = function (message, okCallback) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: message,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, estoy seguro',
        cancelButtonText: 'Cancelar'
    }).then((selection) => {
        if(selection.value){okCallback();}
    })
};

$("#customeraddresses-state_id").change(function () {
    let state = $(this).val();
    $.ajax({
        "url": "/customer-addresses/get-cities",
        "dataType": "json",
        "data": {"state": state},
        "method": "GET",
        success: function (response) {
            $('#customeraddresses-city_id').autocomplete({data:response});
        }
    });
});

$(document).ready(function(){
    // Init material components
    $('.tooltipped').tooltip();
    $('.sidenav').sidenav();
    $('input.character-count, textarea.character-count').characterCounter();
    // Hide menus if empty
    $(".dropdown-content").each(function() {
        if($(this).children("li").length === 0) {
            $(this).hide();
        }
    });
    $('.new-materialboxed').materialbox_new();
    $('.collapsible').collapsible();
    $('.modal').modal();
    $('.chips').chips();
    $('select').formSelect();
});

$(document).on('pjax:success', function() {
    $('.tooltipped').tooltip();
    $('select').formSelect();
});