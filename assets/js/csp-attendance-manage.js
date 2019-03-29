// TODO: Remove  me, used to debug flatpickr
const fp = [];

Date.prototype.substractHours = function(h) {
    this.setHours(this.getHours()-h);
    return this;
};

Date.prototype.addHours = function(h) {
    this.setHours(this.getHours()+h);
    return this;
};

Date.timediff = function ( date1, date2 ) {

    if ( !(date1 instanceof Date) ) {
        date1 = new Date(date1);
    }

    if ( !(date2 instanceof Date) ) {
        date2 = new Date(date2);
    }

    let diff = Math.abs(date2 - date1);

    let dms = 86400000,
        hms = 3600000,
        mms = 60000,
        sms = 1000;

    let d = Math.floor( diff / dms );
    diff = diff % dms;
    let h = Math.floor( diff / hms );
    diff = diff % hms;
    let m = Math.floor( diff / mms );
    diff = diff % mms;
    let s = Math.floor( diff / sms );

    let out = "";

    if ( d !== 0 )
        out += d + ( d > 1 ? ' days ' : ' day ' );
    if ( h !== 0 )
        out += h + ( h > 1 ? ' hours ' : ' hour ' );
    if ( m !== 0 )
        out += m + " min ";
    if ( s !== 0 )
        out += s +  " sec";

    return out;
};

