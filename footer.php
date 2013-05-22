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

	</div><!-- #main -->

	<?php if ( ! is_single() && ! is_page() ) { ?>

	<div class="bio">
		<p><img class="alignleft" src="http://0.gravatar.com/avatar/198723e26f9350d9bbe8d4f35a8b0bb7?size=116" />
			Sheri Bigelow is a Creativity Cultivator for Automattic. She has blended a love of photography, a degree in Business & Chemistry, a geeky penchant for optimizing nginx, and adoration for WordPress to help the world create beautiful websites they love at WordPress.com. She’s passionate about working with the extraordinary collection of talent that is Automattic and can usually be found speaking at WordCamps, skiing the Rockies, kayaking the Adirondacks, or exploring Saratoga Springs, NY.</p>
	</div>

	<nav role="navigation sitemap">
		<h2 class="assistive-text"><?php _e( 'Menu', 'designsimply' ); ?></h2>
		<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'designsimply' ); ?>"><?php _e( 'Skip to content', 'designsimply' ); ?></a></div>
		<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
	</nav>
	<?php } ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="social">
			<ul>
				<li><a href="https://twitter.com/designsimply"><div class="genericon genericon-twitter"></div>  <span>twitter</span></a></li>
				<li><a href="http://dribbble.com/designsimply"><div class="genericon genericon-dribbble"></div> <span>dribbble</span></a></li>
				<li><a href="https://github.com/designsimply"><div class="genericon genericon-github"></div> <span>github</span></a></li>
				<li><a href="http://designsimply.com/feed/"><div class="genericon genericon-feed"></div>  <span>feed</span></a></li>
			</ul>
		</div>
		<div class="site-info">
			<?php printf( __( '%1$s is an experimental flexbox layout theme made by %2$s for %3$s with &hearts;', 'designsimply' ), '<a href="http://designsimply.com/theme/" rel="theme">Design Simply</a>', '<a href="http://designsimply.com/theme/" rel="designer">Sheri Bigelow</a>', '<a href="http://wordpress.org/" rel="generator">WordPress</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon .site-footer -->

<?php wp_footer(); ?>

</body>
</html>
