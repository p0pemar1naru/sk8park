<?php
/**
 * ========================= Head mods =========================
 */

/**
 * Adds favicon into head
 */
function skate_favicon() { ?>
    <link rel="shortcut icon" href="<?php echo bloginfo('stylesheet_directory') ?>/favicon.ico" type="image/x-icon" />
<?php }

/**
 * IE CSS fix 
 */
function skate_iefix() { ?>
<!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo bloginfo('stylesheet_directory'); ?>/css/ie.css" />
<![endif]-->
<?php }

/**
 * ========================= Header mods =========================
 */

/**
 * Removes from div#header - blogtitle, blogdescription
 */
function skate_clean_div_header() {
    remove_action('thematic_header','thematic_blogtitle',3);
    remove_action('thematic_header','thematic_blogdescription',5);
}
/**
 * Overrides div#branding before the closing div
 * Adds logo
 */
function childtheme_override_brandingclose() { ?>
    <a href="<?php echo home_url('/'); ?>" title="<?php bloginfo('name'); ?>"><h1 id="skate-logo"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/cjsk8_logo.png" alt="" width="125" height="119" /></h1></a>
    </div><!-- end: #branding -->
<?php }


/**
 * ========================= Content mods =========================
 */

function skate_print_datepicker_js() { ?>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('input[name="party-date"]').datepicker({
                        inline: true,
                        numberOfMonths: 2,
                        dateFormat: "DD, M d, yy"
            });
        });
    </script>
<?php }

/**
 * On any page but "Contact Us" and "Birthday Parties":
 * Removes the default Contact Form 7 Stylesheet
 * Removes Contact Form 7 bottom scripts
 * 
 * On page "Birthday Parties":
 * load jqueryui datepicker
 */
function skate_wpcf7_css_and_scripts() {
    if ( !is_admin() && WPCF7_LOAD_JS && !is_page( array('contact-us', 'birthday-parties') ) ) {
        remove_action( 'wp_enqueue_scripts', 'wpcf7_enqueue_styles' );
        remove_action( 'wp_enqueue_scripts', 'wpcf7_enqueue_scripts' );
    }
    if ( !is_admin() && WPCF7_LOAD_JS && is_page('birthday-parties') ) {
//        wp_register_style( 'jqueryui_datepicker',  get_bloginfo('stylesheet_directory') . '/css/smoothness/jquery-ui-1.8.21.custom.css' );
        wp_register_style( 'jqueryui_datepicker',  get_bloginfo('stylesheet_directory') . '/css/blitzer/jquery-ui-1.8.21.custom.css' );
        wp_enqueue_style( 'jqueryui_datepicker' );
        wp_register_script( 'jqueryui_datepicker',  get_bloginfo('stylesheet_directory') . '/js/jquery-ui-1.8.21.custom.min.js' );
        wp_enqueue_script( 'jqueryui_datepicker' );
        
        add_action('thematic_after', 'skate_print_datepicker_js');
    }
}

/**
 * Google Maps API on Contact Us page
 */
function skate_do_mapdiv() {
    ?><h1 class="entry-title"><span class="fr">&nbsp;</span></h1><div id="map"></div><?php    
}
function skate_load_gmaps() {
    // load gmaps api on Contact Us page
    if( !is_admin() && is_page('contact-us') ) {
        wp_register_script( 'Gmaps', 'http://maps.google.com/maps/api/js?sensor=false', array(), false, true );
        wp_enqueue_script ( 'Gmaps' );
        wp_register_script( 'maps_script',  get_bloginfo('stylesheet_directory') . '/js/gmaps.js', array( 'Gmaps' ), '1.0', true );
        wp_enqueue_script ( 'maps_script' );
        add_action('thematic_abovepost', 'skate_do_mapdiv');
    }
}

/**
 * Show featured image above post 
 */
function skate_do_featured_image_abovepost() { //global $post;
    if ( has_post_thumbnail( $post->ID ) ) {
        $skate_top_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
        echo sprintf('<img src="%s" alt="" width="636" height="408" style="margin-bottom:4px;" />', $skate_top_image_url[0]);
    }
}
function skate_add_featured_image_abovepost() {
    // load gmaps api on Contact Us page
    if( is_single() || is_page() ) {
        add_action('thematic_abovepost', 'skate_do_featured_image_abovepost');
    }
}

/**
 * Removes previous/next links fron Post page 
 */
function skate_remove_post_navigation() {
    if ( is_single() ) {
        remove_action('thematic_navigation_above', 'thematic_nav_above', 2);
        remove_action('thematic_navigation_below', 'thematic_nav_below', 2);
    }
}

/**
 * Removes comments site-wide 
 */
function skate_remove_comments(){
    remove_action('thematic_comments_template','thematic_include_comments',5);
}

/**
 * Modifies the post title markup and link
 * @param string $posttitle The post title
 * @return string The new post title w added markup
 */
