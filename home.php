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

get_header(); ?>

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

			<div class="second-box">
			<?php if ( have_posts() ) : ?>
				<?php /* Start the first Loop */ 
				while ( have_posts() ) : the_post(); ?>

					<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

				<?php endwhile; ?>

				<?php designsimply_content_nav( 'nav-below' ); ?>
			</div><!-- .first-box -->

<div class="second-box">
<h2>Speaking</h2>
<?php
	$args = array( 'numberposts' => '1', 'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => 'post-format-status',
				'operator' => 'IN'
			)
	) );
	$latest_status_post = wp_get_recent_posts( $args );
	foreach( $latest_status_post as $recent ){
		echo '<a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> ';
	}
?>
</div><!-- .second-box -->

<div class="third-box">
<h2>Photography</h2>
<?php
	$args = array( 'numberposts' => '1', 'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => 'post-format-image','post-format-gallery',
				'operator' => 'IN'
			)
	) );
	$latest_status_post = wp_get_recent_posts( $args );
	foreach( $latest_status_post as $recent ){
		echo '<a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> ';
	}
?>
</div><!-- .third-box -->

			<?php else : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>