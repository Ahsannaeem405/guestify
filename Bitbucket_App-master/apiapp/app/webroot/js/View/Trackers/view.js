$(document).ready(function() {

	// holders
    var tracker_id          = parseInt($('#tracker-id').text());
    var trackers_link_id    = '';


    // toggle visibility of data-origin container
    $(document).on('click', '.toggle-data-origin', function() {
        $('#wrapper-data-origin').slideToggle('fast', function() {
            return false;
        });
        return false;
    });
    

    // trackers_link: show details
    $(document).on('click', '.trackers_link-show-details', function() {
        trackers_link_id = $(this).attr('id').split('-').pop();
        $('#modal-trackers_link-details-spinner').show();
        $('#modal-trackers_link-details-modal').modal('show');
        loadTrackersLinkDetails(trackers_link_id);
        return false;
    });


    // trackers_link edit - modal preparation
    $(document).on('click', '.trackers_link-edit', function() {
        trackers_link_id = $(this).attr('id').split('-').pop();
        $('#modal-trackers_link-edit-spinner').show();
        $('#modal-trackers_link-edit').modal('show');
        $('#modal-trackers_link-edit :input').attr('disabled', true);
        loadTrackersLinkDetailsForEdit(trackers_link_id);
        return false;
    });


    // trackers_link edit - save changes
    $(document).on('click', '#modal-trackers_link-edit-confirm', function() {
        $('#modal-trackers_link-edit-spinner').show();
        saveTrackersLinkDetails(trackers_link_id);
        return false;
    });






    // tracker: general information edit - modal call
    $(document).on('click', '.tracker-general_information-edit', function() {
        $('#modal-tracker-general_information-edit-spinner').show();
        $('#modal-tracker-general_information-edit').modal('show');
        $('#modal-tracker-general_information-edit :input').attr('disabled', true);
        loadTrackerGeneralInformation(tracker_id);
        return false;
    });


    // tracker: general information edit - save data
    $(document).on('click', '#modal-tracker-general_information-edit-confirm', function() {
        $('#modal-tracker-general_information-edit').find('div.error-message').remove();
        $('#modal-tracker-general_information-edit-spinner').show();
        saveTrackerGeneralInformation(tracker_id);
        return false;
    });



    // tracker: opening information edit - modal call
    $(document).on('click', '.tracker-opening-edit', function() {
        $('#modal-tracker-opening_information-edit-spinner').show();
        $('#modal-tracker-opening_information-edit').modal('show');
        $('#modal-tracker-opening_information-edit :input').attr('disabled', true);
        loadTrackerOpeningInformation(tracker_id);
        return false;
    });
    
    // tracker: general information edit - save data
    $(document).on('click', '#modal-tracker-opening_information-edit-confirm', function() {
        $('#modal-tracker-opening_information-edit').find('div.error-message').remove();
        $('#modal-tracker-opening_information-edit-spinner').show();
        saveTrackerOpeningInformation(tracker_id);
        return false;
    });


    // tracker: opening information edit - modal call
    $(document).on('click', '.tracker-recipient-edit', function() {
        
        $('#modal-tracker-recipient-edit').modal('show');
        $('#modal-tracker-recipient-edit').on('shown.bs.modal', function (e) {
            $('#modal-tracker-recipient-edit-recipient_search').focus();
        });
        return false;
    });


    // live search for recipient management of the tracker
    var timeout;
    $(document).on('keyup', '#modal-tracker-recipient-edit-recipient_search', function() {
        var search_term = encodeURIComponent($(this).val());
        window.clearTimeout(timeout);
        timeout = window.setTimeout(function() {
            $('#mark-tracker-recipient-edit-spinner').show();
            loadSearchResults(search_term); 
        }, 300);
    });


    // recipient mngmt: selecting a new recipient
    $(document).on('click', '.recipient-search-result-btn', function() {
        $('#mark-tracker-recipient-edit-spinner').show();
        var recipient_id = $(this).attr('id').split('-').pop();
        setTrackerRecipient(tracker_id, recipient_id);
        return false;
    });

});


function setTrackerRecipient(tracker_id, recipient_id) {

    $.ajax({
        url: '/trackers/setTrackerRecipient',
        dataType: 'json',
        data: {
            tracker_id: encodeURIComponent(tracker_id),
            recipient_id: encodeURIComponent(recipient_id)
        },
        success: function(result) {
            $('#mark-tracker-recipient-edit-spinner').hide();
            $('#modal-tracker-recipient-edit').modal('hide');
            updateWrapperTrackerRecipient(tracker_id);
            return false;
        }
    });

    return;
}


