<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<title><?php
	global $page, $paged;
	wp_title( '-', true, 'right' );
	bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " - $site_description";
	if ( $paged >= 2 || $page >= 2 )
		echo ' - ' . sprintf( __( 'Page %s', 'designsimply' ), max( $paged, $page ) );
	?></title>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<meta name="description" content="<?php echo $site_description; ?>" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/fonts/genericons.css">
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/fonts/open-sans.css">
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/fonts/lato.css">
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/fonts/overlock.css">
</head>

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'before' ); ?>

	<div id="bg-container"></div>
	<div id="wrapper">
	<?php if ( is_home() ) : ?>
	<header>
		<h1><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	</header>
	<?php endif; ?>

	<?php 
		if ( method_exists( 'Random_Images_Plugin', 'random_images' ) && ( is_home() || is_attachment() ) )
			echo Random_Images_Plugin::random_images( array( 'size' => 'thumbnail', 'total' => 9 ) );
	?>
