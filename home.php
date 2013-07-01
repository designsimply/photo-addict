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
	<?php //designsimply_tonesque_css(); ?>

	<section class="content" role="main">
		<article>
			<h2>Writing</h2>
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
				<li><a href="<?php the_permalink() ?>"><?php echo $post->post_title; //echo substr( $post->post_title, 0, 37 ); ?></a></li>
			<?php
				endwhile;
				endif;
			?>
			</ul>
			<?php designsimply_content_nav( 'nav-below' ); ?>

		</article>

		<article>
			<h2>Speaking</h2>
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

				if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
					<a href="<?php the_permalink() ?>" class="post-format-status"><?php the_post_format_image( 'medium' ); ?><br><?php the_title(); ?></a>
				<?php
				endwhile;
				endif;
			?>
			<?php //designsimply_content_nav( 'nav-below' ); ?>
		</article>

		<article>
			<h2>Photography</h2>
			<div class="image-block">
			<?php
				$args = array(
					//'paged' => $paged,
					'posts_per_page' => 8,
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

					<a href="<?php the_permalink() ?>"><?php the_post_format_image( 'thumbnail' ); ?></a>

			<?php
				endwhile;
				endif;
			?>
			<?php //designsimply_content_nav( 'nav-below' ); ?>
			</div>
		</article>
	</section><!-- .content -->

		<?php //else : ?>

			<?php //get_template_part( 'no-results', 'index' ); ?>

		<?php //endif; ?>

	<!--<section class="side" role="complimentary">
		<aside class="bio">
			<p><img class="alignleft gravatar" src="http://0.gravatar.com/avatar/198723e26f9350d9bbe8d4f35a8b0bb7?size=116" />
				Sheri Bigelow is a Creativity Cultivator for Automattic. She has blended a love of photography, a degree in
				Business & Chemistry, a geeky penchant for optimizing nginx, and adoration for WordPress to help the world
				create beautiful websites they love at WordPress.com. She’s passionate about working with the extraordinary
				collection of talent that is Automattic and can usually be found speaking at WordCamps, skiing the Rockies,
				kayaking the Adirondacks, or exploring Saratoga Springs, NY.</p>
		</aside>
	</section> .side -->

<?php get_sidebar(); ?>
<?php //get_footer(); ?>
