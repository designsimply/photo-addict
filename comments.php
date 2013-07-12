<?php
/**
 * The template for displaying comments lists.
 *
 * @package designsimply
 * @since designsimply 1.0
 */
?>

<?php
	/* Bail if the post is password protected. */
	if ( post_password_required() )
		return;
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : 
		//if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><a href="#respond"><div class="genericon-22 genericon-reply"></div></a></span>
		<span class="comments-link"><?php comments_popup_link( __( '<div class="genericon-22 genericon-chat"></div>', 'designsimply' ), __( '<div class="genericon-22 genericon-chat"></div> 1', 'designsimply' ), __( '<div class="genericon-22 genericon-reply"></div> %', 'designsimply' ) ); ?></span>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav role="navigation" id="comment-nav-above" class="site-navigation comment-navigation">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'designsimply' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'designsimply' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'designsimply' ) ); ?></div>
		</nav><!-- #comment-nav-before .site-navigation .comment-navigation -->
		<?php endif; // check for comment navigation ?>

		<ol class="commentlist">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use designsimply_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define designsimply_comment() and that will be used instead.
				 * See designsimply_comment() in inc/template-tags.php for more.
				 */
				wp_list_comments( array( 'callback' => 'designsimply_comment' ) );
			?>
		</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'designsimply' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'designsimply' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'designsimply' ) ); ?></div>
		</nav><!-- #comment-nav-below .site-navigation .comment-navigation -->
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'desigsnimply' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php comment_form( array(
		'comment_notes_before' => '',
		'comment_notes_after' => ''
		)
	); ?>

</div><!-- #comments .comments-area -->
