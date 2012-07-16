<?php
//define('THEMES_DIR', get_template_directory_uri());
//define('MY_THEMES_DIR', get_template_directory());
//require_once(MY_THEMES_DIR . '/library/extensions/widgets.php');


// CSS markup before the widget
function wbtt_before_widget() {
	$content = '<li id="%1$s" class="widgetcontainer %2$s">';
	return apply_filters('wbtt_before_widget', $content);
}

// CSS markup after the widget
function wbtt_after_widget() {
	$content = '</li>';
	return apply_filters('wbtt_after_widget', $content);
}

// CSS markup before the widget title
function wbtt_before_title() {
	$content = "<h3 class=\"widgettitle\">";
	return apply_filters('wbtt_before_title', $content);
}

// CSS markup after the widget title
function wbtt_after_title() {
	$content = "</h3>\n";
	return apply_filters('wbtt_after_title', $content);
}


/**
 * Create aside/widgetized area for News section
 */
if ( function_exists('register_sidebars') ) {

    $skate_widgetized_areas = array(
        'Sponsors' => array(
            'admin_menu_order' => 250,
            'args' => array (
                'name' => 'Sponsors',
                'id' => 'sponsors',
                'description' => __('The Sponsors widget area, showed at the bottom of the page.', 'thematic'),
                'before_widget' => wbtt_before_widget(),
                'after_widget' => wbtt_after_widget(),
                'before_title' => wbtt_before_title(),
                'after_title' => wbtt_after_title(),
                ),
            'action_hook'	=> 'widget_area_sponsors',
            'function'		=> 'skate_sponsors',
            'priority'		=> 10
        )
    );

    apply_filters('thematic_widgetized_areas', $thematic_widgetized_areas);

    foreach ($skate_widgetized_areas as $key => $value) {
        register_sidebar($skate_widgetized_areas[$key]['args']);
    }

}

/**
 * Prints the 1st instance of the meta_key identified by $fieldname associated with the current post.
 * 
 * @param string $fieldname The name (meta_key) of custom field from the wp_postmeta table.
 * @return string Returns the first value of the specified key (not in an array). See get_post_meta() for more details.
 */
function nt_get_custom_field_by_key($fieldname) {
    // the_ID() function won't work because it *prints* its output
    $post_id = get_the_ID();
    $custom_field_value = get_post_meta($post_id, $fieldname, true);
    
    return $custom_field_value;
}