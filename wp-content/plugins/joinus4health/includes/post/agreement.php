<?php

$meta_agreement_types = [
    'terms_of_use' => 'Terms of use',
    'privacy_statement' => 'Privacy statement'
];

$meta_agreement_pages = [
    'terms_of_use' => 'terms-of-use',
    'privacy_statement' => 'privacy-policy'
];

/**
 * Creates custom post type 'agreement'
 */
function ju4hagreement_custom_post_type() {
    $labels = array(
        'name'                => _x('Agreements', 'Post Type General Name'),
        'singular_name'       => _x('Agreement', 'Post Type Singular Name'),
        'menu_name'           => __('Agreements'),
        'parent_item_colon'   => __('Parent Agreement'),
        'all_items'           => __('All Agreements'),
        'view_item'           => __('View Agreement'),
        'add_new_item'        => __('Add New Agreement'),
        'add_new'             => __('Add New'),
        'edit_item'           => __('Edit Agreement'),
        'update_item'         => __('Update Agreement'),
        'search_items'        => __('Search Agreement'),
        'not_found'           => __('Not Found'),
        'not_found_in_trash'  => __('Not found in Trash'),
    );

    $args = array(
        'label'               => __('Agreements'),
        'description'         => __('Agreements'),
        'labels'              => $labels,
        'supports'            => array('title'),     
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'capability_type'     => 'ju4hagreement',
        'map_meta_cap'        => true,
        'capabilities'        => generate_capabilites_array('ju4hagreement'),
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
    
    register_post_type('ju4hagreement', $args);
}
add_action('init', 'ju4hagreement_custom_post_type', 0);

function add_meta_boxes_ju4hagreement_callback($post) {
    add_meta_box('container_additional_fields', __('Additional fields'), 'add_meta_box_ju4hagreement_additional_fields_callback', 'ju4hagreement', 'normal', 'low');
}
add_action('add_meta_boxes_ju4hagreement', 'add_meta_boxes_ju4hagreement_callback');

function add_meta_box_ju4hagreement_additional_fields_callback($post) {
    global $meta_agreement_types;
    wp_nonce_field(basename( __FILE__ ), 'agreement_additional_fields_nonce');
    html_admin_select_box(__('Agreement type'), 'm_agreement_type', $meta_agreement_types, get_post_meta($post->ID, "m_agreement_type", true), false);
}

function save_post_ju4hagreement_callback($post_id) {
    global $meta_agreement_types;
    
    if (!isset($_POST['agreement_additional_fields_nonce']) || !wp_verify_nonce($_POST['agreement_additional_fields_nonce'], basename(__FILE__))) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array('m_agreement_type');
    
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
add_action('save_post_ju4hagreement', 'save_post_ju4hagreement_callback', 10, 2);
