$(document).ready(function() {

    var guest_id = '';
    var trigger = '';


    $(document).on('click', '.mark-invalid', function() {
        guest_id = $(this).attr('id').split('-').pop();
        trigger = $(this);
        $('#modal-mark-invalid').modal('show');
        return false;
    });

    $(document).on('click', '#mark-invalid-confirm', function() {

        $('#modal-spinner-mark-invalid').show('fast');

        $.ajax({
            url: '/polls/ratingMarkInvalid',
            data: {
                "guest_id": guest_id
            },
            dataType: 'json',
            success: function(result) {

                if(result == 1) {
                    $('#modal-mark-invalid').modal('hide');
                    $('#modal-spinner-mark-invalid').show('hide');
                    trigger.removeClass('mark-invalid');
                    trigger.addClass('mark-valid');
                    trigger.find('span').removeClass('glyphicon-ban-circle');
                    trigger.find('span').addClass('glyphicon-ok-circle');
                    trigger.attr('id', 'mark-valid-'+guest_id);
                    setFlash($('#reload-page-text').text(), 'alert alert-info');
                }

                return false;
            }
        });

        return false;
    });

    $(document).on('click', '.mark-valid', function() {
        guest_id = $(this).attr('id').split('-').pop();
        trigger = $(this);
        $('#modal-mark-valid').modal('show');
        return false;
    });

    $(document).on('click', '#mark-valid-confirm', function() {

        $('#modal-spinner-mark-valid').show('fast');

        $.ajax({
            url: '/polls/ratingMarkValid',
            data: {
                "guest_id": guest_id
            },
            dataType: 'json',
            success: function(result) {

                if(result == 1) {
                    $('#modal-mark-valid').modal('hide');
                    $('#modal-spinner-mark-valid').show('hide');
                    trigger.removeClass('mark-valid');
                    trigger.addClass('mark-invalid');
                    trigger.find('span').removeClass('glyphicon-ok-circle');
                    trigger.find('span').addClass('glyphicon-ban-circle');
                    trigger.attr('id', 'mark-valid-'+guest_id);
                    //$('#mark-delete-'+guest_id).closest('tr').removeClass();
                    
                    // try to add "manual" class here if applies
                    //$('#mark-delete-'+guest_id).closest('tr').addClass('info');

                    setFlash($('#reload-page-text').text(), 'alert alert-info');
                }

                return false;
            }
        });

        return false;
    });



    $(document).on('click', '.mark-delete', function() {
        guest_id = $(this).attr('id').split('-').pop();
        $('#modal-mark-delete').modal('show');
        return false;
    });

    $(document).on('click', '#mark-delete-confirm', function() {

        $('#modal-spinner-mark-delete').show('fast');
        $.ajax({
            url: '/polls/ratingMarkDelete',
            data: {
                "guest_id": guest_id
            },
            dataType: 'json',
            success: function(result) {

                if(result == 1) {
                    $('#modal-mark-delete').modal('hide');
                    $('#modal-spinner-mark-delete').show('hide');
                    $('#mark-delete-'+guest_id).closest('tr').fadeOut('fast');

                    setFlash($('#reload-page-text').text(), 'alert alert-info');
                }

                return false;
            }
        });

        return false;
    });


    $(document).on('click', '.rating-info', function() {
        $('#modal-spinner-rating-info').show();
        guest_id = $(this).attr('id').split('-').pop();
        $('#modal-rating-info').modal('show');
        loadRatingInfo(guest_id);
        return false;
    });

});


function loadRatingInfo(guest_id) {

    $('#wrapper-rating-info').fadeTo('fast', 0, function() {
        $('#wrapper-rating-info').load('/polls/loadRatingInfo/'+guest_id, function() {
            $('#modal-spinner-rating-info').hide();
            $('#wrapper-rating-info').fadeTo('fast', 1, function() {
                return false;
            });
            return false;
        });
        return false;
    });

    return;
}