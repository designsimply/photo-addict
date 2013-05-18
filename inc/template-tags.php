<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package designsimply
 * @since designsimply 1.0
 */

if ( ! function_exists( 'designsimply_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since designsimply 1.0
 */
function designsimply_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'designsimply' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

	<?php next_post_link( '<div class="nav-next">%link</div>', '<span class="meta-nav">' . _x( '%title', 'Down', 'designsimply' ) . '</span>' ); ?>
	<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '%title', 'Up', 'designsimply' ) . '</span>' ); ?>
		
	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr; Older</span>', 'designsimply' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( '<span class="meta-nav">Newer &rarr;</span>', 'designsimply' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // designsimply_content_nav

if ( ! function_exists( 'designsimply_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since designsimply 1.0
 */
function designsimply_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Mentioned in ', 'designsimply' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '<span class="tooltip">Edit</span>', 'designsimply' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">

			<header class="comment-author vcard">
				<?php echo get_avatar( $comment, 40 ); ?>
				<cite class="fn"><?php comment_author_link(); ?></cite>
				<time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<a href="<?php echo esc_url( get_comment_link() ); ?>"><span class="tooltip"><?php printf( __( '%1$s at %2$s', 'designsimply' ), get_comment_date(), get_comment_time() ); ?></span></a>
				</time>
				<?php edit_comment_link( __( '<span class="tooltip">Edit</span>', 'designsimply' ), '', '' ); ?>
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => '<span class="tooltip">Reply</span>' ) ) ); ?>
			</header><!-- .comment-author .vcard -->

			<section class="comment post-content">
				<?php if ( $comment->comment_approved == '0' ) { ?>
					<p><?php _e( 'Your comment will be reviewed soon.', 'designsimply' ) ?></p>
				<?php } ?>  

				<?php comment_text(); ?>
			</section><!-- .comment .post-content -->

			<footer class="reply">
				
				
			</footer><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for designsimply_comment()

if ( ! function_exists( 'designsimply_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time.
 *
 * @since designsimply 1.0
 */
function designsimply_posted_on() {
	printf( __( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>', 'designsimply' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
}
endif;

if ( ! function_exists( 'designsimply_posted_by' ) ) :
/**
 * Prints HTML with meta information for the current post author.
 *
 * @since designsimply 1.0
 */
function designsimply_posted_by() {
	if ( is_single() && is_multi_author() ) {
		printf( __( '<p class="byline">By <span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span></p>', 'designsimply' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'See posts by %s', 'designsimply' ), get_the_author() ) ),
			esc_html( get_the_author() )
		);
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category
 *
 * @since designsimply 1.0
 */
function designsimply_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so designsimply_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so designsimply_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in designsimply_categorized_blog
 *
 * @since designsimply 1.0
 */
function designsimply_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'designsimply_category_transient_flusher' );
add_action( 'save_post', 'designsimply_category_transient_flusher' );