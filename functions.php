<?php

//
//  Custom Child Theme Functions
//

// I've included a "commented out" sample function below that'll add a home link to your menu
// More ideas can be found on "A Guide To Customizing The Thematic Theme Framework" 
// http://themeshaper.com/thematic-for-wordpress/guide-customizing-thematic-theme-framework/

// Adds a home link to your menu
// http://codex.wordpress.org/Template_Tags/wp_page_menu
//function childtheme_menu_args($args) {
//    $args = array(
//        'show_home' => 'Home',
//        'sort_column' => 'menu_order',
//        'menu_class' => 'menu',
//        'echo' => true
//    );
//	return $args;
//}
//add_filter('wp_page_menu_args','childtheme_menu_args');

// Unleash the power of Thematic's dynamic classes
// 
// define('THEMATIC_COMPATIBLE_BODY_CLASS', true);
// define('THEMATIC_COMPATIBLE_POST_CLASS', true);

// Unleash the power of Thematic's comment form
//
// define('THEMATIC_COMPATIBLE_COMMENT_FORM', true);

// Unleash the power of Thematic's feed link functions
//
// define('THEMATIC_COMPATIBLE_FEEDLINKS', true);

require_once('lib/utilities.php');
require_once('lib/functionality.php');

/**
 * ========================= <head> mods =========================
 */
add_action('wp_head', 'skate_favicon');
add_action('wp_head', 'skate_iefix'); // IE CSS fixes
if (!is_admin()) {
    remove_action('wp_head', 'rsd_link'); // kill the RSD link
//    remove_action('wp_head', 'wp_generator'); // kill the wordpress version number for security reasons
    remove_action('wp_head', 'wlwmanifest_link'); // kill the WLW link
    remove_action('wp_head', 'index_rel_link'); // kill the index link
    remove_action('wp_head', 'parent_post_rel_link_wp_head', 10, 0); // kill the prev link
    remove_action('wp_head', 'start_post_rel_link_wp_head', 10, 0); // kill the start link
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); // kill adjacent post links
    remove_action('wp_head', 'feed_links', 2); // kill post and comment feeds
    remove_action('wp_head', 'feed_links_extra', 3); // kill category, author, and other extra feeds
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );
}

/**
 * ========================= Header mods =========================
 */
add_action('init', 'skate_clean_div_header');
add_action('thematic_header','childtheme_override_brandingclose',7);



/**
 * ========================= Content mods =========================
 */

add_action('template_redirect', 'skate_add_featured_image_abovepost'); // show featured image above post

add_filter('thematic_page_title', '__return_false'); // removes the page title e.g. Category Archives: News
function skate_change_post_title() {
    if ( is_home() || is_front_page() )
        add_filter('thematic_postheader_posttitle', 'skate_homepage_posttitle');
    else
        add_filter('thematic_postheader_posttitle', 'skate_posttile');
}
add_action('template_redirect','skate_change_post_title');

add_filter('thematic_postheader_postmeta', '__return_false'); // removes post header post meta
add_filter('thematic_postfooter', '__return_false'); // removes post footer meta

add_action('template_redirect','skate_remove_comments');

add_action('template_redirect', 'skate_remove_post_navigation');

/**
 * This is an override function, called withouth action add_action('thematic_indexloop', 'thematic_index_loop');
 * Queries for last 4 posts in category news and displays $thematic_content_length == 'excerpt' for thematic_content()
 */
function childtheme_override_index_loop() {
    // query for posts in category news
    if (term_exists('news', 'category')) {
        $args = array(  'post_status' => 'publish',
                        'post_type' => 'post',
                        'category_name' => 'news',
                        'posts_per_page' => 4,
                        'orderby' => 'date',
                        'order' => 'DESC' );
        query_posts($args);
    }
    while ( have_posts() ) {
            the_post();
            $external_link = nt_get_custom_field_by_key('external-link'); // set var for Read more link
            thematic_abovepost(); ?>
            <div id="post-<?php the_ID();
                echo '" ';
                if (!(THEMATIC_COMPATIBLE_POST_CLASS)) {
                    post_class();
                    echo '>';
                } else {
                    echo 'class="';
                    thematic_post_class();
                    echo '">';
                }
                thematic_postheader(); ?>
                <div class="entry-content">
                <?php thematic_content(); ?>
                <?php if( !empty($external_link) ) { ?>
                    <span class="r-arrow"><a class="moretag" href="<?php echo $external_link; ?>" target="_blank">read more</a></span>
                <?php } else { ?>
                    <span class="r-arrow"><a class="moretag" href="<?php the_permalink(); ?>">read more</a></span>
                <?php } ?>
            </div><!-- .entry-content -->
        </div><!-- #post -->
<?php
    } // end: while
    wp_reset_query(); // reset custom query
}

add_action('thematic_abovefooter', 'skate_add_bottom_tout'); // adds the bottom tout that hosts: videos, page links, sponsors banner
add_action('template_redirect','skate_remove_page_comments');

/**
 * ========================= Google Maps API on Contact Us page =========================
 */
add_action('template_redirect', 'skate_load_gmaps');

/**
 * ========================= Contact Form 7 =========================
 */
if ( function_exists('wpcf7_contact_form') ) { // If the Contact Form 7 Exists, do the tweaks
    add_action( 'template_redirect' , 'skate_wpcf7_css_and_scripts' );
}



/**
 * ========================= Footer mods =========================
 */

/**
 * ========================= Sponsors =========================
 */
add_action('thematic_abovefooter', 'skate_add_sponsors_widget_area');


///////////////////////////////////////////////////////
//          ACCESS SURVEY PAGE ONLY
///////////////////////////////////////////////////////
function skate_private() {
    if( !current_user_can('administrator') && !is_page('summer-camp-questionnaire') ) {
//        wp_redirect('http://localhost/sites/sk8park/404'); // will triger a 404
//       wp_redirect('http://survey.cjskateboardcamp.com/404'); // will triger a 404
    wp_redirect('http://survey.cjskateboardcamp.com/camps/summer-camp-questionnaire/');
    }
}
//add_action('template_redirect','skate_private');
?>
