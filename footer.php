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

<?php if ( ! is_attachment() ) : ?>
<nav role="navigation">
	<?php if ( ! is_home() )
		wp_nav_menu( array( 'theme_location' => 'primary' ) );

	dynamic_sidebar( 'sidebar-2' ); ?>
</nav>
<?php endif; ?>

<!-- This SVG let's us add a blur effect in Firefox since CSS3 filter:blur() doesn't work there yet -->
<svg height="0" xmlns="http://www.w3.org/2000/svg">
  <filter id="blur50" x="-5%" y="-5%" width="110%" height="110%">
    <feGaussianBlur in="SourceGraphic" stdDeviation="50"/>
  </filter>
</svg>

</div><!-- #wrapper -->
<?php wp_footer(); ?>
<?php 
  $random_image_permalink = photo_addict_random_image_permalink();
  echo '<a href="' . $random_image_permalink . '" style="position:fixed; right:0; bottom:0; padding:.5rem 1rem;" id="rollthedice">🎲</a>';
?>
</body>
</html>
