// TODO: Move me to separate script
(function ($) {
    $(function () {

        $('#ca-report-generate-form').submit(function (e) {
            e.preventDefault();

            // Clear the error container
            $('#error-container').html();

            var eventTarget = e.target;

            var errors = new Array();

            // TODO: Perform presubmit validation
            var dateStart = document.querySelector("#ca-report-date-start")._flatpickr.selectedDates;
            if ( dateStart == null || dateStart.length == 0 ) {
                errors.push('You must provide a valid start date');
            }

            var dateEnd = document.querySelector("#ca-report-date-end")._flatpickr.selectedDates;
            if ( dateEnd == null || dateEnd.length == 0 ) {
                errors.push('You must provide a valid end date');
            }

            if (0 < errors.length) {
                alert(errors);
                return;
            }

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/wp-admin/admin-ajax.php',
                data: {
                    'action': 'generate_attendance_report',
                    'date-start': dateStart,
                    'date-end': dateEnd,
                    'event_id': '',
                    'group_id': $(this).find('#ca-report-bp-group').val(),
                    'category': $(this).find('#ca-report-event-category').val(),
                    'type': $(this).find('#ca-report-attendance-type').val(),
                    'user_id': '',
                    'bookings': '',
                    'compare_event_length': false,
                    'time_after_start': $(this).find('#ca-report-time-after-start').val(),
                    'time_before_end': $(this).find('#ca-report-time-before-end').val(),
                    'submitted': true,
                    'attendance-form-nonce': $(this).find('#attendance_report_nonce').val(),
                },
                beforeSend: function (jqXHR, settings) {
                    var submit = $('#ca-report-generate-submit');
                    submit.attr('data-old-value', submit.html()).html(function (self) {
                        return '<img src="//' + window.location.host + '/wp-includes/images/spinner-2x.gif' + '" />';
                    });
                },
                success: function (responseText, statusText, xhr) {
                    var submit = $('#ca-report-generate-submit');
                    submit.html(submit.attr('data-old-value'));

                    $('#post_nonce_field').val(responseText.nonce);

                    var json = JSON.parse(responseText.data);

                    displayReportDate(json.date_generated);

                    // Convert json.patrollers back into object to allow passing as parameter in triggering the event
                    /*var out = {};
                     json.patrollers = json.patrollers.reduce(function(o, val) {
                     o[val.id] = val;
                     return o;
                     }, out);*/
                    // TODO: Sort by patroller name
                    $(document).trigger('userReportGenerated',json.patrollers);

                    // $('#error-container').html(
                    //     JSON.stringify(json, null, 2)
                    // );
                    window.deleteme = json;
                    //updateAttendanceTable($('#event-attendance tbody'), responseText, false );

                },
                error: function (error) {
                    var submit = $('#ca-report-generate-submit');
                    submit.html(submit.attr('data-old-value'));

                    $('#error-container').html(error.statusText);
                    alert('Error: ' + error.statusText);
                }
            });
        });



        function displayReportDate( dateGenerated ) {
            $('#ca-report-date').html(dateGenerated)
        }





        if (typeof flatpickr == 'undefined')
            return;

        var today = new Date();

        var fp_base_args = {
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d',
            allowInput: true,
            time_24hr: true,
            enableTime: false,
            maxDate: today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate()
        };

        var dateStart = flatpickr('input#ca-report-date-start', fp_base_args);
        if (dateStart) {
            dateStart.setDate(new Date('2017-12-01'), true);
        }

        var dateEnd = flatpickr('input#ca-report-date-end', fp_base_args);
        //TODO: This is a hack, better verification of which page should be used or move this to page script
        if (dateEnd) {
            dateEnd.setDate(new Date('2017-12-16'), true);
        }


        $(document).on('userReportGenerated', function (e, userReports) {
            // TODO: Find a way to pass the ca-report-users container in displayUserReport
            $('#ca-report-users').html("");

            $.each(userReports, displayUserReport);
        });

        $('#ca-report').on('userReportProcessed', '.ca-report-user', function (event, user) {
            outputBarChart(user, $(this).find('.ca-chart-container').get(0));
            //outputAttendanceTypesChart(user, $(this).find('.ca-report-user-type').get(0));
            //outputDowChart(user, $(this).find('.ca-report-dow').get(0));
            outputEventsTable(user, $(this).find('.ca-report-user-events-table').get(0))

            /*
             var pieChart = {
             '.ca-report-user-bookings': {
             title: 'Bookings',
             unit: 'Number',
             data: [
             {
             name: 'Booked',
             value: user.booked
             },
             {
             name: 'Not booked',
             value: user.total_events - user.booked
             }
             ]
             },
             '.ca-report-user-fullday': {
             title: 'Full days',
             unit: 'Number',
             data: [
             {
             name: 'Full',
             value: user.full_day
             },
             {
             name: 'Partial',
             value: user.total_events - user.full_day
             }
             ]
             }
             };

             $.each(pieChart, function(index, pie) {
             var chartData = [[pie.title, pie.unit]];
             for (var i=0; i < pie.data.length; i++) {
             chartData.push([pie.data[i].name, pie.data[i].value]);
             }

             var data = google.visualization.arrayToDataTable(chartData);
             var options = {
             title: pie.title,
             titleTextStyle: {
             color: 'black',
             bold: true,
             fontSize: 16
             },
             pieSliceText: 'label',
             legend: 'none',
             chartArea:{
             width:'75%',
             height:'75%'
             }
             };

             var chartContainer = $(user_container).children(index).css({
             float: 'left',
             border: 'solid 1px blue',
             width:'250px',
             height:'250px'
             }).get(0);
             if ( 'undefined' != chartContainer ) {
             var chart = new google.visualization.PieChart(chartContainer);
             chart.draw(data, options);
             }

             }, user_container);
             */
        });
    });

    function outputBarChart(user, where) {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Stat');
        data.addColumn('number', 'Number');
        data.addColumn({type:'string', role:'annotation'});
        data.addColumn({type:'string', role:'style'});

        data.addRows([
            ['Patrolled days', user.total_events, String(user.total_events), 'color:blue'],
            ['Full day', user.full_day, ( user.total_events > 0 ?  user.full_day + ' (' + Math.round((parseInt(user.full_day)/parseInt(user.total_events))*100) + '%)' : '0' ), 'color:green'],
            ['Booked', user.booked, ( user.total_events > 0 ? user.booked + ' (' + Math.round((parseInt(user.booked)/parseInt(user.total_events))*100) + '%)' : '0' ), 'color:orange'],
            ['No show', user.noshowCount, String(user.noshowCount), 'color:red']
        ]);
        var view = new google.visualization.DataView(data);
        var options = {
            title: 'Attendance statistics for ' + user.name,
            /*width: '100%',*/
            legend: { position: 'none' },
            bars: 'horizontal', // Required for Material Bar Charts.
            /*axes: {
                x: {
                    0: { side: 'top', label: 'Percentage'} // Top x-axis.
                }
            },*/
            bar: { groupWidth: "90%" },
            annotations: {
                alwaysOutside: false
            }
        };

        if ('undefined' != where) {
            new google.visualization.BarChart(where).draw(view, options);
        }
    }

    function outputEventsTable(user, where) {

        if ( typeof user.events == 'undefined' ) {
            $(where).html("No events to display");
            return;
        }

        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('timeofday', 'Start');
        data.addColumn('timeofday', 'End');
        data.addColumn('string', 'Type');
        data.addColumn('boolean', 'Full day');
        data.addColumn('boolean', 'Booked');
        data.addColumn('string', 'Notes');

        for (var i in user.events ) {
            user.events[i];
            var start = new Date(user.events[i].start),
            end = new Date(user.events[i].end);
            data.addRow( [
                start,
                [start.getHours(), start.getMinutes(), start.getSeconds()],
                [end.getHours(), end.getMinutes(), end.getSeconds()],
                (typeof user.events[i].type != 'undefined' ? user.events[i].type : 'N/A'),
                user.events[i].full_day,
                user.events[i].booked,
                (typeof user.events[i].notes != 'undefined' ? user.events[i].notes : '')
            ] );
        }

        // set the width of columns of DataTable data
        for (var i = 0; i < data.getNumberOfRows(); i++) {
            // Row number
            //data.setProperty(i, 0, 'className', 'event-table-cell-xsmall');

            // Date and times
            data.setProperty(i, 0, 'className', 'event-table-cell-small');
            data.setProperty(i, 1, 'className', 'event-table-cell-small');
            data.setProperty(i, 2, 'className', 'event-table-cell-small');

            // Attendance type
            data.setProperty(i, 3, 'className', 'event-table-cell-small');

            // Full day
            data.setProperty(i, 4, 'className', 'event-table-cell-xsmall');

            // Booked
            data.setProperty(i, 5, 'className', 'event-table-cell-xsmall');

        }

        var options = {
            sortColumn: 0,
            showRowNumber: true,
            allowHtml: true,
            width: '100%',
            cssClassNames: {tableCell: 'event-table-cell'}
        };

        if ('undefined' != where) {
            var table = new google.visualization.Table(where);
            table.draw(data, options);
        }
    }

    /**
     * Handle all the displaying of report
     * TODO: Get template from file and replace elements
     */
    function displayUserReport(userId) {
        //var this is a user

        // TODO: Find a way to get this container from the trigger function
        var userReportContainer = $('#ca-report-users');

        var tmpl = $($("#ca-report-users-template").html().trim()).attr('data-user-id', userId);

        Object.assign(this, {
            type: [],
            booked: 0,
            full_day: 0,
            total_minutes: 0,
            total_events: 0,
            noshowCount: ( typeof this.no_show != 'undefined' ? this.no_show.length : 0 )
        });

        for (var event_id in this.events) {
            var event = this.events[event_id];
            ( event.booked ? this.booked++ : "" );
            ( event.full_day ? this.full_day++ : "" );
            this.type[event.type]++;
            this.total_minutes += (new Date(event.end) - new Date(event.start)) / 60000;
            this.total_events++;
        }

        tmpl.find('.ca-report-user-name').html(this.name);
        tmpl.find('.ca-report-user-team').html(this.team);
        tmpl.find('.ca-report-user-type').html(this.type);
        // tmpl.find('.ca-report-user-my-team').html('Team days');
        // tmpl.find('.ca-report-user-all-team').html('Ratio of events attended for each team');

        tmpl.appendTo(userReportContainer);

        tmpl.trigger('userReportProcessed', this);
        //userReportContainer.append(tmpl);

    }

    /**
     * UI scripts
     */
    $('#ca-report').on('click', '.event-list-title', function() {
        $(this).siblings('.ca-report-user-events-table').slideToggle('slow');
        $(this).find('.fas').toggleClass('fa-angle-up').toggleClass('fa-angle-down');
    });
})(jQuery);