<?php
/**
 * photo-addict functions and definitions
 *
 * @package photo-addict
 * @since photo-addict 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since photo-addict 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'photo_addict_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since photo-addict 1.0
 */
function photo_addict_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	get_template_part( 'inc/template', 'tags' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'photo-addict', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Add support for post formats.
	 * Eventually: 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'gallery', 'image', 'status'
	) );

	/*
	* Add theme support for custom background color and image.
	*/
	add_theme_support( 'custom-background', array(
		'default-color' => 'f0ffff',
	) );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'photo-addict' ),
	) );
}
endif; // photo_addict_setup
add_action( 'after_setup_theme', 'photo_addict_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since photo-addict 1.0
 */
function photo_addict_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'photo-addict' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	register_sidebar( array(
		'name' => __( 'Below Footer', 'photo-addict' ),
		'id' => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
}
add_action( 'widgets_init', 'photo_addict_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function photo_addict_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );

	function photo_addict_add_editor_styles() {
		add_editor_style( 'editor-style.css' );
	}
	add_action( 'init', 'photo_addict_add_editor_styles' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Add keyboard shortcuts for navigating images
	wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20130721' );

	// Add fonts used in the main stylesheet
	wp_enqueue_style( 'photo-addict-fonts', photo_addict_fonts_url(), array(), null );

	// Add Genericons font
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/fonts/genericons.css', array(), '3.0' );
}
add_action( 'wp_enqueue_scripts', 'photo_addict_scripts' );

function photo_addict_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Lato, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$lato = _x( 'on', 'Lato font: on or off', 'photo-addict' );

	/* Translators: If there are characters in your language that are not
	 * supported by Overlock, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$overlock = _x( 'on', 'Overlock font: on or off', 'photo-addict' );

	if ( 'off' !== $lato || 'off' !== $overlock ) {
		$font_families = array();

		if ( 'off' !== $lato )
			$font_families[] = 'Lato:100,300,400,700,300italic,400italic,700italic';

		if ( 'off' !== $overlock )
			$font_families[] = 'Overlock:400,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Implement the Custom Header feature
 */
get_template_part( 'inc/custom', 'header' );

if ( ! function_exists( 'mv_browser_body_class' ) ) {
/**
 * Filter to add a link back to the parent on the last image attachment page
 **/
function mv_browser_body_class( $classes ) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	if( $is_lynx ) $classes[] = 'lynx';
	elseif( $is_gecko ) $classes[] = 'gecko';
	elseif( $is_opera ) $classes[] = 'opera';
	elseif( $is_NS4 ) $classes[] = 'ns4';
	elseif( $is_safari ) $classes[] = 'safari';
	elseif( $is_chrome ) $classes[] = 'chrome';
	elseif( $is_IE ) {
		$classes[] = 'ie';
		if( preg_match( '/MSIE ( [0-9]+ )( [a-zA-Z0-9.]+ )/', $_SERVER['HTTP_USER_AGENT'], $browser_version ) )
		$classes[] = 'ie' . $browser_version[1];
	} else $classes[] = 'unknown';
	if( $is_iphone ) $classes[] = 'iphone';
	return $classes;
}
add_filter( 'body_class','mv_browser_body_class' );
}

add_filter('wp_head', 'show_template');
function show_template() {
	global $template;
	echo "<!-- >>>>>>>>>> $template <<<<<<<<<< -->
	";
}
add_filter( 'got_rewrite', '__return_true' );

add_filter('previous_image_link', 'photo_addict_previous_link',10,3);
add_filter('next_post_link', 'photo_addict_previous_link',10,3);
/**
 * Filter to add a link back to the parent on the last image attachment page
 **/
function photo_addict_previous_link( $val, $attr, $content = null ) {
	global $post;
	$parent_link = '<a class="post-parent" href="' . get_permalink( $post->post_parent ) . '" title="' . get_the_title( $post->post_parent ) . '" rel="navigation"><span class="genericon genericon-expand rotate90"></span></a>';

	if ( empty( $post->post_parent ) )
		$parent_link = '<a class="post-parent" href="' . home_url() . '" title="' . esc_attr( get_bloginfo( 'name') ) . '" rel="home"><span class="genericon genericon-expand rotate90"></span></a>';

	return ( empty( $val ) ) ? $parent_link : $val ;
}

add_filter('next_image_link', 'photo_addict_next_link',10,3);
add_filter('previous_post_link', 'photo_addict_next_link',10,3);
/**
 * Filter to add a link back to the parent on the last image attachment page
 **/
function photo_addict_next_link( $val, $attr, $content = null ) {
	global $post;
	$parent_link = '<a class="post-parent" href="' . get_permalink( $post->post_parent ) . '" title="' . get_the_title( $post->post_parent ) . '" rel="navigation"><span class="genericon genericon-expand rotate270"></span></a>';

	if ( empty( $post->post_parent ) )
		$parent_link = '<a class="post-parent" href="' . home_url() . '" title="' . esc_attr( get_bloginfo( 'name') ) . '" rel="home"><span class="genericon genericon-expand rotate270"></span></a>';

	return ( empty( $val ) ) ? $parent_link : $val ;
}

/**
 * Get a random image
 */
function photo_addict_random_image_src( $size = 'thumbnail' ) {
	$posts = get_posts('post_type=attachment&orderby=rand&numberposts=1');
	$random_image = wp_get_attachment_image_url( $posts[0]->ID, 'medium' );
	return $random_image;
}

function photo_addict_random_image_url( $size = 'thumbnail' ) {
	$random_image_url = '';
	if ( method_exists( 'Random_Images_Plugin', 'random_images' ) )
		$random_image_url = Random_Images_Plugin::random_images( array( 'type' => 'url' ) );

	return $random_image_url;
}

if ( ! function_exists( 'photo_addict_first_post_image_url' ) ) :
/**
 * Find a representative image for the post in this order:
 * attachment page image, featured image, first gallery shortcode image, first inline image, first attached image
 */
function photo_addict_first_post_image_url( $size = 'thumbnail' ) {
	global $post;

	if ( ! empty( $post ) ) {
		if ( empty( $id ) )
			$id = $post->ID;

		if ( ! in_array( $size, array( 'thumbnail', 'medium', 'large', 'full' ) ) )
			$size = 'thumbnail';

		switch (true) {
			// Attachment page image
			case is_attachment() :
				$attachment_image = wp_get_attachment_image_src( $id, $size );
				$my_image_url = $attachment_image[0];
				break;
			// Featured image
			case has_post_thumbnail() :
				$attachment_image = wp_get_attachment_image_src( get_post_thumbnail_id(), $size );
				$my_image_url = $attachment_image[0];
				break;
			// Scan content for the gallery shortcode
			case $parsed_shortcode_content = preg_match_all( '/\[gallery\s(.*)\]/i', get_the_content(), $matches ) :
				$matched_shortcode = isset( $matches[1][0] ) ? $matches[1][0] : '';
				$matched_shortcode_atts = shortcode_parse_atts( $matched_shortcode );
				$matched_id = is_array( $matched_shortcode_atts ) ? substr( $matched_shortcode_atts['ids'], 0, strpos( $matched_shortcode_atts['ids'], ',' ) ) : '';
				$attachment_image = wp_get_attachment_image_src( $matched_id, $size );
				$my_image_url = $attachment_image[0];
				break;
			// First attached image
			case $attachment_images = get_posts( array('post_parent' => $id, 'post_type' => 'attachment', 'posts_per_page' => 1, 'post_mime_type' => 'image') ) :
				$attachment_image_obj = array_shift( $attachment_images );
				$attachment_image = wp_get_attachment_image_src( $attachment_image_obj->ID, $size );
				$my_image_url = $attachment_image[0];
				break;
			// Scan content for images
			case $parsed_image_content = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_the_content(), $matches ) :
				$my_image_url = isset( $matches[1][0] ) ? $matches[1][0] : '';
				break;
		}
		
		if ( ! empty( $my_image_url ) )
			return $my_image_url;
	}
}
endif; // end photo_addict_first_post_image_url()

function getAverageColor($imageUrl){
	$im_fullpath = realpath($_SERVER['DOCUMENT_ROOT']) . parse_url( $imageUrl, PHP_URL_PATH );
	$image = @imagecreatefromstring(file_get_contents($im_fullpath));
	$scaled = imagescale($image, 1, 1, IMG_BICUBIC); 
	$index = imagecolorat($scaled, 0, 0);
	$rgb = imagecolorsforindex($scaled, $index); 
	$red = round(round(($rgb['red'] / 0x33)) * 0x33); 
	$green = round(round(($rgb['green'] / 0x33)) * 0x33); 
	$blue = round(round(($rgb['blue'] / 0x33)) * 0x33); 
	return sprintf('#%02X%02X%02X', $red, $green, $blue); 
 }

 function getContrastColor($hexColor) {
	// Convert hex to RGB
	$r = hexdec(substr($hexColor, 1, 2));
	$g = hexdec(substr($hexColor, 3, 2));
	$b = hexdec(substr($hexColor, 5, 2));

	// Calculate YIQ (luminance)
	$yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

	// Return black or white based on YIQ value
	return ($yiq >= 128) ? '#000000' : '#ffffff';
}

/**
 * Print color css 
 * Note: allow_url_fopen must be enabled in PHP to allow colors to be sampled from images
 */
function photo_addict_color_css( $my_color = '' ) {
	global $post;

	$my_image_url = photo_addict_first_post_image_url();

	// If no image is found, use a random attachment image
	if ( empty( $my_image_url ) || is_home() )
		$my_image_url = photo_addict_random_image_src();
		
	// Let me override the image with a color code if I want
	if ( substr( $my_color, 0, 4 ) == 'http' )
		$my_image_url = $my_color;

    $color_hex = getAverageColor($my_image_url);
    $contrast_hex = getContrastColor($color_hex);

	list($red, $green, $blue) = sscanf($color_hex, "#%02x%02x%02x");
	$color = "$red,$blue,$green";

	list($r, $g, $b) = sscanf($contrast_hex, "#%02x%02x%02x");
	$contrast = "$r,$b,$g";

	$contrasty = ( $contrast = '0,0,0' ) ? $contrasty = '255,255,255' : $contrasty = '0,0,0';

	$color_css = '<style>
		#bg-container {
			position: fixed;
			display: block;
			width: 100%;
			height: 100%;
			top: 0;
			left: 0;
			z-index: -99;
			background: url(' . $my_image_url . ') center / 1600%;
			opacity: .5;
			filter: blur(50px);
			-webkit-filter: blur(50px);
		}
		.home #bg-container { background-size: 1200%; opacity: .4; }
		.attachment #bg-container { background-size: 800%; opacity: .4; }
		#bg-container { filter:url(#blur50); } /* SVG blur for Firefox */
		body #random-images a { border: 2px solid rgba(' . $contrast . ', 0.1); }
		body {background: rgba(' . $contrasty . ', .5);}
		body, body a, body a:visited { color: rgba(' . $contrast . ', .7); }
		body a:hover, .home a.sticky:hover { color: rgba(' . $contrast . ', 1); }
		body.home a.sticky { color: rgba(' . $contrast . ', 0.8); border-bottom: 1px dotted rgba(' . $contrast . ', 0.4); }
		body div.sharedaddy div.sd-block {border-color: rgba(' . $contrast . ', 0.1); }
		body .the-content a { border-bottom: 1px dotted rgba(' . $contrast . ', 0.4); }
		body .the-content a:hover, [for="read_more"]:hover { border-color: rgba(' . $contrast . ', .9); color: rgba(' . $contrast . ', .9); }
		body .the-content .gallery-item a,
		body .the-content .gallery-item a:hover { border: none; }
		body .bypostauthor { background: rgba(#' . $contrast . ',.2);  color: rgba(' . $contrast . ',.8); }
		body input[type="text"]:focus, body input[type="email"]:focus, body input[type="password"]:focus, body textarea:focus { color: rgba(' . $contrast . ', 0.7); }
		body input[type="text"], body input[type="email"], body input[type="password"], body input[type="submit"], body textarea { color: rgba(' . $contrast . ', 0.5); border-color: rgba(' . $contrast . ', 0.8); }
		body button, html body input[type="button"], body input[type="reset"], body input[type="submit"] { border: 1px solid rgba(' . $contrast . ', 0.8); border-color: rgba(' . $contrast . ', 0.8), rgba(' . $contrast . ', 0.8), rgba(' . $contrast . ', 0.6), rgba(' . $contrast . ', 0.8); }
		::-webkit-input-placeholder { color: rgba(' . $contrast . ', 0.5); }
		:-moz-placeholder { color: rgba(' . $contrast . ', 0.7); }
		::-moz-placeholder { color: rgba(' . $contrast . ', 0.7); }
		:-ms-input-placeholder { color: rgba(' . $contrast . ', 0.7); }
	</style>';
	
	return $color_css;
}
