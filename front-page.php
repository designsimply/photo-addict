<?php
/**
 * Home page template file.
 *
 * @package photo-addict
 * @since photo-addict 1.0
 */

get_header(); ?>

	<section class="content" role="main">
		<?php $args = array(
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

		if ($query->have_posts()) : ?>
		<article>
			<div class="image-block">
				<?php while ($query->have_posts()) : $query->the_post(); ?>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
					<?php else : ?>
						<a href="<?php the_permalink() ?>"><img src="<?php echo photo_addict_first_post_image_url( $post->ID, 'thumbnail' ); ?>" alt="<?php echo $post->post_title; ?>" /></a>
					<?php endif;
				endwhile; ?>
			</div>
		</article>
		<?php endif; ?>

		<article>
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

				if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
					$ids[] = get_the_ID(); ?>
					<li><a href="<?php the_permalink() ?>" <?php post_class(); ?>>
					<?php // If the post doesn't have a title, print the month and day
					if ( empty( $post->post_title ) ) :
						echo the_date( get_option( 'date_format' ) );
					else : 
						echo $post->post_title;
					endif; ?>
					</a></li>
					<?php endwhile;
					else :
						get_template_part( 'no-results', 'index' );
				endif; ?>
			</ul>
			<?php photo_addict_content_nav( 'nav-below' ); ?>

		</article>

		<?php
		$args = array(
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

		if ($query->have_posts()) : ?>
		<article>
			<?php while ($query->have_posts()) : $query->the_post();
					// Look for an image associated with the post, fallback to the excerpt
					$first_image = photo_addict_first_post_image_url( 'medium' );
					if ( isset( $first_image ) ) : ?>
						<a href="<?php the_permalink() ?>" class="post-format-status"><img src="<?php echo $first_image; ?>" alt="<?php echo $post->post_title; ?>" /><br><?php echo $post->post_title; ?></a>
					<?php else : ?>
						<a href="<?php the_permalink() ?>" class="post-format-status"><?php echo $post->post_title; ?></a>
						<?php the_excerpt(); ?>
					<?php endif;
				endwhile; ?>
		</article>
		<?php endif; ?>
	</section><!-- .content -->

	<section class="side">

	</section> <!-- .side -->

<?php
	// echo photo_addict_color_css();
	get_footer();
?>
