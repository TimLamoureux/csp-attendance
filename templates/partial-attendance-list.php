<?php


?>

<div>
	<h1><?php _e('Attendance Table', CA_TEXTDOMAIN); ?></h1>
</div>
<div id="attendance-list">
    <table id="event-attendance">
        <thead>
        <tr><?php _e('Name of the event', CA_TEXTDOMAIN); ?></tr>
        <tr>
            <td><?php _e('Patroller', CA_TEXTDOMAIN); ?></td>
            <td><?php _e('Type', CA_TEXTDOMAIN); ?></td>
            <td><?php _e('In', CA_TEXTDOMAIN); ?></td>
            <td><?php _e('Out', CA_TEXTDOMAIN); ?></td>
            <td><?php _e('Total', CA_TEXTDOMAIN); ?></td>
            <td><?php _e('Notes', CA_TEXTDOMAIN); ?></td>
            <td></td>
        </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
        <tr>
            <td><?php _e('Total number', CA_TEXTDOMAIN); ?></td>
            <td></td>
            <td></td>
            <td><?php _e('Total cumulative time', CA_TEXTDOMAIN); ?></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</div>