function updateWrapperTrackerRecipient(tracker_id) {
    
    $('#wrapper-tracker-recipient').fadeTo('fast', 0, function() {
        $('#wrapper-tracker-recipient').load('/trackers/updateWrapperTrackerRecipient/'+tracker_id, function() {
            $('#wrapper-tracker-recipient').fadeTo('fast', 1, function() {
                
                var block = $('#container-tracker-recipient');
                var color = $.Color(block.css('backgroundColor'));
                block.animate({backgroundColor: "red"}, 300, function() {
                    block.animate({backgroundColor: color}, 300);
                });

                return false;
            });
            return false;
        });
        return false;
    });
    return;
} 



function loadSearchResults(search_term) {

    $('#modal-wrapper-recipient-search-results').fadeTo('fast', 0, function() {
        $('#modal-wrapper-recipient-search-results').load('/trackers/loadSearchResults/'+search_term, function() {
            $('#modal-wrapper-recipient-search-results').fadeTo('fast', 1, function() {
                $('#mark-tracker-recipient-edit-spinner').hide();
                return false;
            });
            return false;
        });
        return false;
    });

    return;
}



function saveTrackerOpeningInformation(tracker_id) {


    $.ajax({
        url: '/trackers/saveTrackerOpeningInformation',
        dataType: 'json',
        data: {
            tracker_id: encodeURIComponent(tracker_id),
            status: encodeURIComponent($('#modal-tracker-opening_information-edit-status').val()),
            open_count: encodeURIComponent($('#modal-tracker-opening_information-edit-open_count').val()),
            created: encodeURIComponent($('#modal-tracker-opening_information-edit-created').val()),
            first_openend: encodeURIComponent($('#modal-tracker-opening_information-edit-first_openend').val()),
            user_agent: encodeURIComponent($('#modal-tracker-opening_information-edit-user_agent').val()),
            ip: encodeURIComponent($('#modal-tracker-opening_information-edit-ip').val()),
        },
        success: function(result) {

            $('#modal-tracker-opening_information-edit-spinner').hide();

            if(typeof result =='object') {
                $.each(result, function(field, message) {
                    
                    var error_message = $('<div class="error-message">' + message + '</div>').hide();
                    $('#modal-tracker-opening_information-edit-'+field).after(error_message);
                    error_message.fadeIn('fast', function() {
                        return false;
                    });
                });

                $('#modal-tracker-opening_information-edit').animate({
                    scrollTop: $("div.error-message:first").offset().top - 100
                }, 550);
            } else {
                $('#modal-tracker-opening_information-edit').modal('hide');
                updateWrapperTrackerOpeningInformation(tracker_id);
            }

            return false;
        }
    });

    return;
}




function saveTrackerGeneralInformation(tracker_id) {

    // console.log(tracker_id);
    // return false;

    $.ajax({
        url: '/trackers/saveTrackerGeneralInformation',
        dataType: 'json',
        data: {
            tracker_id: encodeURIComponent(tracker_id),
            type: encodeURIComponent($('#modal-tracker-general_information-edit-type').val()),
            recipient_email: encodeURIComponent($('#modal-tracker-general_information-edit-recipient_email').val()),
            email_id: encodeURIComponent($('#modal-tracker-general_information-edit-email_id').val()),
            campaign_id: encodeURIComponent($('#modal-tracker-general_information-edit-campaign_id').val()),
            sender_email: encodeURIComponent($('#modal-tracker-general_information-edit-sender_email').val()),
        },
        success: function(result) {

            $('#modal-tracker-general_information-edit-spinner').hide();

            if(typeof result =='object') {
                $.each(result, function(field, message) {
                    
                    var error_message = $('<div class="error-message">' + message + '</div>').hide();
                    $('#modal-tracker-general_information-edit-'+field).after(error_message);
                    error_message.fadeIn('fast', function() {
                        return false;
                    });
                });

                $('#modal-tracker-general_information-edit').animate({
                    scrollTop: $("div.error-message:first").offset().top - 100
                }, 550);
            } else {
                $('#modal-tracker-general_information-edit').modal('hide');
                updateWrapperTrackerGeneralInformation(tracker_id);
            }

            return false;
        }
    });

    return;
}



