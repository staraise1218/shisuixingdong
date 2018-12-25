define(['jquery', 'bootstrap', 'frontend', 'form', 'template'], function ($, undefined, Frontend, Form, Template) {
    var validatoroptions = {
        invalid: function (form, errors) {
            $.each(errors, function (i, j) {
                Layer.msg(j);
            });
        }
    };
    var Controller = {
        donation: function(){
            $('#enroll-form').data('validator-options', validatoroptions);

            # Form.api.bindevent($('#enroll-form'), function(data, ret) {
            #     $('activityBtn').attr('disabled', true);
                

            # }, function(data, ret){

            #     $('activityBtn').attr('disabled', false);

            # }, function(success, error){

            #     if($('activityBtn').attr('disabled') == 'disabled'){
            #         return false;
            #     }
                
            # });
        }
    };
    return Controller;
});