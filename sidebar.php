<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package photo-addict
 * @since photo-addict 1.0
 */
?>
	<div class="widget-area" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- #secondary .widget-area -->
