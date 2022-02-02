
$(document).ready(function() {

    $('#polls-template_id').val('');

    $(document).on('change', '#polls-template_id', function() {

        var template_id = $(this).val();

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


    $(document).on('click', '.add-poll', function() {
        $('#polls-title').val('');
        $('#polls-host_id').val('');
        $('#polls-code').val('');
        //$('#polls-locale').val('');
        $('#modal-poll-add').find('div.error-message').hide();
        $('#modal-poll-add').modal('show');
        return false;
    });


    $(document).on('click', '#poll-add-confirm', function() {

        $('#modal-spinner-poll-add').show('fast');

        var title   = encodeURIComponent($('#polls-title').val());
        var host_id = encodeURIComponent($('#polls-host_id').val());
        var scale   = encodeURIComponent($('#polls-scale').val());
        var code    = encodeURIComponent($('#polls-code').val());
        var template_id = encodeURIComponent($('#polls-template_id').val());

        $.ajax({
            url: '/polls/add',
            data: {
                "title"    :   title,
                "host_id"  :   host_id,
                "template_id"  :   template_id,
                "scale"  :   scale,
                "code"     :   code
            },
            dataType: 'json',
            success: function(result) {

                if(typeof result =='object') {
                    $('#modal-spinner-poll-add').hide('fast');
                    jQuery.each(result, function(field, message) {
                        $('#polls-'+field).next('div.error-message').empty().html(message).fadeIn('fast');
                    });
                } else {
                    window.location.href = '/polls/settings/'+result;
                }

                return false;
            }
        });

        return false;
    });

});

