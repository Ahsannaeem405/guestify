$(document).ready(function() {

    var poll_id = $('#upgrade-poll_id').text();

    $(document).on('change', '#period-selection input:radio', function() {
        var period = $('#period-selection input:radio:checked').val();
        var country_id = $('#invoices-country_id').val();
        updatePaymentMethodWrapper(period, country_id);
        updatePeriodWrapper(poll_id, period);
    });

    $(document).on('change', '#invoices-country_id', function() {
        var period = $('#period-selection input:radio:checked').val();
        var country_id = $('#invoices-country_id').val();
        updatePaymentMethodWrapper(period, country_id);
    });

    $(document).on('click', '.payment-submit', function() {
        var payment_type = $(this).attr('id');
        if(payment_type == 'payment_type-paypal') {
            $('#invoice-payment_type').val(1);
        } else if(payment_type == 'payment_type-on_account') {
            $('#invoice-payment_type').val(2);
        }
    });

});


function updatePaymentMethodWrapper(period, country_id) {

    $('#wrapper-payment-methods').fadeTo('fast', 0, function() {
        $('#wrapper-payment-methods').load('/polls/updatePaymentMethodWrapper/'+period+'/'+country_id, function() {
            $('#wrapper-payment-methods').fadeTo('fast', 1, function() {
                return false;
            });
            return false;
        });
        return false;
    });

    return;
}


function updatePeriodWrapper(poll_id, period) {

    $('#wrapper-period').fadeTo('fast', 0, function() {
        $('#wrapper-period').load('/polls/updatePeriodWrapper/'+poll_id+'/'+period, function() {
            $('#wrapper-period').fadeTo('fast', 1, function() {
                return false;
            });
            return false;
        });
        return false;
    });

    return;
}