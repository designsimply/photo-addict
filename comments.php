<?php
/**
 * The template for displaying comments and the comment form.
 *
 * @package photo-addict
 * @since photo-addict 1.0
 */
?>

<?php
	/* Bail if the post is password protected. */
	if ( post_password_required() )
		return;
?>

<div id="comments" class="comments-area">
	<?php $comments_total = get_comments_number(); ?>

	<input type="checkbox" id="read_more" role="button">
	<label for="read_more" onclick="">
	<span class="comments-link"><div class="genericon-22 genericon-chat"></div>
		<?php if ( 0 == $comments_total ) {
			echo 'Leave a Comment';
		} elseif ( 1 == $comments_total ) {
			echo '1 Comment';
		} else {
			echo $comments_total . ' Comments';
		} ?></span>
	<span class="comments-link"><div class="genericon-22 genericon-chat"></div>
		<?php if ( 0 == $comments_total ) {
			echo 'Hide Comment Form';
		} else {
			echo ' Hide Comments';
		} ?></span>
	</label>

	<?php if ( have_comments() ) :
		//if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<!--<span class="comments-link"><a href="#respond"><div class="genericon-22 genericon-reply"></div></a></span>-->
		<?php //endif; ?>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav role="navigation" id="comment-nav-above" class="site-navigation comment-navigation">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'photo-addict' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'photo-addict' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'photo-addict' ) ); ?></div>
		</nav><!-- #comment-nav-before .site-navigation .comment-navigation -->
		<?php endif; // check for comment navigation ?>

		<ul class="commentlist">
			<?php
				/* Use photo_addict_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define photo_addict_comment() and that will be used instead.
				 * See photo_addict_comment() in inc/template-tags.php
				 */
				wp_list_comments( array( 'callback' => 'photo_addict_comment', 'format' => 'html5' ) );
			?>
		</ul><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'photo-addict' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'photo-addict' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'photo-addict' ) ); ?></div>
		</nav><!-- #comment-nav-below .site-navigation .comment-navigation -->
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are existing comments but comments are closed, leave a note. */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'desigsnimply' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php comment_form( array(
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'title_reply' => ''
		)
	); ?>

</div><!-- #comments .comments-area -->
