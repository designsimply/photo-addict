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

		<div id="main" role="main">

			<?php //designsimply_tonesque_css(); // Print post-specific color css ?>
			<section>
				<h2>Writing</h2>
				<ul>
				<?php 
					$args = array( 
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
			</section>

			<section>
				<h2>Speaking</h2>
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

					if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
						<a href="<?php the_permalink() ?>"><?php the_post_format_image( 'large' ); ?><br><?php the_title(); ?></a>
					<?php 
					endwhile; 
					endif;


					/*
					$args = array( 'numberposts' => '1', 'tax_query' => array(
							array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => 'post-format-status',
								'operator' => 'IN'
							)
					) );
					$recent_posts = wp_get_recent_posts( $args );
					foreach($recent_posts as $recent ){
						echo '<a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' . $recent["post_title"].'</a> ';
						//the_post_format_image( 'medium' );
						if ( has_post_thumbnail() )
							the_post_thumbnail( 'medium' );
						//echo '<script type="text/javascript" src="http://speakerdeck.com/embed/4f1a05d21a3f95001f0133df.js"></script>';
						/* Medium random image
						$all_images =& get_children( 'post_parent=&post_type=attachment&post_mime_type=image&numberposts=-1&poststatus=publish' );
						$random = array_rand($all_images);
						echo '<br><a href="' . get_permalink($random) . '#image">';
						echo wp_get_attachment_image( $random, 'medium' );
						echo '</a>';
						
					}
					*/
				?>
			</section>

			<section>
				<h2>Photography</h2>
				<ul>
				<?php 
					//query_posts(array('post__not_in' => $ids));
					$args = array( 
						'posts_per_page' => 6,
						'tax_query' => array(
							array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array( 'post-format-gallery', 'post-format-image' ),
								'operator' => 'IN'
							)
					) );
					$query = new WP_Query( $args );

					if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>

						<li><a href="<?php the_permalink() ?>"><?php the_post_format_image( 'thumbnail' ); ?></a></li>

					<?php 
					endwhile;
					endif;

					?>
					</ul>
					<?php
						/*
						$args = array( 'numberposts' => '6', 'tax_query' => array(
								array(
									'taxonomy' => 'post_format',
									'field' => 'slug',
									'terms' => 'post-format-image','post-format-gallery',
									'operator' => 'IN'
								)
						) );
						$latest_image_post = wp_get_recent_posts( $args );
						foreach( $latest_image_posts as $recent ){
							echo '<a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> ';
							echo 'asdf'.get_the_post_format_image( 'thumbnail' );
						}
						*/
					?>
			</section>

			<?php //else : ?>

				<?php //get_template_part( 'no-results', 'index' ); ?>

			<?php //endif; ?>

		</div><!-- #main -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>