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
		<h2><a class="the-title" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
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
				$attachment_size = apply_filters( 'photo_addict_attachment_size', array( 640, 640 ) ); // Filterable image size.
				//echo wp_get_attachment_image( $post->ID, $attachment_size );
				echo wp_get_attachment_image( $post->ID, 'large' );
				$image_attributes = wp_get_attachment_image_src( $post->ID, 'large' );
				$image_width = max( $metadata['sizes']['large']['width'], $metadata['sizes']['medium']['width'], $metadata['sizes']['thumbnail']['width'] );
				if ( ( ! $metadata['sizes']['large']['width'] > 0 || $metadata['width'] < $metadata['sizes']['large']['width'] ) && $metadata['width'] > $metadata['sizes']['medium']['width'] ) {
					$image_width = $metadata['width'];
				}
				echo '<style>';
				if ( $image_width > 0 ) {
					echo '.attachment #wrapper { width: ' . $image_width . 'px; }';
					echo '.target { filter:url(#svgBlur); }';
				}
				echo '</style>';
			?>
				<div class="the-content">
					<?php the_content(); ?>
				</div><!-- .the-content -->

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
