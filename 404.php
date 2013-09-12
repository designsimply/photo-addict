<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package photo-addict
 * @since photo-addict 1.0
 */
get_header();
echo photo_addict_tonesque_css(); ?>

		<h2><?php _e( 'Sad bunny! That page can&rsquo;t be found.', 'photo-addict' ); ?></h2>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="the-content">

					<?php
						get_search_form();
						the_widget( 'WP_Widget_Tag_Cloud', 'title= ' );
						//the_widget( 'WP_Widget_Recent_Posts' );
						//the_widget( 'WP_Widget_Archives' ); /* translators: %1$s: smilie */
					?>

					<?php //wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'photo-addict' ), 'after' => '</div>' ) ); ?>
				</div><!-- .the-content -->

			<div class="site-title">
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="post-parent" rel="home"><?php bloginfo( 'name' ); ?></a>
			</div>

		</article><!-- #post-<?php the_ID(); ?> -->

<?php get_footer(); ?>
