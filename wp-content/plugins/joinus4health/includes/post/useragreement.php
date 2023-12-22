<?php

/**
 * Creates custom post type 'user agreement'
 */
function ju4huseragreement_custom_post_type() {
    $labels = array(
        'name'                => _x('User Agreements', 'Post Type General Name'),
        'singular_name'       => _x('User Agreement', 'Post Type Singular Name'),
        'menu_name'           => __('User Agreements'),
        'parent_item_colon'   => __('Parent User Agreement'),
        'all_items'           => __('All User Agreements'),
        'view_item'           => __('View User Agreement'),
        'add_new_item'        => __('Add New User Agreement'),
        'add_new'             => __('Add New'),
        'edit_item'           => __('Edit User Agreement'),
        'update_item'         => __('Update User Agreement'),
        'search_items'        => __('Search User Agreement'),
        'not_found'           => __('Not Found'),
        'not_found_in_trash'  => __('Not found in Trash'),
    );

    $args = array(
        'label'               => __('User Agreements'),
        'description'         => __('User Agreements'),
        'labels'              => $labels,
        'supports'            => array(),     
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'capability_type'     => 'ju4huseragreement',
        'map_meta_cap'        => true,
        'capabilities'        => generate_capabilites_array('ju4huseragreement'),
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
    
    register_post_type('ju4huseragreement', $args);
}
add_action('init', 'ju4huseragreement_custom_post_type', 0);

function manage_ju4huseragreement_posts_columns_callback($columns) {
    $columns['user'] = __('User');
    $columns['userid'] = __('User ID');
    $columns['consent'] = __('Consent');
    $columns['consentid'] = __('Consent ID');
    $columns['consentvalue'] = __('Consent yes/no');
    unset($columns['cb']);
    unset($columns['title']);
    unset($columns['author']);
    unset($columns['comments']);
    return $columns;
}
add_filter('manage_ju4huseragreement_posts_columns', 'manage_ju4huseragreement_posts_columns_callback');

function manage_ju4huseragreement_posts_custom_column_callback($column, $post_id) {
    global $wpdb;
    
    if ('userid' === $column) {
        $user_id = get_post_meta($post_id, 'm_consent_user_id', true);
        echo '#'.$user_id;
    }
    
    if ('user' === $column) {
        $user_id = get_post_meta($post_id, 'm_consent_user_id', true);
        $result = get_user_by('id', $user_id);
        
        if ($result) {
            echo $result->user_login;
        } else {
            echo '<i>user not exists</i>';
        }
    }
    
    if ('consent' === $column) {
        $consent_id = get_post_meta($post_id, 'm_consent_id', true);
        $post_consent = get_post($consent_id);
        echo $post_consent->post_title;
    }
    
    if ('consentid' === $column) {
        echo '#'.get_post_meta($post_id, 'm_consent_id', true);
    }
    
    if ('consentvalue' === $column) {
        echo get_post_meta($post_id, 'm_post_value', true);
    }
}
add_action('manage_ju4huseragreement_posts_custom_column', 'manage_ju4huseragreement_posts_custom_column_callback', 10, 2);
