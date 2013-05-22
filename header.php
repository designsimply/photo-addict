<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package designsimply
 * @since designsimply 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'designsimply' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300normal' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lato:100normal,300normal,600normal,700normal,900normal' rel='stylesheet' type='text/css'>
<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/linear-regular" rel="stylesheet" type="text/css"/>

<link href='http://fonts.googleapis.com/css?family=Overlock:400,700,900' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Gudea' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Raleway:100normal,200normal,300normal' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Forum' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Josefin+Slab' rel='stylesheet' type='text/css'>
<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/open-baskerville" rel="stylesheet" type="text/css"/> 
<link rel="stylesheet" href="http://s0.wordpress.com/i/noticons/noticons.css">
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/genericons.css">


<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action( 'before' ); ?>
	<header role="banner">
		<div id="site-title">
			<h1><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"
				 class="rotate"
				><?php bloginfo( 'name' ); ?></a></h1>
			<?php if ( is_home() ) { ?>
				<h2><?php bloginfo( 'description' ); ?></h2>
			<?php } ?>
		</div>

		<a name="image"></a>
		<div id="random-images">
			<ul>
			<?php
				$all_images =& get_children( 'post_parent=&post_type=attachment&post_mime_type=image&numberposts=-1&poststatus=publish' );
				$images = array_rand( $all_images, 22 );

				if ( ! empty($images) ) { 
					for ( $i = 0; $i < 9; $i++ ) { 
					$random = array_rand($all_images);
					echo '<li><a href="' . get_permalink($random) . '#image">';
					echo wp_get_attachment_image( $random, 'thumbnail' );
					echo '</a></li> ';
					} 
				}
			?>
			</ul>
        </div><!-- #random-images -->
	</header>

	<div id="main">