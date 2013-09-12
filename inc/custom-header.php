<?php
/**
 * Implementation of the Custom Header feature
 *
 * @package photo-addict
 * @since photo-addict 1.0
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * @uses photo_addict_header_style()
 * @uses photo_addict_admin_header_style()
 * @uses photo_addict_admin_header_image()
 *
 * @package photo-addict
 */
function photo_addict_custom_header_setup() {
	$args = array(
		'default-image'          => '',
		'width'                  => 648,
		'height'                 => 150,
		'flex-height'            => true,
		'wp-head-callback'       => 'photo_addict_header_style',
		'admin-head-callback'    => 'photo_addict_admin_header_style',
		'admin-preview-callback' => 'photo_addict_admin_header_image',
	);
	define( 'NO_HEADER_TEXT', true );

	$args = apply_filters( 'photo_addict_custom_header_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-header', $args );
	} else {
		// Compat: Versions of WordPress prior to 3.4.
		define( 'HEADER_IMAGE',        $args['default-image'] );
		define( 'HEADER_IMAGE_WIDTH',  $args['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $args['height'] );
		add_theme_support( 'custom-header', $args );
	}
}
add_action( 'after_setup_theme', 'photo_addict_custom_header_setup' );

/**
 * Shiv for get_custom_header().
 *
 * get_custom_header() was introduced to WordPress
 * in version 3.4. To provide backward compatibility
 * with previous versions, we will define our own version
 * of this function.
 *
 * @todo Remove this function when WordPress 3.6 is released.
 * @return stdClass All properties represent attributes of the curent header image.
 *
 * @package photo-addict
 * @since photo-addict 1.1
 */

if ( ! function_exists( 'get_custom_header' ) ) {
	function get_custom_header() {
		return (object) array(
			'url'           => get_header_image(),
			'thumbnail_url' => get_header_image(),
			'width'         => HEADER_IMAGE_WIDTH,
			'height'        => HEADER_IMAGE_HEIGHT,
		);
	}
}

if ( ! function_exists( 'photo_addict_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see photo_addict_custom_header_setup().
 *
 * @since photo-addict 1.0
 */
function photo_addict_header_style() {

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		.site-title {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // photo_addict_header_style

if ( ! function_exists( 'photo_addict_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see photo_addict_custom_header_setup().
 *
 * @since photo-addict 1.0
 */
function photo_addict_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	</style>
<?php
}
endif; // photo_addict_admin_header_style

if ( ! function_exists( 'photo_addict_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see photo_addict_custom_header_setup().
 *
 * @since photo-addict 1.0
 */
function photo_addict_admin_header_image() { ?>
	<div id="headimg">
		<h1><a id="name" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }
endif; // photo_addict_admin_header_image

