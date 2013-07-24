<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package photo-addict
 * @since photo-addict 1.0
 */
?>

<?php if ( ( is_single() || is_page() ) && ! is_attachment() ) : ?>
<nav role="navigation">
	<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
	<?php dynamic_sidebar( 'sidebar-2' ); ?>
</nav>

<footer>
	<?php /*printf( __( '%1$s is an experimental flexbox layout theme made by %2$s for %3$s with &hearts;', 'photo-addict' ),
		'<a href="http://designsimply.com/theme/" rel="theme">Photo Addict</a>',
		'<a href="http://designsimply.com/about/" rel="designer">Sheri Bigelow</a>',
		'<a href="http://wordpress.org/" rel="generator">WordPress</a>'
	);*/ ?>
</footer>
<?php endif; ?>

<svg height="0" xmlns="http://www.w3.org/2000/svg">
  <filter id="blur50" x="-5%" y="-5%" width="110%" height="110%">
    <feGaussianBlur in="SourceGraphic" stdDeviation="50"/>
  </filter>
</svg>

</div><!-- #wrapper -->

<?php wp_footer(); ?>
</body>
</html>
