$(document).ready(function() {

    /* define the message fade globally */
    jQuery.fn.delay = function(b,a){
        return this.each(function(){
            setTimeout(a,b)
        })
    };

    $("#flashMessage").delay(10000,function(){
        $("#flashMessage").fadeOut(2000);
    });

});


function prepareFocus(modal_id, fieldname_id) {

    // set focus when modal is shown
    $("#"+modal_id).on('shown.bs.modal', function() {
        $('#'+fieldname_id).focus();
    });

    return false;
};


function setFlash(message, flash_class) {

    var flash = '<div style="display: none;" id="flashMessage" class="'+flash_class+'">'+message+'</div>';
    $('body').append(flash); 
    $('#flashMessage').fadeIn('fast');
    return;
};
