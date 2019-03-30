<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>


<div><?php wpbp_get_template_part( CA_TEXTDOMAIN, 'partial', 'attendance-add', true ); ?></div>
<div><?php wpbp_get_template_part( CA_TEXTDOMAIN, 'partial', 'attendance-list', true ); ?></div>
