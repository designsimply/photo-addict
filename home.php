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
	<section class="content" role="main">
		<article>
			<h3>Writing</h3>
			<ul>
			<?php
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$args = array(
					'paged' => $paged,
					'tax_query' => array(
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => array( 'post-format-status', 'post-format-image' , 'post-format-gallery' ),
							'operator' => 'NOT IN'
						)
				) );
				$query = new WP_Query( $args );

				if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); designsimply_tonesque_css();
				$ids[] = get_the_ID(); ?>
				<li><a href="<?php the_permalink() ?>"><?php echo $post->post_title; //echo substr( $post->post_title, 0, 37 ); ?></a></li>
			<?php
				endwhile;
				else :
					get_template_part( 'no-results', 'index' );
				endif;
			?>
			</ul>
			<?php designsimply_content_nav( 'nav-below' ); ?>

		</article>

		<article>
			<h3>Speaking</h3>
			<?php
				$args = array(
					//'paged' => $paged,
					'posts_per_page' => 1,
					'tax_query' => array(
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => 'post-format-status',
							'operator' => 'IN'
						)
				) );
				$query = new WP_Query( $args );

				if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();

					// Use the post format image if it exists, then fallback to the featured image
					if ( function_exists( 'the_post_format_image' ) ) : ?>
						<a href="<?php the_permalink() ?>" class="post-format-status"><?php the_post_format_image( 'medium' ); ?><br><?php the_title(); ?></a>
					<?php elseif ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink() ?>" class="post-format-status"><?php the_post_thumbnail( 'medium' ); ?><br><?php the_title(); ?></a>
					<?php else : ?>
						<a href="<?php the_permalink() ?>" class="post-format-status"><?php the_title(); ?></a>						
					<?php endif;
				endwhile;
				endif;
			?>
			<?php //designsimply_content_nav( 'nav-below' ); ?>
		</article>

		<article>
			<h3>Photography</h3>
			<div class="image-block">
				<?php $args = array(
					//'paged' => $paged,
					'posts_per_page' => 12,
					'tax_query' => array(
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => array( 'post-format-gallery' ),
							'operator' => 'IN'
						)
				) );
				$query = new WP_Query( $args );


				if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
					<?php elseif ( function_exists( 'the_post_format_image' ) ) : ?>
						<a href="<?php the_permalink() ?>"><?php the_post_format_image( 'thumbnail' ); ?></a>
					<?php endif;
				endwhile;
				endif; ?>
			</div>
		</article>
	</section><!-- .content -->

	<section class="side" role="complimentary">

	</section> <!-- .side -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
