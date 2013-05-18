<?php
/**
 * @package designsimply
 * @since designsimply 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<div class="entry-meta">
		<?php designsimply_posted_on(); ?>
		<h2 class="entry-title"><?php the_title(); ?></h2>
		<?php designsimply_posted_by(); ?>
			<?php 
				$tag_list = get_the_tag_list( '', __( ', ', 'designsimply' ) );
				if ( '' != $tag_list ) {
					//echo __( ' ', 'designsimply' );
					echo $tag_list;
				}
			?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'designsimply' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'designsimply' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'designsimply' ) );

			if ( ! designsimply_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'Tagged %2$s via <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'designsimply' );
				} else {
					$meta_text = __( 'Via <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'designsimply' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( 'Filed under %1$s and tagged %2$s via <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'designsimply' );
				} else {
					$meta_text = __( 'Filed under %1$s via <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'designsimply' );
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' )
			);
		?>

		<?php edit_post_link( __( 'Edit', 'designsimply' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
