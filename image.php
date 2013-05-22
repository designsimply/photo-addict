<?php
/**
 * The template for displaying image attachments.
 *
 * @package designsimply
 * @since designsimply 1.0
 */
 
get_header();
?>

			<?php while ( have_posts() ) : the_post(); ?>
			<?php designsimply_tonesque_css(); // Print post-specific color css ?>
			<header>
			<h2><?php the_title(); ?></h2>
			<p class="entry-meta">
			<?php
				$metadata = wp_get_attachment_metadata();
				printf( __( '<a href="%1$s" title="%2$s" rel="gallery">%2$s</a>', 'designsimply' ),
					get_permalink( $post->post_parent ),
					get_the_title( $post->post_parent )
				);
			?>
			<nav id="image-navigation" class="site-navigation">
				<span class="previous-image"><?php previous_image_link( false, __( '<div class="genericon-button genericon-collapse"></div>', 'designsimply' ) ); ?></span>
				<span class="next-image"><?php next_image_link( false, __( '<div class="genericon-button genericon-expand"></div>', 'designsimply' ) ); ?></span>
			</nav><!-- #image-navigation -->
			</p>
			</header>
			<div class="container">
				<!--<a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment">-->
					<?php
						$attachment_size = apply_filters( 'designsimply_attachment_size', array( 768, 768 ) ); // Filterable image size.
						echo wp_get_attachment_image( $post->ID, $attachment_size );
					?>
				<!--</a>-->
			</div>

			<div class="byline">
				<div class="genericon-22 genericon-image"></div> 
				by <a href="/about/"><?php echo esc_html( get_the_author() ); ?></a> 
				// <?php esc_html( the_date() ); ?> 
				<?php edit_post_link( __( 'edit', 'designsimply' ) ); ?>
			</div>

						<p class="entry-meta">
							<?php
								$metadata = wp_get_attachment_metadata();
								printf( __( 'Published <span class="entry-date"><time class="entry-date" datetime="%1$s" pubdate>%2$s</time></span> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%7$s</a>', 'designsimply' ),
									esc_attr( get_the_date( 'c' ) ),
									esc_html( get_the_date() ),
									wp_get_attachment_url(),
									$metadata['width'],
									$metadata['height'],
									get_permalink( $post->post_parent ),
									get_the_title( $post->post_parent )
								);
							?>
							<?php edit_post_link( __( 'edit', 'designsimply' ) ); ?>
						</p><!-- .entry-meta -->



								<?php
									/**
									 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
									 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
									 */
									$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
									foreach ( $attachments as $k => $attachment ) {
										if ( $attachment->ID == $post->ID )
											break;
									}
									$k++;
									// If there is more than 1 attachment in a gallery
									if ( count( $attachments ) > 1 ) {
										if ( isset( $attachments[ $k ] ) )
											// get the URL of the next image attachment
											$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
										else
											// or get the URL of the first image attachment
											$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
									} else {
										// or, if there's only 1 image, get the URL of the image
										$next_attachment_url = wp_get_attachment_url();
									}
								?>

							<?php if ( ! empty( $post->post_excerpt ) ) : ?>
							<div class="entry-caption">
								<?php the_excerpt(); ?>
							</div><!-- .entry-caption -->
							<?php endif; ?>

						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'designsimply' ), 'after' => '</div>' ) ); ?>


					<footer class="entry-meta">
						<?php if ( comments_open() && pings_open() ) : // Comments and trackbacks open ?>
							<?php printf( __( '<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a> or leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'designsimply' ), get_trackback_url() ); ?>
						<?php elseif ( ! comments_open() && pings_open() ) : // Only trackbacks open ?>
							<?php printf( __( 'Comments are closed, but you can leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'designsimply' ), get_trackback_url() ); ?>
						<?php elseif ( comments_open() && ! pings_open() ) : // Only comments open ?>
							<?php _e( 'Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Post a comment">post a comment</a>.', 'designsimply' ); ?>
						<?php elseif ( ! comments_open() && ! pings_open() ) : // Comments and trackbacks closed ?>
							<?php _e( 'Both comments and trackbacks are currently closed.', 'designsimply' ); ?>
						<?php endif; ?>
						<?php edit_post_link( __( 'Edit', 'designsimply' ), ' <span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->

				<?php comments_template(); ?>

			<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>