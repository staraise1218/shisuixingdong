define(['jquery', 'bootstrap', 'frontend', 'form', 'template'], function ($, undefined, Frontend, Form, Template) {
    var validatoroptions = {
        invalid: function (form, errors) {
            $.each(errors, function (i, j) {
                Layer.msg(j);
            });
        }
    };
    var Controller = {

        index: function () {
            Form.events.citypicker($("#city"));
            Form.api.bindevent("form[role=diqu]")
        },
        donation: function(){
            $('#donation-form').data('validator-options', validatoroptions);

            Form.api.bindevent($('#donation-form'), function(data, ret) {
                
                $('.paybtn').attr('disabled', true);
                setTimeout(function () {
                    location.href = data.paymentMethodUrl;
                }, 1000);

            }, function(data, ret){

                $('.paybtn').attr('disabled', false);

            }, function(success, error){

                if($('.paybtn').attr('disabled') == 'disabled'){
                    return false;
                }
                
            });
        }
    };
    return Controller;
});