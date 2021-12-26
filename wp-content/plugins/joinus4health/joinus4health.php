<?php
/**
 * @package JoinUs4Health
 * @version 0.1
 */

/*
Plugin Name: JoinUs4Health
Description: Plugin for JoinUs4Health
Version: 0.1
*/

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

//metas definition
include_once 'includes/metas.php';

//register post types (suggestion, topic) & taxonomies (topictag)
include_once 'includes/post/suggestion.php';
include_once 'includes/post/topic.php';

//admin fields methods
include_once 'includes/admin_fields.php';

//front template methods
include_once 'includes/layouts.php';

/**
 * Filtering page templates and adding own pages from plugin
 * 
 * @global type $post
 * @param type $page_template
 * @return type
 */
function filter_page_template($page_template) {
    global $post;
    
    switch ($post->post_name) {
        case 'ju4hsuggestions':
            return WP_PLUGIN_DIR.'/joinus4health/pages/suggestion.php';
        case 'ju4htopics':
            return WP_PLUGIN_DIR.'/joinus4health/pages/topic.php';
        default:
            return $page_template;
    }
}
add_filter('page_template', 'filter_page_template');

/**
 * Filtering single templates and adding own singles from plugin
 * 
 * @global type $post
 * @param type $template
 * @return type
 */
function filter_single_tempalte($template) {
    global $post;
    
    $folder = 'singles';
    $header_accept = $_SERVER['HTTP_ACCEPT'];
    if (isset($header_accept) && strpos($header_accept, 'application/json') !== false) {
        $folder = 'json';
    }
    
    switch ($post->post_type) {
        case 'ju4hsuggestion':
            return WP_PLUGIN_DIR.'/joinus4health/'.$folder.'/suggestion.php';
        case 'ju4htopic':
            return WP_PLUGIN_DIR.'/joinus4health/'.$folder.'/topic.php';
        default:
            return $template;
    }
}
add_filter('single_template', "filter_single_tempalte");

/**
 * Admin notices while saving posts
 * 
 * @return type
 */
function _location_admin_notices() {
    if (!($errors = get_transient('settings_errors'))) {
        return;
    }

    $message = '<div id="error-message" class="error below-h2"><p><ul>';
    foreach ($errors as $error) {
        $message .= '<li>' . $error['message'] . '</li>';
    }
    $message .= '</ul></p></div><!-- #error -->';

    echo $message;

    delete_transient('settings_errors');
    remove_action('admin_notices', '_location_admin_notices');
}
add_action('admin_notices', '_location_admin_notices');

//flush_rewrite_rules();

function time_ago($post) {
    return human_time_diff(get_post_time('U', false, $post), current_time('timestamp')) . " " . __('ago');
}