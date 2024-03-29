<!DOCTYPE html> 
<html <?php language_attributes(); ?>>
<head>
<?php echo photo_addict_color_css(); ?>
<title><?php
	global $page, $paged;
	wp_title( '-', true, 'right' );
	bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " - $site_description";
	if ( $paged >= 2 || $page >= 2 )
		echo ' - ' . sprintf( __( 'Page %s', 'photo-addict' ), max( $paged, $page ) );
	?></title>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<?php if ( method_exists( 'Random_Images_Plugin', 'random_images' ) && ( is_attachment() ) ) : $random_images = Random_Images_Plugin::random_images( array( 'type' => 'html', 'size' => 'thumbnail', 'total' => 9 ) ); ?>
<body <?php body_class('random-images'); ?>>
<?php else : ?>
	<body <?php body_class(); ?>>
<?php endif; ?>

<?php do_action( 'before' ); ?>

	<div id="bg-container"></div>
	<div id="wrapper">
	<?php if ( is_home() ) : ?>
	<header>
		<h1><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	</header>
	<?php else : ?>
	<header>
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) { ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		</a>
		<?php } // if ( ! empty( $header_image ) ) ?>
	</header>
	<?php endif; ?>

<?php // if ( isset( $random_images ) ) { echo $random_images; } ?>
