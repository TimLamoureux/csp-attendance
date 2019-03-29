<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
    <div class="inside-article">
        <header class="entry-header">
            <?php
            the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
            ?>
        </header>

        <div class="entry-content" itemprop="text">
            <?php if ( ! current_user_can( 'pods_add_wcm-attendance' ) ): ?>
                <div>You are not authorized to manage attendances</div>
                <?php die(); ?>
            <?php endif; ?>

            <?php the_content(); ?>

            <div>
                <?php
                /* TODO: Organize to be able to use public/partials instead of templates folder.
                 *   Requires a function which will fetch partial in the theme folder and plugin folder
                 */
                ?>
                <div><?php wpbp_get_template_part( CA_TEXTDOMAIN, 'partial', 'attendance-add', true ); ?></div>
                <div><?php wpbp_get_template_part( CA_TEXTDOMAIN, 'partial', 'attendance-list', true ); ?></div>
            </div>

            <?php
            //do_action( 'output_attendance_manager' );

            wp_link_pages( array(
                'before' => '<div class="page-links">' . __( 'Pages:', CA_TEXTDOMAIN ),
                'after' => '</div>',
            ) );
            ?>
        </div>
    </div>
</article>


<?php
$users = "";
?>