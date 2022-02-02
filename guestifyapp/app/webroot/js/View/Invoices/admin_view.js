$(document).ready(function() {

    var invoice_id = 0;

    // mark as paid
    $(document).on('click', '.mark-paid', function() {
        
        invoice_id = $(this).attr('id').split('-').pop();

        $('#modal-invoice-mark-paid').modal('show');
        
        return false;
    });


    $(document).on('click', '#invoice-mark-paid-confirm', function() {

        $('#modal-spinner-invoice-mark-paid').show('fast');

        $.ajax({
            url: '/invoices/adminMarkPaid',
            data: {
                "invoice_id": invoice_id,
            },
            dataType: 'json',
            success: function(result) {
                if(result == true) {
                    // reload location
                    window.location.href = '/invoices/adminView/'+invoice_id;
                }

                return false;
            }
        });

        return false;
    });


    // mark as unpaid
    $(document).on('click', '.mark-unpaid', function() {
        
        invoice_id = $(this).attr('id').split('-').pop();
        
        $('#modal-invoice-mark-unpaid').modal('show');
        
        return false;
    });


    $(document).on('click', '#invoice-mark-unpaid-confirm', function() {

        $('#modal-spinner-invoice-mark-unpaid').show('fast');

        $.ajax({
            url: '/invoices/adminMarkUnpaid',
            data: {
                "invoice_id": invoice_id,
            },
            dataType: 'json',
            success: function(result) {
                if(result == true) {
                    // reload location
                    window.location.href = '/invoices/adminView/'+invoice_id;
                }

                return false;
            }
        });

        return false;
    });


    // mark as refunded
    $(document).on('click', '.mark-refunded', function() {
        
        invoice_id = $(this).attr('id').split('-').pop();
        
        $('#modal-invoice-mark-refunded').modal('show');
        
        return false;
    });


    $(document).on('click', '#invoice-mark-refunded-confirm', function() {

        $('#modal-spinner-invoice-mark-refunded').show('fast');

        $.ajax({
            url: '/invoices/adminMarkRefunded',
            data: {
                "invoice_id": invoice_id,
            },
            dataType: 'json',
            success: function(result) {
                if(result == true) {
                    // reload location
                    window.location.href = '/invoices/adminView/'+invoice_id;
                }

                return false;
            }
        });

        return false;
    });

});
