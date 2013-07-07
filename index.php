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

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post();
		designsimply_tonesque_css(); ?>
		<h2><a class="the-title" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
			<?php if ( is_attachment() ) : ?>
				<span class="sep"> // </span>
				<?php $metadata = wp_get_attachment_metadata();
				printf( __( '<a class="post-parent" href="%1$s" title="%2$s" rel="gallery">%2$s</a>', 'designsimply' ),
					get_permalink( $post->post_parent ),
					get_the_title( $post->post_parent )
				);
			endif; ?>
		</h2>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php if ( is_attachment() ) : ?>
				<nav>
					<span class="next"><?php next_image_link( '%link', __( '<div class="genericon genericon-expand"></div>', 'designsimply' ) ); ?></span>
					<span class="previous"><?php previous_image_link( '%link', __( '<div class="genericon genericon-collapse"></div>', 'designsimply' ) ); ?></span>
				</nav>
			<?php else : ?>
				<nav>
					<span class="next"><?php previous_post_link( '%link', __( '<div class="genericon genericon-expand"></div>', 'designsimply' ) ); ?></span>
					<span class="previous"><?php next_post_link( '%link', __( '<div class="genericon genericon-collapse"></div>', 'designsimply' ) ); ?></span>
				</nav>
			<?php endif; ?>

			<?php if ( is_search() || is_archive() ) : // Only display excerpts for search and archives ?>
				<div class="the_excerpt">
					<?php the_excerpt(); ?>
				</div><!-- .the_excerpt -->
			<?php elseif ( is_attachment() ) : // Only display Excerpts for Search
				$attachment_size = apply_filters( 'designsimply_attachment_size', array( 640, 640 ) ); // Filterable image size.
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
				}
				echo '</style>';
				?>
				<div class="the-excerpt">
					<?php the_excerpt(); ?>
				</div><!-- .the_excerpt -->
			<?php else : ?>
				<div class="the-content">
					<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'designsimply' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'designsimply' ), 'after' => '</div>' ) ); ?>
				</div><!-- .entry-content -->
			<?php endif; ?>

			<?php if ( !is_page() ) : ?>
			<div class="meta">
				<?php designsimply_posted_by(); ?>
				<span class="sep"> // </span>
				<?php designsimply_posted_on(); ?>
			</div><!-- .meta -->
			<?php endif; ?>

			<div class="site-title">
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="post-parent" rel="home"><?php bloginfo( 'name' ); ?></a>
			</div>

			<?php if ( 'attachment' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
				<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'designsimply' ),'.' );
				if ( $tags_list ) :
				?>
				<span class="tags-links">
					<?php printf( __( 'Tagged %1$s', 'designsimply' ), $tags_list ); ?>
				</span>
				<?php endif; // End if $tags_list ?>
			<?php endif; // End if 'post' == get_post_type() ?>
			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
				<!--<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'designsimply' ), __( '1 Comment', 'designsimply' ), __( '% Comments', 'designsimply' ) ); ?>.</span>-->
			<?php :wq
			endif; ?>
			<?php edit_post_link( __( 'Edit', 'designsimply' ), '<span class="edit-link">', '</span>' ); ?>

		</article><!-- #post-<?php the_ID(); ?> -->
	<?php endwhile; ?>
<?php else : ?>

	<?php get_template_part( 'no-results', 'index' ); ?>

<?php endif; ?>

<?php if ( ! is_attachment() ) : get_sidebar(); endif; ?>

<?php get_footer(); ?>