function saveTrackersLinkDetails(trackers_link_id) {

    $.ajax({
        url: '/trackers/saveTrackersLinkDetails',
        dataType: 'json',
        data: {
            trackers_link_id: encodeURIComponent(trackers_link_id),
            tracker_id: encodeURIComponent($('#modal-trackers_link-edit-tracker_id').val()),
            email_id: encodeURIComponent($('#modal-trackers_link-edit-email_id').val()),
            link_id: encodeURIComponent($('#modal-trackers_link-edit-link_id').val()),
            tracker_string: encodeURIComponent($('#modal-trackers_link-edit-tracker_string').val()),
            url: encodeURIComponent($('#modal-trackers_link-edit-url').val()),
            status: encodeURIComponent($('#modal-trackers_link-edit-status').val()),
            first_visit: encodeURIComponent($('#modal-trackers_link-edit-first_visit').val()),
            last_visit: encodeURIComponent($('#modal-trackers_link-edit-last_visit').val()),
            visit_count: encodeURIComponent($('#modal-trackers_link-edit-visit_count').val()),
            ip: encodeURIComponent($('#modal-trackers_link-edit-ip').val()),
            user_agent: encodeURIComponent($('#modal-trackers_link-edit-user_agent').val()),
            lang: encodeURIComponent($('#modal-trackers_link-edit-lang').val()),
            created: encodeURIComponent($('#modal-trackers_link-edit-created').val()),
            modified: encodeURIComponent($('#modal-trackers_link-edit-modified').val())
        },
        success: function(result) {

            $('#modal-trackers_link-edit-spinner').hide();

            if(typeof result =='object') {
            	$.each(result, function(field, message) {
            		var error_message = $('<div class="error-message">' + message + '</div>').hide();
            		$('#modal-trackers_link-edit-'+field).after(error_message);
            		error_message.fadeIn('fast', function() {
            			return false;
            		});
        		});

			   	$('#modal-trackers_link-edit').animate({
			        scrollTop: $("div.error-message:first").offset().top - 100
			    }, 550);
            } else {
                $('#modal-trackers_link-edit').modal('hide');
                updateWrapperTrackingLinksRow(trackers_link_id);
            }

            return false;
        }
    });

    return;
}



function loadTrackersLinkDetailsForEdit(trackers_link_id) {

    $.ajax({
        url: '/trackers/loadTrackersLinkDetailsForEdit',
        dataType: 'json',
        data: {
            'trackers_link_id': trackers_link_id
        },
        success: function(result) {

            $('#modal-trackers_link-edit-spinner').hide();
            $('#modal-trackers_link-edit :input').attr('disabled', false);

            if(typeof result =='object') {
                $('#modal-trackers_link-edit-tracker_id').val(result.TrackersLink.tracker_id);
                $('#modal-trackers_link-edit-email_id').val(result.TrackersLink.email_id);
                $('#modal-trackers_link-edit-link_id').val(result.TrackersLink.link_id);
                $('#modal-trackers_link-edit-tracker_string').val(result.TrackersLink.tracker_string);
                $('#modal-trackers_link-edit-url').val(result.TrackersLink.url);
                $('#modal-trackers_link-edit-status').val(result.TrackersLink.status);
                $('#modal-trackers_link-edit-first_visit').val(result.TrackersLink.first_visit);
                $('#modal-trackers_link-edit-last_visit').val(result.TrackersLink.last_visit);
                $('#modal-trackers_link-edit-visit_count').val(result.TrackersLink.visit_count);
                $('#modal-trackers_link-edit-ip').val(result.TrackersLink.ip);
                $('#modal-trackers_link-edit-user_agent').val(result.TrackersLink.user_agent);
                $('#modal-trackers_link-edit-lang').val(result.TrackersLink.lang);
                $('#modal-trackers_link-edit-created').val(result.TrackersLink.created);
                $('#modal-trackers_link-edit-modified').val(result.TrackersLink.modified);
            }

            return false;
        }
    });

    return;
}


function loadTrackersLinkDetails(trackers_link_id) {

    $('#modal-wrapper-trackers_link-details').fadeTo('fast', 0, function() {
        $('#modal-wrapper-trackers_link-details').load('/trackers/loadTrackersLinkDetails/'+trackers_link_id, function() {
            $('#modal-wrapper-trackers_link-details').fadeTo('fast', 1, function() {
                return false;
            });
            return false;
        });
        return false;
    });
    return;
}



