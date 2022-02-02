$(document).ready(function() {

    var draft_id = parseInt($('#creator-draft-id').text());

    applySortableToGroups();
    applySortableToQuestions();


    // handle quick-saving of the edited poll-draft (will be stored in session, not DB)
    $(document).on('click', '#creator-trigger-quicksave-edit', function() {
        quickSaveDraft();
        return false;
    });


    // handle quick-saving of the edited poll-draft (will be stored in session, not DB)
    $(document).on('click', '#creator-trigger-cancel', function() {
        document.location = '/drafts/cancelDraftEdit/' + draft_id;
        return false;
    });


    // reset the currently added draft back to DB values (discard all changes from the edit)
    $(document).on('click', '#creator-trigger-save-edit', function() {
        saveDraft();
        return false;
    });


    // handle saving of the edited poll-draft
    $(document).on('click', '#creator-trigger-reset-edit', function() {
        resetDraft(draft_id);
        return false;
    });


    // handle toggling of all group-containers
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


    // handle pressing enter within inplace-edit field
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

            quickSaveDraft();
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
        group.find('span.creator-trigger-group-edit-title').attr('id', 'creator-trigger-group-edit-title-0');

        $('#draft-wrapper').append(group);
        group.fadeIn('fast', function() {
            return false;
        });

        applySortableToGroups();

        $('html, body').animate({
            scrollTop: group.offset().top - 200
        }, 1000);

        quickSaveDraft();

        return false;
    });


    // delete a group
    $(document).on('click', '.creator-trigger-group-delete', function() {

        var group = $(this).closest('div.creator-group');
        var group_id = group.find('span.creator-trigger-group-edit-title').attr('id').split('-').pop();

        group.fadeOut('fast', function() {
            group.remove();
            quickSaveDraft();
        });

        applySortableToGroups();

        //creatorGroupDelete(group_id);

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

            quickSaveDraft();
        }

        return false;
    });


    // add a question container
    $(document).on('click', '.creator-trigger-group-add-question', function() {

        var creator_group = $(this).closest('div.creator-group');

        var template_question_html = $('#wrapper-template-question').html();
        var question = $(template_question_html).hide();
        question.find('span.creator-trigger-question-edit').attr('id', 'creator-trigger-question-edit-0');

        creator_group.find('ul.question-wrapper').append(question);
        question.fadeIn('fast', function() {
            quickSaveDraft();
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
            quickSaveDraft();
        });

        applySortableToQuestions();

        

        return false;
    });


}); 


function applySortableToGroups() {
    
    $('#draft-wrapper').sortable({
        //handle: '.panel-heading', 
        handle: '.creator-trigger-group-drag', 
        opacity: 0.8,
        helper: 'clone',
        cursor: 'move',
        revert: 50,
        items: '> div.creator-group',
        stop: function( event, ui ) {
            var group_id = ui.item.find('span.creator-trigger-group-edit-title').attr('id').split('-').pop();
            console.log('moved group id: ' + group_id);
            quickSaveDraft();
        }
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
        connectWith: $('.question-wrapper'),
        stop: function( event, ui ) {
            var question_id = ui.item.find('span.creator-trigger-question-edit').attr('id').split('-').pop();
            console.log('moved question id: ' + question_id);
            quickSaveDraft();
        }
    });

    return;    
}


/**
* collect all creator-data, map the data to the same
* structure as Cake will expect and send it
* to the controller's editDraft() function
*
* @author digitalcube GmbH Co KG <dev@digital-cube.de>
* @param void
* @return boolean
*/
function collectData() {

    // holder for the creator-data (will be sent as dataset to controller)
    var creator_data = {};

    creator_data['Draft'] = {};
    creator_data['Draft']['id']     = $('#creator-draft-id').text();
    creator_data['Draft']['locale'] = $('#creator-draft-locale').val();
    creator_data['Draft']['status'] = $('#creator-draft-status').val();
    
    var draft_id = parseInt($('#creator-draft-id').text());
    var scale = $('#creator-draft-scale').val();
    var locale = creator_data['Draft']['locale'];

    creator_data['Draft']['name_' + locale]   = $('#creator-draft-name').val();

    // prepare and collect all groups from the creator
    creator_data['DraftsGroup'] = {};

    var position_group = 1;
    
    $('.creator-group:visible').each(function(i, group) {

        var group = $(this);
        var group_name = $.trim(group.find('span.creator-trigger-group-edit-title').text());
        var group_id = group.find('span.creator-trigger-group-edit-title').attr('id').split('-').pop();

        creator_data['DraftsGroup'][i] = {};
        creator_data['DraftsGroup'][i]['id']                = group_id;
        creator_data['DraftsGroup'][i]['name_' + locale]    = group_name;
        creator_data['DraftsGroup'][i]['position']          = position_group;

        var items = group.find('ul.question-wrapper');

        position_group++;

        creator_data['DraftsGroup'][i]['DraftsGroupsQuestion'] = {};

        var position_question = 1;

        items.children('li').each(function(k, question) {

            var item = $(this);
            var question_question = $.trim(item.find('span.creator-trigger-question-edit').text());
            var question_id = item.find('span.creator-trigger-question-edit').attr('id').split('-').pop();

            creator_data['DraftsGroup'][i]['DraftsGroupsQuestion'][k] = {};
            creator_data['DraftsGroup'][i]['DraftsGroupsQuestion'][k]['id']                 = question_id;
            creator_data['DraftsGroup'][i]['DraftsGroupsQuestion'][k]['draft_id']           = draft_id;
            creator_data['DraftsGroup'][i]['DraftsGroupsQuestion'][k]['drafts_group_id']    = group_id;
            creator_data['DraftsGroup'][i]['DraftsGroupsQuestion'][k]['question_' + locale] = question_question;
            creator_data['DraftsGroup'][i]['DraftsGroupsQuestion'][k]['position']           = position_question;
            creator_data['DraftsGroup'][i]['DraftsGroupsQuestion'][k]['scale']              = scale;

            position_question++;
        });
    });
    
    return creator_data;
}



function saveDraft() {

    var collected_data = collectData();

    // check = validateDraft(collected_data);

    $.ajax({ 
        url: "/drafts/editDraft",
        type: "POST",
        data: collected_data,
        success: function(result) {
            document.location = '/drafts/admin_view/' + collected_data['Draft']['id'];
            return false;
        }
    });

    return false;
}


function quickSaveDraft() {

    var collected_data = collectData();

    // console.log(collected_data);
    // return false;

    // check = validateDraft(collected_data);

    $.ajax({
        url: "/drafts/quickSaveDraft",
        type: "POST",
        data: collected_data,
        success: function(result) {

            console.log(result);
            return false;

            if(result == true) {
                //document.location = '/drafts/admin_view/' + draft_id;
            } else {
                console.log('show some error message when saving fails');
            }
            return false;
        }
    });

    return false;
}


function resetDraft(draft_id) {

    // check = validateDraft(collected_data);

    $.ajax({
        url: "/drafts/resetDraft",
        dateType: 'json',
        data: {
            'draft_id': draft_id
        },
        success: function(result) {
            if(result == true) {
                document.location = '/drafts/admin_edit/' + draft_id + '/' + $('#creator-draft-locale').val();
            } else {
                console.log('show some error message when saving fails');
            }
            return false;
        }
    });

    return false;
}
