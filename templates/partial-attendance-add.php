<div>
	<h1><?php _e('Add a new attendance', CA_TEXTDOMAIN); ?></h1>
</div>
<div id="attendance-form-container">
    <div class="error-container"></div>
    <form action="" id="attendance-form" method="POST" autocomplete="off">
        <fieldset>
            <label for="event"><?php _e( 'Event:', CA_TEXTDOMAIN ) ?></label>
            <select name="event" id="event" class="required">
                <option><?php _e('Please select an event', CA_TEXTDOMAIN); ?></option>
				<?php foreach ( Ca_Attendance::get_events() as $event ): ?>
                    <option
                            value="<?php echo $event->event_id; ?>"
                            data-start-datetime="<?php echo date( 'Y-m-d H:i', strtotime( $event->event_start_date . " " . $event->event_start_time ) ); ?>"
                            data-end-datetime="<?php echo date( 'Y-m-d H:i', strtotime( $event->event_end_date . " " . $event->event_end_time ) ); ?>"
                    ><?php echo $event->event_start_date . " " . $event->event_name; ?></option>
				<?php endforeach; ?>
            </select>
        </fieldset>

        <fieldset>
            <label for="patroller"><?php _e( 'Patroller:', CA_TEXTDOMAIN ) ?></label>

            <input type="text" name="patroller" id="patroller" class="required" />
            <input type="hidden" name="patroller-id" id="patroller-id" class="required" />
        </fieldset>

        <fieldset>
            <label for="type"><?php _e( 'Type:', CA_TEXTDOMAIN ) ?></label>

			<?php
			$pods = pods( 'wcm-attendance' );
			echo $pods->form( array(
				'fields_only' => true,
				'fields' => array(
					'type'
				)
			) );
			?>
        </fieldset>

        <fieldset>
            <label for="time-start"><?php _e( 'Start time:', CA_TEXTDOMAIN ) ?></label>

            <input name="time-start" id="time-start" rows="8" cols="30"
                   class="required flatpickr-time"></input>
        </fieldset>

        <fieldset>
            <label for="time-end"><?php _e( 'End time:', CA_TEXTDOMAIN ) ?></label>

            <input name="time-end" id="time-end" rows="8" cols="30"
                   class="required flatpickr-time"></input>
        </fieldset>

        <fieldset>
            <label for="notes"><?php _e( 'Notes:', CA_TEXTDOMAIN ) ?></label>

            <textarea name="notes" id="notes" rows="8" cols="30" class="required"></textarea>
        </fieldset>

        <!-- 	<input type="hidden" name="event-start-date" id="event-start-date" value="" />
		<input type="hidden" name="event-end-date" id="event-end-date" value="" /> -->
        <input type="hidden" name="submitted" id="submitted" value="true"/>

		<?php wp_nonce_field( 'attendance-form', 'attendance-form-nonce' ); ?>
        <button id="attendance-submit" class="btn btn-default"
                type="submit"><?php _e( 'Add Attendance', CA_TEXTDOMAIN ) ?></button>

    </form>

</div>