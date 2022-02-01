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
include_once 'includes/post/task.php';

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
        case 'ju4htasks':
            return WP_PLUGIN_DIR.'/joinus4health/pages/task.php';
        default:
            return $page_template;
    }
}
//add_filter('page_template', 'filter_page_template');


/**
 * Filtering page templates and adding own pages from plugin
 * 
 * @global type $post
 * @param type $page_template
 * @return type
 */
function filter_index_template($page_template) {
    return WP_PLUGIN_DIR.'/joinus4health/pages/topic.php';
}
add_filter('index_template', 'filter_index_template');


/**
 * Filtering page templates and adding own pages from plugin
 * 
 * @global type $post
 * @param type $page_template
 * @return type
 */
function filter_archive_template($page_template) {
    global $post;

    switch ($post->post_type) {
        case 'ju4hsuggestion':
            return WP_PLUGIN_DIR.'/joinus4health/pages/suggestion.php';
        case 'ju4htopic':
            return WP_PLUGIN_DIR.'/joinus4health/pages/topic.php';
        case 'ju4htask':
            return WP_PLUGIN_DIR.'/joinus4health/pages/task.php';
        default:
            return $page_template;
    }
}
add_filter('archive_template', 'filter_archive_template');

/**
 * Filtering single templates and adding own singles from plugin
 * 
 * @global type $post
 * @param type $template
 * @return type
 */
function filter_single_template($template) {
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
        case 'ju4htask':
            return WP_PLUGIN_DIR.'/joinus4health/'.$folder.'/task.php';
        default:
            return $template;
    }
}
add_filter('single_template', "filter_single_template");

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

function time_ago($post, $suffix = 'ago') {
    return human_time_diff(get_post_time('U', false, $post), current_time('timestamp')) . " " . __($suffix);
}

function time_left($time) {
    $current_time = current_time('timestamp');
    if ($current_time > $time) {
        return _('expired').' '.human_time_diff($time, $current_time).' '._('ago');
    } else {
        return human_time_diff($time, $current_time)." "._('left');
    }
}

function count_comments($comments) {
    $count = count($comments);
    foreach ($comments as $comment) {
        $count += count_comments($comment->get_children());
    }
    return $count;
}

function get_query($array) {
    $m = array();
    
    foreach ($array as $key => $value) {
        $m[] = $key.'='.$value;
    }
    
    return join('&amp;', $m);
}