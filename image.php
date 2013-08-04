<?php
/**
 * The template file for displaying image attachments.
 *
 * @package photo-addict
 * @since photo-addict 1.0
 */
get_header(); ?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); photo_addict_tonesque_css(); ?>
		<h2><?php the_title(); ?>
			<span class="sep"> // </span>
			<?php $metadata = wp_get_attachment_metadata();
			printf( __( '<a class="post-parent" href="%1$s" title="%2$s" rel="gallery">%2$s</a>', 'photo-addict' ),
				get_permalink( $post->post_parent ),
				get_the_title( $post->post_parent )
			); ?>
		</h2>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<nav>
				<span class="next"><?php next_image_link( '%link', __( '<div class="genericon genericon-expand"></div>', 'photo-addict' ) ); ?></span>
				<span class="previous"><?php previous_image_link( '%link', __( '<div class="genericon genericon-collapse"></div>', 'photo-addict' ) ); ?></span>
			</nav>

			<?php
				// Pull the size values available for the current image
				$image_sizes = array('small', 'medium', 'large');

				foreach ($image_sizes as $image_size) {
					if ( isset( $metadata['sizes'][$image_size]['width'] ) )
						$widths["$image_size"] = $metadata['sizes'][$image_size]['width'];
				}

				$widths['full'] = $metadata['width'];

				// Sort and get the last value
				sort( $widths );
				$max_width = array_pop( $widths );

				// Fallback to a set value if a max width cannot be found
				if ( empty( $max_width ) || $max_width > 640 )
					$max_width = 640;

				$attachment_size = apply_filters( 'photo_addict_attachment_size', array( $max_width, $max_width ) ); // Filterable image size.
				$attachment_image = wp_get_attachment_image_src( $post->ID, $attachment_size );

				echo '<img src="' . $attachment_image[0] . '" width="' . $attachment_image[1] . '" height="' . $attachment_image[2] . '" />';

				// Match the #wrapper width to the image width so the rotate site title and byline "drip" nicely around the image
				echo '<style>';
				if ( $attachment_image[1] > 0 ) {
					echo '.attachment #wrapper { width: ' . $attachment_image[1] . 'px; max-width: 100%; }';
					echo '.target { filter:url(#svgBlur); }';
				}
				echo '</style>';

				the_content();
			?>

			<div class="meta">
				<div class="genericon-22 genericon-image"></div> <?php photo_addict_posted_by(); ?>
				<span class="sep"> // </span>
				<?php photo_addict_posted_on(); ?>
				<?php edit_post_link( __( '<div class="genericon-22 genericon-edit"></div>', 'photo-addict' ), '', '' ); ?>
			</div><!-- .meta -->

			<div class="site-title">
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="post-parent" rel="home"><?php bloginfo( 'name' ); ?></a>
			</div>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'photo-addict' ),'.' );
				if ( $tags_list ) :
				?>
				<span class="tags-links">
					<?php printf( __( 'Tagged %1$s', 'photo-addict' ), $tags_list ); ?>
				</span>
				<?php endif; // End if $tags_list ?>
			<?php //if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
				<!--<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'photo-addict' ), __( '1 Comment', 'photo-addict' ), __( '% Comments', 'photo-addict' ) ); ?>.</span>-->
			<?php //endif; ?>

		</article><!-- #post-<?php the_ID(); ?> -->
	<?php endwhile; ?>
<?php else : ?>

	<?php get_template_part( 'no-results', 'index' ); ?>

<?php endif; ?>

<!--
<p>Lorem ipsum dolor sit amet, consectetur adipisicing
    <b class="target">elit, sed do eiusmod tempor incididunt
    ut labore et dolore magna aliqua.</b> Ut enim ad minim veniam.</p>

<svg height="0" xmlns="http://www.w3.org/2000/svg">
  <filter id="svgBlur" x="-5%" y="-5%" width="110%" height="110%">
    <feGaussianBlur in="SourceGraphic" stdDeviation="5"/>
  </filter>
</svg>
-->

<?php get_footer(); ?>
