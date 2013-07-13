<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package photo-addict
 * @since photo-addict 1.0
 */
?>

	<h1 class="entry-title"><?php _e( 'Nothing Found', 'photo-addict' ); ?></h1>

	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

		<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'photo-addict' ), admin_url( 'post-new.php' ) ); ?></p>

	<?php elseif ( is_search() ) : ?>

		<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'photo-addict' ); ?></p>
		<?php get_search_form(); ?>

	<?php else : ?>

		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'photo-addict' ); ?></p>
		<?php get_search_form(); ?>

	<?php endif; ?>
