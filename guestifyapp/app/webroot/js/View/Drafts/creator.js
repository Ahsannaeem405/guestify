function applySortableToGroups() {
    
    $('#draft-wrapper').sortable({
        //handle: '.panel-heading', 
        handle: '.creator-trigger-group-drag', 
        opacity: 0.8,
        helper: 'clone',
        cursor: 'move',
        revert: 50,
        items: '> div.creator-group'
    });

    return;    
}

function applySortableToQuestions() {
    
    $('.question-wrapper').sortable({
        //handle: '.panel-heading', 
        handle: '.creator-trigger-question-drag', 
        opacity: 0.8,
        helper: 'clone',
        cursor: 'move',
        revert: 50,
        items: '> .list-group-item',
        connectWith: $('.question-wrapper')
    });

    return;    
}



$(document).ready(function() {

    $('#draft-wrapper').sortable({
        //handle: '.panel-heading', 
        handle: '.creator-trigger-group-drag', 
        opacity: 0.8,
        helper: 'clone',
        cursor: 'move',
        revert: 50,
        items: '> div.creator-group'
    });


    $('.question-wrapper').sortable({
        //handle: '.panel-heading', 
        handle: '.creator-trigger-question-drag', 
        opacity: 0.8,
        helper: 'clone',
        cursor: 'move',
        revert: 50,
        items: '> .list-group-item',
        connectWith: $('.question-wrapper')
    });


    // $('.tooltip-top').tooltip({
    //     placement: 'top'
    // });

    // $('.tooltip-bottom').tooltip({
    //     placement: 'bottom'
    // });

    // $('.tooltip-left').tooltip({
    //     placement: 'left'
    // });

    // $('.tooltip-right').tooltip({
    //     placement: 'right'
    // });
    
    var creator_data = {};


    // handle saving of the created poll-draft
    $(document).on('click', '#creator-trigger-save', function() {

        $('div.error-message').remove();
        $('#errors-groups_empty').hide();
        $('#errors-questions_empty').hide();

        creator_data['Draft'] = {};
        creator_data['Draft']['name']   = $('#creator-draft-name').val();
        creator_data['Draft']['locale'] = $('#creator-draft-locale').val();
        creator_data['Draft']['status']  = $('#creator-draft-status').val();
        creator_data['Draft']['scale']  = $('#creator-draft-scale').val();


        creator_data['Groups'] = {};

        $('.creator-group:visible').each(function(i, group) {

            var group = $(this);
            var group_name = group.find('span.creator-trigger-group-edit-title').text();

            creator_data['Groups'][i] = {};
            creator_data['Groups'][i]['Group'] = {};
            creator_data['Groups'][i]['Group']['name'] = group_name;

            creator_data['Groups'][i]['Questions'] = {};

            var items = group.find('ul.question-wrapper');

            items.children('li').each(function(k, question) {
                var question = $(this).find('span.creator-trigger-question-edit').text();
                creator_data['Groups'][i]['Questions'][k] = {};
                creator_data['Groups'][i]['Questions'][k]['Question'] = {};
                creator_data['Groups'][i]['Questions'][k]['Question']['question'] = question;
            });
        });

        $.ajax({
            url: "/drafts/addDraft",
            dataType: "json",
            data: creator_data,
            success: function(result) {

                if(typeof result == 'object') {

                    jQuery.each(result, function(field, message) {

                        if(field == 'groups_empty') {
                            $('#errors-groups_empty').fadeIn('fast', function() {
                                return false;
                            });
                        } else if(field == 'questions_empty') {
                            $('#errors-questions_empty').fadeIn('fast', function() {
                                return false;
                            });
                        } else {
                            var error_div = $('<div class="error-message alert alert-danger">' + message + '</div>').hide();
                            $('#creator-draft-' + field).closest('div.input').after(error_div);
                            error_div.fadeIn('fast', function() {
                                return false;
                            });
                        }
                    });

                    $('html, body').animate({
                        scrollTop: $("div.error-message:first").offset().top - 200
                    }, 500);

                } else {

                    document.location = '/drafts/admin_view/' + result;
                }

                return false;
            }
        });

        return false;
    });


    // handle saving of the edited poll-draft
    $(document).on('click', '#creator-trigger-save-edit', function() {


        creator_data['Draft'] = {};
        creator_data['Draft']['id']     = $('#draft-id').text();
        creator_data['Draft']['locale'] = $('#draft-locale').text();
        creator_data['Draft']['locale'] = $('#creator-draft-locale').val();
        creator_data['Draft']['name']   = $('#creator-draft-name').val();
        creator_data['Draft']['scale']  = $('#creator-draft-scale').val();

        creator_data['Groups'] = {};

        $('.creator-group:visible').each(function(i, group) {

            var group = $(this);
            var group_name = $.trim(group.find('span.creator-trigger-group-edit-title').text());

            creator_data['Groups'][i] = {};
            creator_data['Groups'][i]['Group'] = {};
            creator_data['Groups'][i]['Group']['name'] = group_name;

            creator_data['Groups'][i]['Questions'] = {};

            var items = group.find('ul.question-wrapper');

            items.children('li').each(function(k, question) {
                var question = $.trim($(this).find('span.creator-trigger-question-edit').text());
                creator_data['Groups'][i]['Questions'][k] = {};
                creator_data['Groups'][i]['Questions'][k]['Question'] = {};
                creator_data['Groups'][i]['Questions'][k]['Question']['question'] = question;
            });
        });

        $.ajax({
            url: "/drafts/editDraft",
            type: "POST",
            data: creator_data,
            success: function(result) {
                
                //document.location = '/drafts/admin_view/' + result;
                
                console.log(result);
                return false;
            }
        });

        return false;
    });

    // handle editing of question
    $(document).on('click', '.creator-trigger-group-toggle-all', function() {

        if($(this).hasClass('hide-all')) {
            $(this).removeClass('hide-all');
            $(this).addClass('show-all');
            $('#draft-wrapper').find('div.panel-body').slideUp('fast', function() {
                $('.btn-toolbar').each(function(i, obj) {
                    $(this).find('span.glyphicon-chevron-up').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
                });
                return false;
            });
        } else if($(this).hasClass('show-all')) {
            $(this).removeClass('show-all');
            $(this).addClass('hide-all');
            $('#draft-wrapper').find('div.panel-body').slideDown('fast', function() {
                $('.btn-toolbar').each(function(i, obj) {
                    $(this).find('span.glyphicon-chevron-down').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
                });
                return false;
            });
        }

        return false;
    });


    // handle editing of group names
    $(document).on('click', 'span.creator-trigger-group-edit-title', function() {

        var panel_heading = $(this).closest('.panel-heading');

        var span = $(this);
        var current_text = $.trim(span.text());

        var hidden_input = panel_heading.find('.creator-input-group-edit-title');

        hidden_input.val(current_text);

        span.hide().after(hidden_input);
        hidden_input.show().focus();
        hidden_input.select();

        return false;
    });


    $(document).on('keyup', '.creator-input-group-edit-title', function(event) {

        var panel_heading = $(this).closest('.panel-heading');

        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {

            var input = panel_heading.find('.creator-input-group-edit-title');
            var input_text = $.trim(input.val());

            var hidden_span = panel_heading.find('span.creator-trigger-group-edit-title');

            hidden_span.text(input_text);
            input.hide().after(hidden_span);
            hidden_span.show();
        }


        return false;
    });



    // show/hide the questions of a group
    $(document).on('click', '.creator-trigger-group-hide', function() {

        var creator_group = $(this).closest('div.creator-group');

        var trigger = $(this);
        trigger.find('span').removeClass('glyphicon-chevron-up');
        trigger.find('span').addClass('glyphicon-chevron-down');

        trigger.removeClass('creator-trigger-group-hide');
        trigger.addClass('creator-trigger-group-show');

        creator_group.find('div.panel-body').slideToggle('fast', function() {
            return false;
        });

        return false;
    });


    $(document).on('click', '.creator-trigger-group-show', function() {

        var creator_group = $(this).closest('div.creator-group');

        var trigger = $(this);
        trigger.find('span').removeClass('glyphicon-chevron-down');
        trigger.find('span').addClass('glyphicon-chevron-up');

        trigger.removeClass('creator-trigger-group-show');
        trigger.addClass('creator-trigger-group-hide');

        creator_group.find('div.panel-body').slideToggle('fast', function() {
            return false;
        });

        return false;
    });

    // add a group container
    $(document).on('click', '.creator-trigger-group-add', function() {

        var template_group_html = $('#wrapper-template-group').html();
        var group = $(template_group_html).hide();

        $('#draft-wrapper').append(group);
        group.fadeIn('fast', function() {
            return false;
        });

        applySortableToGroups();

        $('html, body').animate({
            scrollTop: group.offset().top - 200
        }, 1000);

        return false;
    });

    // delete a group
    $(document).on('click', '.creator-trigger-group-delete', function() {

        var group = $(this).closest('div.creator-group');
        group.fadeOut('fast', function() {
            group.remove();
        });

        applySortableToGroups();

        return false;
    });  



    // handle editing of question
    $(document).on('click', 'span.creator-trigger-question-edit', function() {

        var list_item = $(this).closest('li.list-group-item');

        var span = $(this);
        var current_text = $.trim(span.text());

        var hidden_input = list_item.find('.creator-input-question-edit');
        hidden_input.val(current_text);

        span.hide().after(hidden_input);
        hidden_input.show().focus();
        hidden_input.select();

        return false;
    });


    // handle editing of questions
    $(document).on('keyup', '.creator-input-question-edit', function(event) {

        var list_item = $(this).closest('li.list-group-item');

        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {

            var input = list_item.find('.creator-input-question-edit');
            var input_text = $.trim(input.val());
            if(input_text == '') {
                return false;
            }

            var hidden_span = list_item.find('span.creator-trigger-question-edit');

            hidden_span.text(input_text);
            input.hide().after(hidden_span);
            hidden_span.show();
        }


        return false;
    });






    // add a question container
    $(document).on('click', '.creator-trigger-group-add-question', function() {

        var creator_group = $(this).closest('div.creator-group');

        var template_question_html = $('#wrapper-template-question').html();
        var question = $(template_question_html).hide();

        creator_group.find('ul.question-wrapper').append(question);
        question.fadeIn('fast', function() {
            return false;
        });

        applySortableToQuestions();

        return false;
    });


    // delete a question entry
    $(document).on('click', '.creator-trigger-question-delete', function() {

        var question = $(this).closest('li.list-group-item');
        question.fadeOut('fast', function() {
            question.remove();
        });

        applySortableToQuestions();

        return false;
    });




}); 

