<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

function ju4hsuggestion_custom_post_type() {
    $labels = array(
        'name'                => _x('Suggestions', 'Post Type General Name'),
        'singular_name'       => _x('Suggestion', 'Post Type Singular Name'),
        'menu_name'           => __('Suggestions'),
        'parent_item_colon'   => __('Parent Suggestion'),
        'all_items'           => __('All Suggestions'),
        'view_item'           => __('View Suggestion'),
        'add_new_item'        => __('Add New Suggestion'),
        'add_new'             => __('Add New'),
        'edit_item'           => __('Edit Suggestion'),
        'update_item'         => __('Update Suggestion'),
        'search_items'        => __('Search Suggestion'),
        'not_found'           => __('Not Found'),
        'not_found_in_trash'  => __('Not found in Trash'),
    );

    $args = array(
        'label'               => __('Suggestions'),
        'description'         => __('Suggestions'),
        'labels'              => $labels,
        'supports'            => array('title', 'author', 'comments', 'revisions'),     
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
    );
    
    register_post_type('ju4hsuggestion', $args);
}
add_action('init', 'ju4hsuggestion_custom_post_type', 0);



function add_meta_boxes_ju4hsuggestion_callback($post) {
    add_meta_box('container_description', __('Description'), 'add_meta_box_ju4hsuggestion_description_callback', 'ju4hsuggestion', 'normal', 'low');
    add_meta_box('container_additional_fields', __('Additional fields'), 'add_meta_box_ju4hsuggestion_additional_fields_callback', 'ju4hsuggestion', 'normal', 'low');
}
add_action('add_meta_boxes_ju4hsuggestion', 'add_meta_boxes_ju4hsuggestion_callback');



function add_meta_box_ju4hsuggestion_additional_fields_callback($post) {
    global $meta_countries, $meta_types, $meta_target_group, $meta_contribute_duration, $meta_level, $meta_source;
    wp_nonce_field(basename( __FILE__ ), 'suggestion_additional_fields_nonce');
    html_admin_select_box(__('Country'), 'm_country', $meta_countries, get_post_meta($post->ID, "m_country", true));
    html_admin_select_box(__('Language'), 'm_language', $meta_countries, get_post_meta($post->ID, "m_language", true));
    html_admin_select_box(__('Duration'), 'm_duration', $meta_contribute_duration, get_post_meta($post->ID, "m_duration", true));
    html_admin_select_box(__('Type'), 'm_type', $meta_types, get_post_meta($post->ID, "m_type", true));
    html_admin_select_box(__('Level'), 'm_level', $meta_level, get_post_meta($post->ID, "m_level", true));
    html_admin_select_box(__('Source'), 'm_source', $meta_source, get_post_meta($post->ID, "m_source", true));
    html_admin_select_box(__('Targeted stakeholder group'), 'm_target_group', $meta_target_group, get_post_meta($post->ID, "m_target_group", true));
}



function add_meta_box_ju4hsuggestion_description_callback($post) {
    wp_nonce_field(basename( __FILE__ ), 'suggestion_description_nonce');
    html_admin_textarea("m_description", get_post_meta($post->ID, 'm_description', true));
}


function save_post_ju4hsuggestion_callback($post_id) {
    if (!isset($_POST['suggestion_additional_fields_nonce']) || !wp_verify_nonce($_POST['suggestion_additional_fields_nonce'], basename(__FILE__))) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array("m_country", "m_language", "m_duration", "m_type", "m_level", "m_source", "m_target_group", "m_description");
    foreach ($fields as $value) {
        if (!isset($_POST[$value])) {
            add_settings_error('missing-fields', 'missing-fields', __("You must fill all fields"), 'error');
            set_transient('settings_errors', get_settings_errors(), 30);
            return;
        }
    }
    
    foreach ($fields as $value) {
        if (isset($_REQUEST[$value])) {
            if ($_REQUEST[$value] == '') {
                delete_post_meta($post_id, $value);
            } else {
                update_post_meta($post_id, $value, sanitize_text_field($_POST[$value]));
            }
        }
    }
}
add_action('save_post_ju4hsuggestion', 'save_post_ju4hsuggestion_callback', 10, 2);



function manage_ju4hsuggestion_posts_columns_callback($columns) {
    $columns['country'] = __('Country');
    $columns['language'] = __('Language');
    $columns['type'] = __('Type');
    return $columns;
}
add_filter('manage_ju4hsuggestion_posts_columns', 'manage_ju4hsuggestion_posts_columns_callback');



function manage_ju4hsuggestion_posts_custom_column_callback($column, $post_id) {
    global $meta_countries, $meta_types, $meta_target_group, $meta_contribute_duration, $meta_level, $meta_source;
    
    if ('country' === $column) {
        $country = get_post_meta($post_id, 'm_country', true);
        if ($country != null && array_key_exists($country, $meta_countries)) {
            echo $meta_countries[$country];
        }
    }

    if ('language' === $column) {
        $language = get_post_meta($post_id, 'm_language', true);
        if ($language != null && array_key_exists($language, $meta_countries)) {
            echo $meta_countries[$language];
        }
    }
    
    if ('type' === $column) {
        $type = get_post_meta($post_id, 'm_type', true);
        if ($type != null && array_key_exists($type, $meta_types)) {
            echo $meta_types[$type];
        }
    }
}
add_action('manage_ju4hsuggestion_posts_custom_column', 'manage_ju4hsuggestion_posts_custom_column_callback', 10, 2);

