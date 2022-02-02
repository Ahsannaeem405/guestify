
$(document).ready(function() {

    $('#ok-sign-panel-1').hide();
    $('#ok-sign-panel-2').hide();
    $('#ok-sign-panel-3').hide();

    var current_step    = $('#wizard-current_step').val();

    var name_company    = $('#accounts-company_name').val();
    var name_host       = $('#hosts-name').val();
    var title_poll      = $('#polls-title').val();

    var first_poll_id   = '';

    if(name_host != '') {
        $('#ok-sign-panel-1').show();
    }
    if(name_company != '') {
        $('#ok-sign-panel-2').show();
    }
    if(title_poll != '') {
        $('#ok-sign-panel-3').show();
    }

    $('#wrapper-panels').cycle({ 
        fx:     'scrollLeft', 
        easing:  'easeInOutBack',
        timeout: 0, 
        width: 600,
        fit: true
    });

    // rework this to reflect current step (see session!)
    $('div.slide-1').show();


    $(document).on('click', '#accounts-use_host_address', function() {

        if($(this).is(':checked')) {
            $('#accounts-address').val($('#hosts-address').val()).attr('disabled', true);
            $('#accounts-zipcode').val($('#hosts-zipcode').val()).attr('disabled', true);
            $('#accounts-city').val($('#hosts-city').val()).attr('disabled', true);
            $('#accounts-country_id').val($('#hosts-country_id').val()).attr('disabled', true);
        } else {
            $('#accounts-address').attr('disabled', false);
            $('#accounts-zipcode').attr('disabled', false);
            $('#accounts-city').attr('disabled', false);
            $('#accounts-country_id').attr('disabled', false);
        }
    });
    


    $(document).on('click', '#save-step-1', function() {

        $('#panel-step-1').find('div.error-message').hide().empty();

        $.ajax({
            url: '/accounts/saveStep1',
            data: {
                "name"      : encodeURIComponent($('#hosts-name').val()),
                "address"   : encodeURIComponent($('#hosts-address').val()),
                "zipcode"   : encodeURIComponent($('#hosts-zipcode').val()),
                "city"      : encodeURIComponent($('#hosts-city').val()),
                "country_id": encodeURIComponent($('#hosts-country_id').val()),
            },
            dataType: 'json',
            success: function(result) {

                if(typeof result =='object') {
                    
                    $('#ok-sign-panel-1').hide();

                    //$('#modal-spinner-host-add').hide('fast');
                    jQuery.each(result, function(field, message) {
                        $('#hosts-'+field).next('div.error-message').html(message).fadeIn('fast');
                    });

                } else {

                    $('#ok-sign-panel-1').show();

                    // if account info is empty, fill it with the host data!

                    $('#accounts-address').val($('#hosts-address').val());
                    $('#accounts-zipcode').val($('#hosts-zipcode').val());
                    $('#accounts-city').val($('#hosts-city').val());
                    $('#accounts-country_id').val($('#hosts-country_id').val());

                    $('#wrapper-panels').cycle(1);
                }

                return false;
            }
        });

        return false;
    });


    $(document).on('click', '#save-step-2', function() {

        $('#panel-step-2').find('div.error-message').hide().empty();

        $.ajax({
            url: '/accounts/saveStep2',
            data: {
                "company_name" : encodeURIComponent($('#accounts-company_name').val()),
                "address" : encodeURIComponent($('#accounts-address').val()),
                "zipcode" : encodeURIComponent($('#accounts-zipcode').val()),
                "city" : encodeURIComponent($('#accounts-city').val()),
                "country_id" : encodeURIComponent($('#accounts-country_id').val()),
            },
            dataType: 'json',
            success: function(result) {

                if(typeof result =='object') {
                    $('#ok-sign-panel-2').hide();
                    jQuery.each(result, function(field, message) {
                        $('#accounts-'+field).next('div.error-message').html(message).fadeIn('fast');
                    });
                } else {
                     $('#ok-sign-panel-2').show();
                     $('#wrapper-panels').cycle(2);
                }

                return false;
            }
        });
        
        return false;
    });



    $(document).on('click', '#save-step-3', function() {

         $('#panel-step-3').find('div.error-message').hide().empty();

        $.ajax({
            url: '/accounts/saveStep3',
            data: {
                "title"      : encodeURIComponent($('#polls-title').val()),
                "code"       : encodeURIComponent($('#polls-code').val()),
                "template_id": encodeURIComponent($('#polls-template_id').val()),
                "scale"      : encodeURIComponent($('#polls-scale').val())
            },
            dataType: 'json',
            success: function(result) {

                if(typeof result =='object') {
                    
                    $('#ok-sign-panel-3').hide();
                    jQuery.each(result, function(field, message) {
                        $('#polls-'+field).next('div.error-message').html(message).fadeIn('fast');
                    });

                } else {

                    $('#ok-sign-panel-3').show();
                    window.location = '/polls/settings/'+result;

                }

                return false;
            }
        });

        return false;
    });


    $(document).on('click', '#goto-step-1', function() {
        $('#panel-step-1').find('div.error-message').hide().empty();
        $('#wrapper-panels').cycle(0, 'scrollRight');
        return false;
    });

    $(document).on('click', '#goto-step-2', function() {
        $('#panel-step-2').find('div.error-message').hide().empty();
        $('#wrapper-panels').cycle(1, 'scrollRight');
        return false;
    });




    $(document).on('change', '#polls-template_id', function() {
        var template_id = $(this).val();
        
        if(template_id != '') {
            $('#wrapper-template-info').fadeIn('fast', function() {
                return false;
            });
        } else {
            $('#wrapper-template-info').fadeOut('fast', function() {
                return false;
            });
        }
        return false;
    });

    $(document).on('click', '#trigger-template-show', function() {
        var template_id = $('#polls-template_id').val();
        
        $('#modal-template-details').modal('show');
        $('div.wrapper-templates').fadeOut('fast').promise().done(function() {
             if(template_id != '') {
                $('#wrapper-template-'+template_id).fadeIn('fast').promise().done(function() {
                    return false;
                });
            }
            return false;
        });
        return false;
    });

});

/*
function showStep1() {
    $('#panel-step-3').fadeOut('fast', function() {
        $('#panel-step-2').fadeOut('fast', function() {
            $('#panel-step-1').fadeIn('fast', function() {
                return false;
            });
            return false;
        });
        return false;
    });
    return;
}

function showStep2() {
    $('#panel-step-3').fadeOut('fast', function() {
        $('#panel-step-1').fadeOut('fast', function() {
            $('#panel-step-2').fadeIn('fast', function() {
                return false;
            });
            return false;
        });
        return false;
    });
    return;
}

function showStep3() {
    $('#panel-step-2').fadeOut('fast', function() {
        $('#panel-step-1').fadeOut('fast', function() {
            $('#panel-step-3').fadeIn('fast', function() {
                return false;
            });
            return false;
        });
        return false;
    });
    return;
}
*/