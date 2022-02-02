$(document).ready(function() {
        
        
        // update a single token
        $(document).on('click', '.token-update', function() {

            var $button = $(this);

            var token_id   = $(this).attr('id').split('-').pop();
            var content = encodeURIComponent($('#tokens-' + token_id  + '-content').val());

            $('#spinner-'+token_id).fadeTo('fast', 1);

            

            $.ajax({
                url: '/tokens/updateToken',
                data: {
                    "token_id" : token_id,
                    "content" : content
                },
                dataType: 'json',
                complete: function(){
                    return false;
                },
                success: function(result) {
                    
                    $('#spinner-'+token_id).fadeTo('fast', 0);
                    
                    if(result == 1) {
                        
                    }
                    return false;
                }
            });

            return false;
        });


        $(document).on('click', "a[href*='page:'], a[href*='sort:']", function() {
            updateIndex($(this).attr('href'));
            return false;
        });

});


function updateIndex(link) {
    $('#token-index-wrapper').fadeTo('fast', 0, function() {
        $('#token-index-wrapper').load(link, function() {
            $('#token-index-wrapper').fadeTo('fast', 1, function() {
                return false;
            });
            return false;
        });
        return false;
    });
    return;
}
