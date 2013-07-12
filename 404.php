<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package designsimply
 * @since designsimply 1.0
 */

get_header(); ?>
<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package designsimply
 * @since designsimply 1.0
 */
get_header();
designsimply_tonesque_css(); ?>

		<h2><?php _e( 'Sad bunny! That page can&rsquo;t be found.', 'designsimply' ); ?></h2>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="the-content">

					<?php
						get_search_form();
						the_widget( 'WP_Widget_Tag_Cloud', 'title= ' );
						//the_widget( 'WP_Widget_Recent_Posts' );
						//the_widget( 'WP_Widget_Archives' ); /* translators: %1$s: smilie */
					?>

					<?php //wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'designsimply' ), 'after' => '</div>' ) ); ?>
				</div><!-- .the-content -->

			<div class="site-title">
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="post-parent" rel="home"><?php bloginfo( 'name' ); ?></a>
			</div>

		</article><!-- #post-<?php the_ID(); ?> -->

<?php get_footer(); ?>
