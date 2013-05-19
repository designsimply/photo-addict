<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package designsimply
 * @since designsimply 1.0
 */
?>

	</div><!-- #main .site-main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php printf( __( '%1$s Theme made with %2$s on %3$s', 'designsimply' ), '<a href="http://designsimply.com/theme/" rel="designer">Design Simply</a>', '<a href="http://underscores.me/" rel="inspiration">Underscores.me</a>', '<a href="http://wordpress.org/" rel="generator">WordPress</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>