function skate_posttile($posttitle) {
    if (is_single() || is_page()) {
        $posttitle = '<h1 class="entry-title YOYO"><span class="fr">' . get_the_title() . "</span></h1>\n";
    } elseif (is_404()) {
        $posttitle = '<h1 class="entry-title">' . __('Not Found', 'thematic') . "</h1>\n";
    } elseif ( is_category('news') ) {
        $external_link = nt_get_custom_field_by_key('external-link');
        if( !empty($external_link) ) {
            $posttitle = '<h2 class="entry-title TOTO"><a href="' . $external_link . '" title="" target="_blank">';
            $posttitle .= get_the_title();
            $posttitle .= "</a></h2>\n";
        } else {
            $posttitle = '<h2 class="entry-title MOMO"><a href="';
            $posttitle .= apply_filters('the_permalink', get_permalink());
            $posttitle .= '" title="';
            $posttitle .= __('Permalink to ', 'thematic') . the_title_attribute('echo=0');
            $posttitle .= '" rel="bookmark">';
            $posttitle .= get_the_title();
            $posttitle .= "</a></h2>\n";
        }
    } else {
        $posttitle = '<h2 class="entry-title MOMO"><a href="';
        $posttitle .= apply_filters('the_permalink', get_permalink());
        $posttitle .= '" title="';
        $posttitle .= __('Permalink to ', 'thematic') . the_title_attribute('echo=0');
        $posttitle .= '" rel="bookmark">';
        $posttitle .= get_the_title();
        $posttitle .= "</a></h2>\n";
    }

    return $posttitle;
}

/**
 * Changes post title link in the Front Page loop to be an external link if 'external-link' custom field is set
 * @param string $posttitle
 * @return string 
 */
function skate_homepage_posttitle($posttitle) {
    $external_link = nt_get_custom_field_by_key('external-link');
    if( !empty($external_link) ) {
        $posttitle = '<h2 class="entry-title TOTO"><a href="' . $external_link . '" title="" target="_blank">';
        $posttitle .= get_the_title();
        $posttitle .= "</a></h2>\n";
    } else {
        $posttitle = '<h2 class="entry-title MOMO"><a href="';
        $posttitle .= apply_filters('the_permalink', get_permalink());
        $posttitle .= '" title="';
        $posttitle .= __('Permalink to ', 'thematic') . the_title_attribute('echo=0');
        $posttitle .= '" rel="bookmark">';
        $posttitle .= get_the_title();
        $posttitle .= "</a></h2>\n";
    }
        
    return $posttitle;
}

/**
 * Adds the bottom tout that hosts: videos, page links
 */
function skate_add_bottom_tout() {
    if( !is_404() && !is_page('summer-camp-questionnaire') ) {
?>
    <div id="bottom-tout" class="clr">
        <?php if( function_exists('syg_display_gallery') ) { ?>
            <div id="bottom-videos">
                <h2 class="entry-title blocktitle">Top Videos</h2>
                <div id="youtube-videos" class="fl">
                    <?php syg_display_gallery(); ?>
                </div>
<!--                <span class="fr">Submit your video and qualify to win a CJ's deck. <a href="#" target="_blank" title="Submit your Video">Here is how to enter</a></span>-->
            </div>
        <?php } ?>
        <div id="bottom-links" class="clr">
            <ul class="sbp">
                <li class="left">
                    <h2 class="entry-title">Skate<span class="green">Camp</span></h2>
                    <a href="https://www.cjskateboardcamp.com/" target="_blank" title="Skate Camp">
                        <img src="<?php echo home_url('/'); ?>wp-content/uploads/2012/06/skate-camp.jpg" alt="Skate Camp" width="310" height="197" />
                    </a>
                </li>
                <li class="middle">
                    <h2 class="entry-title">Birthday<span class="green">Parties</span></h2>
                    <a href="<?php echo home_url('/'); ?>camps/birthday-parties" target="_self" title="Birthday Parties">
                        <img src="<?php echo home_url('/'); ?>wp-content/uploads/2012/06/birthday-parties.jpg" alt="Birthday Parties" width="310" height="197" />
                    </a>
                </li>
                <li class="right">
                    <h2 class="entry-title">Pro<span class="green">Shop</span></h2>
                    <a href="<?php echo home_url('/'); ?>proshop" target="_self" title="Pro Shop">
                        <img src="<?php echo home_url('/'); ?>wp-content/uploads/2012/06/pro-shop.jpg" alt="Pro Shop" width="310" height="197" />
                    </a>
                </li>
            </ul>
        </div>
    </div>
<?php
    } // end: if
}

/**
 * Adds the Sponsors widgetized area that hosts: sponsors banner
 */
function skate_add_sponsors_widget_area() {
    if( !is_404() && !is_page('summer-camp-questionnaire') ) {
?>
    <div id="bottom-banner" class="clr">
        <img src="<?php bloginfo('stylesheet_directory'); ?>/images/sponsors.png" alt="" width="23" height="75" />
        <ul class="sponsors">
            <?php dynamic_sidebar('Sponsors'); ?>
        </ul>
    </div>
<?php }
}

function skate_remove_page_comments() {
    if(is_page()) {
        remove_action('thematic_comments_template','thematic_include_comments',5);
    }
}