(function( $ ) {
	'use strict';

    let updateAttendanceTable = function(tbody, content, clear ) {
        if ( tbody === undefined )
            return;

        if ( clear === undefined )
            clear = true;

        if ( clear )
            tbody.html('');

        $.each(content, function (i, item) {

            if ( item.time_in === undefined ||
                item.time_out === undefined ||
                item.patroller === undefined )
                return;

            let time_in = new Date(item.time_in),
                time_out = new Date(item.time_out),
                time_diff = Date.timediff( time_out, time_in );

            let tr = $('<tr>').attr('data-attendance-id', item.id).append(
                $('<td>').text(item.patroller),
                $('<td>').text( ( item.type ? item.type : '' ) ),
                $('<td>').text(time_in.toLocaleTimeString([], {hour12: false, hour: 'numeric', minute:'2-digit'})),
                $('<td>').text(time_out.toLocaleTimeString([], {hour12: false, hour: 'numeric', minute:'2-digit'})),
                $('<td>').text(time_diff),
                $('<td>').text('notes'),
                $('<td>').html( (item.can_delete ? '<a class="delete-attendance" href="javascript:void(0)">X</a>' : '') )
            );
            tbody.append(tr);
        });
    };

    // AJAX event to allow attendance deletion
    $('#event-attendance tbody').click( function(e) {

        if ( ! $(e.target).is('.delete-attendance') )
            return;

        // TODO: Make string translation ready
        if (confirm('Are you sure you want to delete this attendance. This cannot be undone.') === false)
            return;

        let tr = $(e.target).parents('tr[data-attendance-id]');
        let attendance_id = tr.attr('data-attendance-id');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/wp-admin/admin-ajax.php',
            data: {
                'action': 'attendance_delete',
                'attendance_id': attendance_id
            },
            success: function (responseText, statusText, xhr, el) {
                let error_c = $('.error-container');

                let t = $(this);

                if ( responseText.data === undefined ) {
                    console.error('Error parsing deletion result');
                }

                $('tr[data-attendance-id='+responseText.data.id+']').remove();

            },
            error: function (error) {
                let error_c = $('.error-container');
            }


        });
    } );

    // Create instance of flatpickr when class is found
    flatpickr('.flatpickr-time', {
        enableTime: true,
        noCalendar: false,
        dateFormat: "Y-m-d H:i",
        time_24hr: true
    });
    $(".flatpickr-time").each( (element) => {

        /*fp.push(flatpickr(element), {
            enableTime: true,
            noCalendar: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });*/

        /*$(element).flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });*/

        /*$(this).flatpickr({
            enableTime: true,
            noCalendar: false,
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });*/


    });

    //flatpickr(".flatpickr-time", {})

    let cache;
    if ( typeof $.cookie !== 'undefined' && $.cookie('patroller_cache') != undefined && $.cookie('patroller_cache') != '[object Object]' ) {
        cache = JSON.parse($.cookie('patroller_cache'));
    }
    else {
        cache = {};
    }

    $("#patroller").autocomplete({
        minLength: 3,
        source: function (request, response) {
            let term = request.term;

            if (cache[term] != undefined) {
                response(cache[term]);
                return;
            }

            // TODO: Add support for multiple patrollers input at the same time for submission
            // Info on how to use js-cookie: https://github.com/carhartl/jquery-cookie
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/wp-admin/admin-ajax.php',
                data: 'action=get_patrollers&patroller=' + request.term,
                success: function (data) {
                    cache[term] = data;
                    //Cookies.set('patroller_cache', cache);
                    $.cookie('patroller_cache', JSON.stringify(cache), { path: '/'})
                    response(data);
                },
                error: function (data) {
                    alert(data.statusText);
                    let error;

                }
            });
        },
        select: function( event, ui ) {
            event.preventDefault();

            $('#patroller-id').val(ui.item.value)
            $(this).val(ui.item.label);
        }
    });

    $('#attendance-form').submit( function(e) {
        e.preventDefault();

        let error_container = $('.error-container');

        error_container.html = "";

        // TODO: Javascript validation

        /* let required = $(this).find('input.required');

         // Parse input fields and check for empty
         for (let i = 0; i < required.length; i++) {
         let el = required[i];
         if ( el.val() == "" ) {
         error_container.html += el.name + " must not be empty <br />";
         }
         }

         if (error_container.html != "")
         return;*/

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/wp-admin/admin-ajax.php',
            data: {
                'action': 'attendance_form_process',
                'submitted': true,
                'attendance-form-nonce': $(this).find('#attendance-form-nonce').val(),
                'form_data': $( this ).serialize()
            },
            success : function(responseText, statusText, xhr, $form) {
                let error_c = $('.error-container');
                error_c.css("color", "green");
                error_c.html( "Attendance added sucessfully" );

                // TODO: Fix scroll to top of element on success and failure
                $('html, body').animate({
                    scrollTop: error_c.position().top
                }, 500);

                $('#post_nonce_field').val(responseText.nonce);

                updateAttendanceTable($('#event-attendance tbody'), responseText, false );

            },
            error: function (error) {
                let error_c = $('.error-container');
                error_c.css("color", "red");
                error_c.html( error.responseJSON.data );
                // TODO: Fix scroll to top of element on success and failure
                $('html, body').animate({
                    scrollTop: error_c.position().top
                }, 500);
            }
        });

        let halt;
    });

    $('#attendance-form #event').change(function(e) {
        let csp_event = $(this).children('option:selected');
        if ($(csp_event[0] != undefined)){
            csp_event = $(csp_event[0]);

            let flatpickr_start = document.querySelector("#time-start")._flatpickr,
                flatpickr_end = document.querySelector("#time-end")._flatpickr;

            let dateStart = new Date(csp_event.attr('data-start-datetime')).substractHours(2),
                dateEnd = new Date(csp_event.attr('data-end-datetime')).addHours(4);

            flatpickr_start.set('minDate', dateStart);
            flatpickr_start.setDate(csp_event.attr('data-start-datetime'), 'Y-m-d H:i');

            flatpickr_end.set('maxDate', dateEnd);
            /*flatpickr_end.set('disable', {
             from: dateEnd
             });*/

            flatpickr_end.setDate(csp_event.attr('data-end-datetime'), 'Y-m-d H:i');


            // Ajax call to retrieve Attendance for this event
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/wp-admin/admin-ajax.php',
                data: {
                    'action': 'attendance_retrieve',
                    'event_id': csp_event.val()
                    /*'attendance-form-nonce': $(this).find('#attendance-form-nonce').val(),*/
                },
                success : function(responseText, statusText, xhr, $form) {
                    updateAttendanceTable($('#event-attendance tbody'), responseText, true);
                },
                error: function (error) {
                    let error_c = $('.error-container');
                }
            });
        }

    });


	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );
