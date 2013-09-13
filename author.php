<?php
/**
 * This is a fairly simple author bio page that displays the author's
 * display name, Gravatar, description, website, and latest posts.
 *
 * @package photo-addict
 * @since photo-addict 1.0
 */
get_header();
echo photo_addict_tonesque_css();

$current_user = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$logged_in_user_id = get_current_user_id();
?>

<h2>About <?php echo $current_user->display_name; ?></h2>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <nav>
    <span class="next"><?php previous_post_link( '%link', __( '<span class="genericon genericon-expand"></span>', 'photo-addict' ) ); ?></span>
    <span class="previous"><?php next_post_link( '%link', __( '<span class="genericon genericon-collapse"></span>', 'photo-addict' ) ); ?></span>
    </nav>

    <div class="the-content">
        <p><a href="<?php echo $current_user->user_url; ?>" class="alignleft gravatar"><?php echo get_avatar( $current_user->user_email, 128 ); ?></a><?php echo $current_user->user_description; ?></p>

        <h2>Latest Posts</h2>

        <?php if ( have_posts() ) :
        echo '<ul>';
        while ( have_posts() ) : the_post(); ?>
            <li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></li>
    
        <?php 
        endwhile;
        echo '</ul>';
        endif;
        ?>
        <?php photo_addict_content_nav( 'nav-below' ); ?>

    </div><!-- .the-content -->

    <div class="meta">
        <?php if ( $current_user->ID === $logged_in_user_id )
            echo '<a href="' . admin_url( 'profile.php' ) . '"><span class="genericon-22 genericon-edit rotate270"></span></a>';

        ?>
    </div><!-- .meta -->

    <div class="site-title">
        <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="post-parent" rel="home"><?php bloginfo( 'name' ); ?></a>
    </div><!-- .site-title -->

</article><!-- #post-<?php the_ID(); ?> -->

<?php get_footer();?>
