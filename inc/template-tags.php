<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package photo-addict
 * @since photo-addict 1.0
 */

if ( ! function_exists( 'photo_addict_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since photo-addict 1.0
 */
function photo_addict_content_nav( $nav_id ) {
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
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'photo-addict' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '<span class="meta-nav">' . _x( '%title', 'Down', 'photo-addict' ) . '</span>' ); ?>
		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '%title', 'Up', 'photo-addict' ) . '</span>' ); ?>
	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>
		<span class="next">
			<?php next_posts_link( __( '<div class="genericon genericon-expand"></div>', 'photo-addict' ) ); ?>
		</span>
		<span class="previous">
			<?php previous_posts_link( __( '<div class="genericon genericon-collapse"></div>', 'photo-addict' ) ); ?>
		</span>
	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // photo_addict_content_nav

if ( ! function_exists( 'photo_addict_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since photo-addict 1.0
 */
function photo_addict_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Mentioned in ', 'photo-addict' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '<span class="genericon-22 genericon-edit"></span>', 'photo-addict' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>

		<a href="<?php echo esc_url( get_comment_link() ); ?>"><?php echo get_avatar( $comment, 32, '', get_comment_date() . ' at ' . get_comment_time() ); ?></a>
		<cite class="fn"><?php comment_author_link(); ?></cite>

		<?php edit_comment_link( __( '<span class="genericon-22 genericon-edit"></span>', 'photo-addict' ), '', '' ); ?>
		<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => '<span class="genericon-22 genericon-reply"></span>' ) ) ); ?>

		<?php if ( $comment->comment_approved == '0' ) { ?>
			<p><?php _e( 'Your comment will be reviewed soon.', 'photo-addict' ) ?></p>
		<?php } ?>

		<?php comment_text(); ?>

		<span class="reply"></span><!-- .reply -->

	<?php
			break;
	endswitch;
}
endif; // ends check for photo_addict_comment()

if ( ! function_exists( 'photo_addict_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time.
 *
 * @since photo-addict 1.0
 */
function photo_addict_posted_on() {
	printf( __( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>', 'photo-addict' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
}
endif;

if ( ! function_exists( 'photo_addict_posted_by' ) ) :
/**
 * Prints HTML with meta information for the current post author.
 *
 * @since photo-addict 1.0
 */
function photo_addict_posted_by() {
	if ( is_single() ) {
		printf( __( 'by <span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>', 'photo-addict' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_login' ) ) ),
			esc_attr( sprintf( __( 'See more by %s', 'photo-addict' ), get_the_author() ) ),
			esc_html( get_the_author() )
		);
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category
 *
 * @since photo-addict 1.0
 */
function photo_addict_categorized_blog() {
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
		// This blog has more than 1 category so photo_addict_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so photo_addict_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in photo_addict_categorized_blog
 *
 * @since photo-addict 1.0
 */
function photo_addict_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'photo_addict_category_transient_flusher' );
add_action( 'save_post', 'photo_addict_category_transient_flusher' );
