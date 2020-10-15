$(".assign").change(function () {
    _input = $("#lineassignments-order_detail_id");
    if (this.checked) {
        _input.val(parseInt($(this).val()));
    }
    _assign = $('.assign:checked');
    if(_assign.length === 0){
        _input.val("");
    }
});