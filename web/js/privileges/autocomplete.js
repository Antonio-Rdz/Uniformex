$(document).ready(function(){
    let controllers = $("#controllers_serialized");
    let ctrl_input = $("#privileges-controller");
    // Load controllers suggestions
    ctrl_input.autocomplete({data: JSON.parse(controllers.val())});
    controllers.remove();

    if(ctrl_input){
        $('#privileges-controller').trigger('change');
    }
});

$('#privileges-controller').change(function () {
    let controller = $(this).val();
    let all = JSON.parse($("#controllers_and_actions_serialized").val());
    if(all[controller]){
        var obj = {}; // {} will create an object
        for(var i=0; i < all[controller].length; i++) {
            var k = all[controller][i];
            obj[k] = "";
        }
        $('#privileges-action').autocomplete({data:obj});
    }
});