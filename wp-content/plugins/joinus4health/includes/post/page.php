<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Adds new meta boxes to create/edit post form
 * 
 * @param type $post
 */
function add_meta_boxes_page_callback($post) {
    add_meta_box('container_language', __('Language'), 'add_meta_box_page_language_callback', 'page', 'normal', 'low');
}
add_action('add_meta_boxes_page', 'add_meta_boxes_page_callback');

/**
 * Adds meta box "Url"
 * - text field with title of slide
 * 
 * @param type $post
 */
function add_meta_box_page_language_callback($post) {
    global $meta_languages;
    $lookup_languages = array(0 => __('No'), 1 => __('Yes'));
    html_admin_select_box(__('Lookup for languages in child pages'), "m_lookup_language", $lookup_languages, get_post_meta($post->ID, 'm_lookup_language', true), false);
    html_admin_select_box(__('Language'), "m_language", $meta_languages, get_post_meta($post->ID, 'm_language', true));
}

/**
 * Save slide post method
 * 
 * @param type $post_id
 * @return type
 */
function save_post_page_callback($post_id) {
    //check if current user can edit post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    update_post_meta($post_id, 'm_lookup_language', esc_html($_POST['m_lookup_language']));
    update_post_meta($post_id, 'm_language', esc_html($_POST['m_language']));
}
add_action('save_post_page', 'save_post_page_callback', 10, 2);

function manage_page_posts_columns_callback($columns) {
    $columns['language'] = __('Language');
    return $columns;
}
add_filter('manage_page_posts_columns', 'manage_page_posts_columns_callback');

function manage_page_posts_custom_column_callback($column, $post_id) {
    global $meta_languages;
    
    if ($column == 'language') {
        $lookup = get_post_meta($post_id, 'm_lookup_language', true);
        $language = get_post_meta($post_id, 'm_language', true);
        if ($lookup == 1) {
            echo __('Lookup for language in child pages');
        } else if ($language != null && array_key_exists($language, $meta_languages)) {
            echo $meta_languages[$language];
        }
    }
}
add_action('manage_page_posts_custom_column', 'manage_page_posts_custom_column_callback', 10, 2);