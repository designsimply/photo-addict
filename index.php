<?php
/**
 * The main template file.
 * It is used to display a page when nothing more specific matches a query.
 *
 * @package photo-addict
 * @since photo-addict 1.0
 */
get_header(); ?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); 
		echo photo_addict_tonesque_css(); ?>
		<h2><a class="the-title" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
			<?php if ( is_attachment() ) : ?>
				<span class="sep"> // </span>
				<?php $metadata = wp_get_attachment_metadata();
				printf( __( '<a class="post-parent" href="%1$s" title="%2$s" rel="gallery">%2$s</a>', 'photo-addict' ),
					get_permalink( $post->post_parent ),
					get_the_title( $post->post_parent )
				);
			endif; ?>
		</h2>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<nav>
				<span class="previous"><?php next_post_link( '%link', __( '<div class="genericon genericon-collapse"></div>', 'photo-addict' ) ); ?></span>
				<span class="next"><?php previous_post_link( '%link', __( '<div class="genericon genericon-expand"></div>', 'photo-addict' ) ); ?></span>
			</nav>

			<?php if ( is_search() || is_archive() ) : // Only display excerpts for search and archives ?>
			<div class="the_excerpt">
				<?php the_excerpt(); ?>
			</div><!-- .the_excerpt -->
			<?php else : ?>
			<div class="the-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'photo-addict' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'photo-addict' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
			<?php endif; ?>

			<?php if ( !is_page() ) : ?>
			<div class="meta">
				<?php photo_addict_posted_by(); ?>
				<span class="sep"> // </span>
				<?php photo_addict_posted_on(); ?>
				<?php edit_post_link( __( '<div class="genericon-22 genericon-edit rotate270"></div>', 'photo-addict' ), '', '' ); ?>
			</div><!-- .meta -->
			<?php endif; ?>

			<div class="site-title">
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="post-parent" rel="home"><?php bloginfo( 'name' ); ?></a>
			</div>

			<?php // If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() )
				comments_template( '', true );
			?>

		</article><!-- #post-<?php the_ID(); ?> -->
	<?php endwhile; ?>
<?php else : ?>

	<?php get_template_part( 'no-results', 'index' ); ?>

<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
