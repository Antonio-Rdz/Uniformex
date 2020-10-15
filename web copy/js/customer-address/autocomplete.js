$(document).ready(function () {
    let state = $("#customeraddresses-state_id").val();
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