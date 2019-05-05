<?php
/**
 * Creates a form for report generation
 * TODO: Implement access right validation before showing the form
 */
?>

<?php
// TODO: Check if already enqueued...
wp_enqueue_script( CA_TEXTDOMAIN . '-flatpickr', plugins_url('assets/lib/flatpickr/flatpickr.min.js', CA_PLUGIN_ABSOLUTE ), null, false, true );
// TODO: Minify use grunt to minify and uglify, serve that version.
wp_enqueue_script( CA_TEXTDOMAIN . '-report-patroller', plugins_url('assets/js/ca-report-patroller.js', CA_PLUGIN_ABSOLUTE ), null, false, true );
wp_enqueue_style( CA_TEXTDOMAIN . '-flatpickr', plugins_url('assets/lib/flatpickr/flatpickr.min.css', CA_PLUGIN_ABSOLUTE ), null, false );


?>

	<div id="">
		<h2><?php _e('Report options', CA_TEXTDOMAIN); ?></h2>
		<form id="ca-report-generate-form" method="post" action="">
			<input id="ca-report-date-start" placeholder="<?php _e('Start date', CA_TEXTDOMAIN); ?>"/>
			<input id="ca-report-date-end" placeholder="<?php _e('End date', CA_TEXTDOMAIN); ?>"/>

<!--			<input value="User List - Implement me!"/>-->


			<!-- Event categories -->
			<?php if ( class_exists( 'EM_Categories' ) ):
				$event_categories = EM_Categories::get();
				if ( 0 < count( $event_categories ) ) :
					?>
					<label for="ca-report-event-category"><?php _e("Event category", CA_TEXTDOMAIN); ?></label>
					<select id="ca-report-event-category">
						<option value="" selected><?php _e('Event Category', CA_TEXTDOMAIN);; ?></option>
						<?php foreach ($event_categories as $category) : ?>
							<option value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
						<?php endforeach; ?>
					</select>
				<?php endif; ?>
			<?php endif; ?>

			<!-- Type of patroller -->
			<label for="ca-report-attendance-type"><?php _e("Type of patrolling", CA_TEXTDOMAIN); ?></label>
			<select id="ca-report-attendance-type">
				<option value="" selected><?php _e('All attendance types', CA_TEXTDOMAIN); ?></option>
				<option value="volunteer"><?php _e('Volunteer patrol', CA_TEXTDOMAIN); ?></option>
				<option value="junior"><?php _e('Junior patrol', CA_TEXTDOMAIN); ?></option>
				<option value="pro"><?php _e('Pro patrol', CA_TEXTDOMAIN); ?></option>
			</select>


			<!-- Teams -->
<!--			This will show Events attached to this group, not attendance of a patroller belonging to a group-->
<!--			--><?php //if ( bp_has_groups() ) : ?>
<!--				<select id="ca-report-bp-group">-->
<!--					<option class="report-group" value="" selected>--><?php //_e( 'Events from this team', CA_TEXTDOMAIN ); ?><!--</option>-->
<!--					--><?php //while ( bp_groups() ) : bp_the_group(); ?>
<!--						<option class="report-group" value="--><?php //bp_group_id() ?><!--">-->
<!--							--><?php //bp_group_name(); ?>
<!--						</option>-->
<!---->
<!--					--><?php //endwhile; ?>
<!--				</select>-->
<!--			--><?php //endif; ?>

			<!-- List of events -->
<!--			<p>Event list</p>-->


			<input id="ca-report-time-after-start" type="number" value="20" placeholder="<?php _e('Time after start for full day', CA_TEXTDOMAIN); ?>" />
			<input id="ca-report-time-before-end" type="number" value="30" placeholder="<?php _e('Time before end for full day', CA_TEXTDOMAIN); ?>" />


<!--			Show bookings-->
<!--			Show complete shifts-->

			<?php wp_nonce_field( 'generate_attendance_report', 'attendance_report_nonce' );  ?>

			<button id="ca-report-generate-submit" class="btn btn-default" type="submit"><?php _e( 'Generate Report', CA_TEXTDOMAIN ); ?></button>
		</form>

	</div>

	<!-- TODO: Move me to separate file -->
	<div id="ca-report">
        <div id="ca-report-meta">
            <div><?php _e( 'Report generated on ', CA_TEXTDOMAIN ); ?> <span id="ca-report-date"></span></div>
            <pre id="error-container"></pre>
        </div>
		<div id="ca-report-users"></div>
		<div id="ca-report-events"></div>


	</div>

<?php
wpbp_get_template_part( CA_TEXTDOMAIN, 'partial', 'report-patroller', true );;
?>