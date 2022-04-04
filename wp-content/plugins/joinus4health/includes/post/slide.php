<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Creates custom post type 'slide'
 */
function ju4hslide_custom_post_type() {
    $labels = array(
        'name'                => _x('Slides', 'Post Type General Name'),
        'singular_name'       => _x('Slide', 'Post Type Singular Name'),
        'menu_name'           => __('Slides'),
        'parent_item_colon'   => __('Parent Slide'),
        'all_items'           => __('All Slides'),
        'view_item'           => __('View Slide'),
        'add_new_item'        => __('Add New Slide'),
        'add_new'             => __('Add New'),
        'edit_item'           => __('Edit Slide'),
        'update_item'         => __('Update Slide'),
        'search_items'        => __('Search Slide'),
        'not_found'           => __('Not Found'),
        'not_found_in_trash'  => __('Not found in Trash'),
    );

    $args = array(
        'label'               => __('Slides'),
        'description'         => __('Slides'),
        'labels'              => $labels,
        'supports'            => array('title', 'author'),     
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
    
    register_post_type('ju4hslide', $args);
}
add_action('init', 'ju4hslide_custom_post_type', 0);

/**
 * Adds new meta boxes to create/edit post form
 * 
 * @param type $post
 */
function add_meta_boxes_ju4hslide_callback($post) {
    add_meta_box('container_image', __('Image (best size: 1270x460)'), 'add_meta_box_ju4hslide_image_callback', 'ju4hslide', 'normal', 'low');
    add_meta_box('container_title', __('Title'), 'add_meta_box_ju4hslide_title_callback', 'ju4hslide', 'normal', 'low');
    add_meta_box('container_description', __('Description'), 'add_meta_box_ju4hslide_description_callback', 'ju4hslide', 'normal', 'low');
    add_meta_box('container_url', __('Url'), 'add_meta_box_ju4hslide_url_callback', 'ju4hslide', 'normal', 'low');
}
add_action('add_meta_boxes_ju4hslide', 'add_meta_boxes_ju4hslide_callback');

/**
 * Adds meta box "Title"
 * - text field with title of slide
 * 
 * @param type $post
 */
function add_meta_box_ju4hslide_title_callback($post) {
    global $meta_translations;
    foreach ($meta_translations as $key => $value) {
        echo '<p>'.$value.':<br>';
        html_admin_text("m_title_".$key, get_post_meta($post->ID, 'm_title_'.$key, true));
        echo '</p>';
    }
}

/**
 * Adds meta box "Url"
 * - text field with title of slide
 * 
 * @param type $post
 */
function add_meta_box_ju4hslide_url_callback($post) {
    global $meta_translations;
    echo '<p>English:<br>';
    html_admin_text("m_url", get_post_meta($post->ID, 'm_url', true));
    foreach ($meta_translations as $key => $value) {
        echo '<p>'.$value.':<br>';
        html_admin_text("m_url_".$key, get_post_meta($post->ID, 'm_url_'.$key, true));
        echo '</p>';
    }
}

/**
 * Adds meta box "Description"
 * - textarea field with description of slide
 * 
 * @param type $post
 */
function add_meta_box_ju4hslide_description_callback($post) {
    global $meta_translations;
    wp_nonce_field(basename( __FILE__ ), 'slide_description_nonce');
    echo '<p>English:<br>';
    html_admin_textarea("m_description", get_post_meta($post->ID, 'm_description', true));
    echo '</p>';
    foreach ($meta_translations as $key => $value) {
        echo '<p>'.$value.':<br>';
        html_admin_textarea("m_description_".$key, get_post_meta($post->ID, 'm_description_'.$key, true));
        echo '</p>';
    }
}

/**
 * Adds meta box "Attachments"
 * - @todo
 * 
 * @global type $meta_status
 * @param type $post
 */
function add_meta_box_ju4hslide_image_callback($post) {
    wp_nonce_field(basename( __FILE__ ), 'slide_image_nonce');
    html_admin_file_meta_box($post, 'm_image', 'image');
}

/**
 * Save slide post method
 * 
 * @param type $post_id
 * @return type
 */
function save_post_ju4hslide_callback($post_id) {
    global $meta_translations;
    
    $nonces = array('slide_image_nonce', 'slide_description_nonce');
    
    //checking nonces
    foreach ($nonces as $nonce) {
        if (!isset($_POST[$nonce]) || !wp_verify_nonce($_POST[$nonce], basename(__FILE__))) {
            return;
        }
    }
    
    //check if current user can edit post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if ($_POST['m_image_file'] != '') {
        $obj = new stdClass();
        $obj->file = $_POST['m_image_file'];
        $obj->text = $_POST['m_image_text'];
        $obj->url = $_POST['m_image_url'];
        $obj->license = $_POST['m_image_license'];
        $obj->license_holder = $_POST['m_image_holder'];
        $obj->check = ($_POST['m_image_check'] == 1) ? 1 : 0;
        update_post_meta($post_id, 'm_image', str_replace('\/', '/', json_encode($obj)));
    } else {
        delete_post_meta($post_id, 'm_image');
    }
    
    update_post_meta($post_id, 'm_description', esc_html($_POST['m_description']));
    update_post_meta($post_id, 'm_url', esc_html($_POST['m_url']));
    
    foreach ($meta_translations as $key => $value) {
        update_post_meta($post_id, 'm_title_'.$key, esc_html($_POST['m_title_'.$key]));
        update_post_meta($post_id, 'm_description_'.$key, esc_html($_POST['m_description_'.$key]));
        update_post_meta($post_id, 'm_url_'.$key, esc_html($_POST['m_url_'.$key]));
    }
}
add_action('save_post_ju4hslide', 'save_post_ju4hslide_callback', 10, 2);
