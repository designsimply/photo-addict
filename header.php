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
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/genericons.css">
<link rel="stylesheet" href="home.css">

<link href='http://fonts.googleapis.com/css?family=Open+Sans:300normal' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lato:100normal,300normal,600normal,700normal,900normal' rel='stylesheet' type='text/css'>

<link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Overlock:400,700,900' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Merriweather:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Gudea' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Raleway:100normal,200normal,300normal' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Forum' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Josefin+Slab' rel='stylesheet' type='text/css'>

</head>

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'before' ); ?>

	<header>
		<?php if ( ! is_attachment() ) { ?>
		<h1><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php } ?>
		<em><?php bloginfo( 'description' ); ?></em>
	</header>

	<div id="random-images">
		<?php
			$all_images =& get_children( 'post_parent=&post_type=attachment&post_mime_type=image&numberposts=-1&poststatus=publish' );
			$images = array_rand( $all_images, 22 );
			designsimply_tonesque_css( wp_get_attachment_image_src( $images[0], 'thumbnail' )[0] );

			if ( ! empty($images) ) { 
				for ( $i = 0; $i < 9; $i++ ) { 
				$random = array_rand($all_images);
				//echo ' <a href="' . get_permalink($random) . '#image">';
				echo ' <a href="' . get_permalink($random) . '">';
				echo wp_get_attachment_image( $random, 'thumbnail' );
				echo '</a>';
				} 
			}
		?>
	</div><!-- #random-images -->

	</header>