function loadTrackerGeneralInformation(tracker_id) {

    $.ajax({
        url: '/trackers/loadTrackerGeneralInformation',
        dataType: 'json',
        data: {
            'tracker_id': tracker_id
        },
        method: 'POST',
        success: function(result) {

            $('#modal-tracker-general_information-spinner').hide();
            $('#modal-tracker-general_information-edit :input').attr('disabled', false);

            if(typeof result =='object') {
                $('#modal-tracker-general_information-edit-type').val(result.Tracker.type);
                $('#modal-tracker-general_information-edit-recipient_email').val(result.Tracker.recipient_email);
                $('#modal-tracker-general_information-edit-email_id').val(result.Tracker.email_id);
                $('#modal-tracker-general_information-edit-campaign_id').val(result.Tracker.campaign_id);
                $('#modal-tracker-general_information-edit-sender_email').val(result.Tracker.sender_email);
            }
            return false;
        }
    });
    return;
}


function updateWrapperTrackerGeneralInformation(tracker_id) {
    $('#wrapper-tracker-general-information').fadeTo('fast', 0, function() {
        $('#wrapper-tracker-general-information').load('/trackers/updateWrapperTrackerGeneralInformation/'+tracker_id, function() {
            $('#wrapper-tracker-general-information').fadeTo('fast', 1, function() {
                
                var block = $('#container-tracker-general-information');
                var color = $.Color(block.css('backgroundColor'));
                block.animate({backgroundColor: "red"}, 300, function() {
                    block.animate({backgroundColor: color}, 300);
                });

                return false;
            });
            return false;
        });
        return false;
    });
    return;
} 


function updateWrapperTrackerOpeningInformation(tracker_id) {
    $('#wrapper-tracker-opening-information').fadeTo('fast', 0, function() {
        $('#wrapper-tracker-opening-information').load('/trackers/updateWrapperTrackerOpeningInformation/'+tracker_id, function() {
            $('#wrapper-tracker-opening-information').fadeTo('fast', 1, function() {
                
                var block = $('#container-tracker-opening-information');
                var color = $.Color(block.css('backgroundColor'));
                block.animate({backgroundColor: "red"}, 300, function() {
                    block.animate({backgroundColor: color}, 300);
                });

                return false;
            });
            return false;
        });
        return false;
    });
    return;
} 


function loadTrackerOpeningInformation(tracker_id) {

    $.ajax({
        url: '/trackers/loadTrackerOpeningInformation',
        dataType: 'json',
        data: {
            'tracker_id': tracker_id
        },
        method: 'POST',
        success: function(result) {

            $('#modal-tracker-opening_information-edit-spinner').hide();
            $('#modal-tracker-opening_information-edit :input').attr('disabled', false);

            if(typeof result =='object') {
                $('#modal-tracker-opening_information-edit-status').val(result.Tracker.status);
                $('#modal-tracker-opening_information-edit-open_count').val(result.Tracker.open_count);
                $('#modal-tracker-opening_information-edit-created').val(result.Tracker.created);
                $('#modal-tracker-opening_information-edit-first_openend').val(result.Tracker.first_openend);
                $('#modal-tracker-opening_information-edit-user_agent').val(result.Tracker.user_agent);
                $('#modal-tracker-opening_information-edit-ip').val(result.Tracker.ip);
            }
            return false;
        }
    });
    return;
}




function updateWrapperTrackingLinks(tracker_id) {
    $('#wrapper-tracking_links').fadeTo('fast', 0, function() {
        $('#wrapper-tracking_links').load('/trackers/updateWrapperTrackingLinks/'+tracker_id, function() {
            $('#wrapper-tracking_links').fadeTo('fast', 1, function() {
                return false;
            });
            return false;
        });
        return false;
    });
    return;
} 


function updateWrapperTrackingLinksRow(trackers_link_id) {
    
    $('#wrapper-tracking_links-row-'+trackers_link_id).fadeTo('fast', 0, function() {
        $('#wrapper-tracking_links-row-'+trackers_link_id).load('/trackers/updateWrapperTrackingLinksRow/'+trackers_link_id, function() {
            $('#wrapper-tracking_links-row-'+trackers_link_id).fadeTo('fast', 1, function() {
                
                var block = $('#wrapper-tracking_links-row-'+trackers_link_id);
                var color = $.Color(block.css('backgroundColor'));
                block.animate({backgroundColor: "red"}, 300, function() {
                    block.animate({backgroundColor: color}, 300);
                });

                return false;
            });
            return false;
        });
        return false;
    });
    return;
} 

