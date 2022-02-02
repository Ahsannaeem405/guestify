
$(document).ready(function() {

    var account_id = 0;

    // call the host add modal
    $(document).on('click', '.add_host', function() {
        $('#hosts-name').val('');
        //$('#hosts-locale').val('');

        account_id = $(this).attr('id').split('-').pop();

        $('#modal-host-add').find('div.error-message').hide();
        $('#modal-host-add').modal('show');
        return false;
    });


    // confirm host add
    $(document).on('click', '#host-add-confirm', function() {

        $('#modal-spinner-host-add').show('fast');

        var name = encodeURIComponent($('#hosts-name').val());
        var locale = encodeURIComponent($('#hosts-locale').val());
        var timezone = encodeURIComponent($('#hosts-timezone').val());

        $.ajax({
            url: '/hosts/adminAdd',
            data: {
                "account_id":   account_id,
                "name"      : name,
                "locale"    : locale,
                "timezone"  : timezone
            },
            dataType: 'json',
            success: function(result) {

                if(typeof result =='object') {
                    $('#modal-spinner-host-add').hide('fast');
                    jQuery.each(result, function(field, message) {
                        $('#hosts-'+field).next('div.error-message').fadeIn('fast');
                    });
                } else {
                    window.location.href = '/hosts/adminView/'+result;
                }

                return false;
            }
        });

        return false;
    });

});

