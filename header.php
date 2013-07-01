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
		<em><?php bloginfo( 'description' ); ?></em>
	</header>
	<?php endif; ?>

	<?php if ( is_home() || is_attachment() ) { ?>
	<div id="random-images">
		<?php
			$all_images =& get_children( 'post_parent=&post_type=attachment&post_mime_type=image&numberposts=-1&poststatus=publish' );
			$images = array_rand( $all_images, 22 );
			designsimply_tonesque_css( wp_get_attachment_image_src( $images[0], 'thumbnail' )[0] );

			$image_num = 11;
			//if ( is_home() ) { $image_num = 10; }

			if ( ! empty($images) ) {
				for ( $i = 0; $i < $image_num; $i++ ) {
				$random = array_rand($all_images);
				//echo ' <a href="' . get_permalink($random) . '#image">';
				echo ' <a href="' . get_permalink($random) . '"';
				if ( $i==0 ) { echo ' class="first-random-image"'; }
				echo '>';
				echo wp_get_attachment_image( $random, 'thumbnail' );
				echo '</a>';
				}
			}
		?>
	</div><!-- #random-images -->
	<?php } ?>
