<?php
/**
 * designsimply functions and definitions
 *
 * @package designsimply
 * @since designsimply 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since designsimply 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'designsimply_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since designsimply 1.0
 */
function designsimply_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	//require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * Custom Theme Options
	 */
	//require( get_template_directory() . '/inc/theme-options/theme-options.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on designsimply, use a find and replace
	 * to change 'designsimply' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'designsimply', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Add support for all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	/*
	function swb_exclude_some_post_formats( $query ) {
	
		if( $query->is_main_query() && $query->is_home() ) {
			$tax_query = array( array( 
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array( 'post-format-status', 'post-format-image' , 'post-format-gallery' ),
				'operator' => 'NOT IN',
			) );
			$query->set( 'tax_query', $tax_query );
		}
	 
	}
	add_action( 'pre_get_posts', 'swb_exclude_some_post_formats' );
	*/

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'designsimply' ),
	) );

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', ) );
}
endif; // designsimply_setup
add_action( 'after_setup_theme', 'designsimply_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since designsimply 1.0
 */
function designsimply_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'designsimply' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
}
add_action( 'widgets_init', 'designsimply_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function designsimply_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );

	//wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );

	/* translators: If there are characters in your language that are not supported
	   by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'designsimply' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language, translate
		   this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'designsimply' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:400italic,700italic,400,700',
			'subset' => $subsets,
		);
		wp_enqueue_style( 'designsimply-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}
}
add_action( 'wp_enqueue_scripts', 'designsimply_scripts' );

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );

add_action('wp_head', 'show_template');
function show_template() {
	global $template;
	echo "<!-- >>>>>>>>>> $template <<<<<<<<<< -->
	";
}
add_filter( 'got_rewrite', '__return_true' );

add_filter('previous_image_link', 'designsimply_previous_image_link',10,3);
/**
 * Filter to add a link back to the parent on the last image attachment page
 **/
function designsimply_previous_image_link($val, $attr, $content = null)
{
	global $post;

	if ( '' == $val ) :
		$output = __( '<a class="post-parent" href="' . get_permalink( $post->post_parent ) . '" title="' . get_the_title( $post->post_parent ) . '" rel="gallery"><div class="genericon genericon-expand rotate90"></div></a>', 'designsimply' );
	else : 
		$output = $val;
	endif;
	return $output;
}

add_filter('next_image_link', 'designsimply_next_image_link',10,3);
/**
 * Filter to add a link back to the parent on the last image attachment page
 **/
function designsimply_next_image_link($val, $attr, $content = null)
{
	global $post;

	if ( '' == $val ) :
		$output = __( '<a class="post-parent" href="' . get_permalink( $post->post_parent ) . '" title="' . get_the_title( $post->post_parent ) . '" rel="gallery"><div class="genericon genericon-expand rotate270"></div></a>', 'designsimply' );
	else : 
		$output = $val;
	endif;
	return $output;
}

/**
 * Get a random image
 */
function get_random_image_src( $size = 'thumbnail' ) {
	$args = array(
		'post_type' => 'attachment',
		'post_mime_type' =>'image',
		'post_status' => 'inherit',
		'posts_per_page' => 1,
        'orderby' => 'rand'
	);
	$query_images = new WP_Query( $args );
	//debugs
	//echo $query_images->post->ID;
	//echo '<img src="'.$query_images->post->guid.'">';
	//echo '<pre>'; var_dump( $query_images ); echo '</pre>';
	$random_image = wp_get_attachment_image_src ( $query_images->post->ID, $size);
	return $random_image[0];
}

if ( ! function_exists( 'designsimply_tonesque_css' ) ) :
/**
 * Print Tonesque css for image posts
 */
function designsimply_tonesque_css( $my_color = '' ) {
	global $post;

	if ( ! class_exists( 'Tonesque' ) )
		include_once(  TEMPLATEPATH . '/inc/tonesque.php' );

	$image_content = function_exists( 'get_the_post_format_image' ) ? get_the_post_format_image( 'large', $post ) : get_the_content();
	$image_content = wp_attachment_is_image() ? wp_get_attachment_image( $post_id, 'large' ) : $image_content;
	$post_images   = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $image_content, $matches );
	$first_image   = isset( $matches[1][0] ) ? $matches[1][0] : '';
	//echo '<br>the first_image'.$first_image;
	//echo '<br><pre>my_color'.$my_color.'</pre> asdf';
	if ( substr( $my_color, 0, 4 ) == 'http' ) { $first_image = $my_color; }

	if ( ! $first_image ) : // If there's no image, use a random attachment image
		$first_image = get_random_image_src( 'thumbnail' );
	endif;

	$tonesque = new Tonesque( $first_image );
	$color = $tonesque->color();
	$contrast = $tonesque->contrast();
	$id = get_the_ID();
	$postid = '.postid-' . $id;
	echo '<style>
		#bg-container { 
			position: fixed;
			display: block;
			width: 100%;
			height: 100%;
			top: 0;
			left: 0;
			z-index: -1;
			background: url(' . $first_image . ') center / 2000%;
			opacity: .2;
			-webkit-filter: blur(50px);
			filter: blur(50px);
		}
		.home #bg-container, .attachment #bg-container { opacity: .4 }
		#bg-container { filter:url(#blur50); } /* SVG blur for Firefox */
		body #random-images a { border: 2px solid rgba(' . $contrast . ', 0.1); }
		body {background: #' . $color . ';}
		body,
		body a,
		body a:visited { color: rgba(' . $contrast . ', 0.7); }
		body a:hover { color: rgba(' . $contrast . ', 1); }
		body div.sharedaddy div.sd-block {border-color: rgba(' . $contrast . ', 0.1); }
		body .the-content a { border-bottom: 1px solid rgba(' . $contrast . ', 0.4); }
		body .the-content a:hover { border-color: rgba(' . $contrast . ', .9); color: rgba(' . $contrast . ', .9); }
		body .the-content .gallery-item a,
		body .the-content .gallery-item a:hover { border: none; }
		body input[type=text]:focus, body input[type=email]:focus, body textarea:focus { color: rgba(' . $contrast . ', 0.7); }
		body input[type=text], body input[type=email], body textarea { color: rgba(' . $contrast . ', 0.5); border-color: rgba(' . $contrast . ', 0.8); }
		body button, html body input[type="button"], body input[type="reset"], body input[type="submit"] { border: 1px solid rgba(' . $contrast . ', 0.8); border-color: rgba(' . $contrast . ', 0.8), rgba(' . $contrast . ', 0.8), rgba(' . $contrast . ', 0.6), rgba(' . $contrast . ', 0.8); }
	</style>';
}
endif; // ends check for designsimply_tonesque_css()

