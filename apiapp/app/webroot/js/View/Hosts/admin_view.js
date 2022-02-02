
$(document).ready(function() {

    var host_id = 0;


    // call the poll add modal
    $(document).on('click', '.add-poll', function() {
        
        host_id = $(this).attr('id').split('-').pop();

        $('#polls-title').val('');
        $('#polls-code').val('');
        $('#modal-poll-add').find('div.error-message').hide();
        $('#modal-poll-add').modal('show');
        return false;
    });


    // confirm poll add
    $(document).on('click', '#poll-add-confirm', function() {

        $('#modal-spinner-poll-add').show('fast');

        var title = encodeURIComponent($('#polls-title').val());
        var locale  = encodeURIComponent($('#polls-locale').val());
        var code    = encodeURIComponent($('#polls-code').val());

        $.ajax({
            url: '/polls/adminAdd',
            data: {
                "title"    :   title,
                "host_id"  :   host_id,
                "locale"   :   locale,
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
                    window.location.href = '/polls/adminSettings/'+result;
                }

                return false;
            }
        });

        return false;
    });

});

