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

<?php if ( ( is_single() || is_page() ) && ! is_attachment() ) : ?>
<nav role="navigation">
	<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>

	<div class="social">
		<ul>
			<li><a href="https://twitter.com/designsimply"><div class="genericon genericon-twitter"></div>  <span>twitter</span></a></li>
			<li><a href="http://dribbble.com/designsimply"><div class="genericon genericon-dribbble"></div> <span>dribbble</span></a></li>
			<li><a href="https://github.com/designsimply"><div class="genericon genericon-github"></div> <span>github</span></a></li>
			<li><a href="http://designsimply.com/feed/"><div class="genericon genericon-feed"></div>  <span>feed</span></a></li>
		</ul>
	</div>
</nav>

<footer>
	<?php printf( __( '%1$s is an experimental flexbox layout theme made by %2$s for %3$s with &hearts;', 'designsimply' ),
		'<a href="http://designsimply.com/theme/" rel="theme">Saratoga</a>',
		'<a href="http://designsimply.com/theme/" rel="designer">Sheri Bigelow</a>',
		'<a href="http://wordpress.org/" rel="generator">WordPress</a>'
	); ?>
</footer>
<?php endif; ?>
<?php wp_footer(); ?>

</div><!-- #wrapper -->

</body>
</html>
