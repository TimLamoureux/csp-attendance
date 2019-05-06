<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>

<?php
    /*
     * Should use include instead of get_template_part. Using template part will return Content if not found.
     */
?>
<div><?php wpbp_get_template_part( CA_TEXTDOMAIN, 'partial', 'attendance-add', true ); ?></div>
<div><?php wpbp_get_template_part( CA_TEXTDOMAIN, 'partial', 'attendance-list', true ); ?></div>
