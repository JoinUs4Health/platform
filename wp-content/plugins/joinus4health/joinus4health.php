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
        case 'ju4hsuggestion-new':
            return WP_PLUGIN_DIR.'/joinus4health/pages/suggestion-new.php';
        default:
            return $page_template;
    }
}
add_filter('page_template', 'filter_page_template');


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

    if ($post == null || !isset($post->post_type)) {
        return $page_template;
    }
    
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

function time_ago($post) {
    return human_time_diff(get_post_time('U', false, $post), current_time('timestamp')) . " " . __('ago', 'joinus4health');
}

function time_left($time) {
    $current_time = current_time('timestamp');
    if ($current_time > $time) {
        return __('expired', 'joinus4health').' '.human_time_diff($time, $current_time).' '.__('ago', 'joinus4health');
    } else {
        return human_time_diff($time, $current_time)." ".__('left', 'joinus4health');
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

function add_jquery_feather_icons_script() {
    wp_enqueue_script('ju4h-jquery', home_url()."/wp-content/plugins/joinus4health/assets/js/jquery.min.js");
    wp_enqueue_script('ju4h-feather', home_url()."/wp-content/plugins/joinus4health/assets/js/feather.min.js");
    wp_enqueue_script('ju4h-feather-replace', home_url()."/wp-content/plugins/joinus4health/assets/js/feather.replace.js");
    
    $array = array('pl' => 'pl_PL', 'nl' => 'nl_NL', 'de' => 'de_DE');
    $get_preferred_language = get_preferred_language();
    $locale = isset($array[$get_preferred_language]) ? $array[$get_preferred_language] : null;
    if ($locale != null) {
        $mo_file = WP_CONTENT_DIR.'/languages/plugins/joinus4health-'.$locale.'.mo';

        if (file_exists($mo_file)) {
            unload_textdomain('joinus4health');
            load_textdomain('joinus4health', $mo_file);
        }
    }
}

add_action('wp_enqueue_scripts', 'add_jquery_feather_icons_script');


function my_setup() {

}
add_action('setup_theme', 'my_setup');

function get_preferred_language() {
    $field_id = 2; //ID field of language, user profile bbpress
    $field_array_accpeted_language = array('pl', 'en', 'de', 'nl');
    
    $current_user_id = get_current_user_id();
    $preferred_language = null;
    
    if ($current_user_id > 0) {
        $obj = xprofile_get_field($field_id, $current_user_id, true);
        
        if (isset($obj->data) && isset($obj->data->value) && is_string($obj->data->value)) {
            $field_language = strtolower($obj->data->value);
            
            if (in_array($field_language, $field_array_accpeted_language)) {
                $preferred_language = $field_language;
            }
        }
    }
    
    if ($preferred_language == null) {
        $browser_locale = locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        
        if ($browser_locale == null) {
            return 'en';
        } else if (strpos($browser_locale, '_') !== false) {
            return strtolower(explode('_', $browser_locale)[0]);
        } else {
            return $browser_locale;
        }
    } else {
        return $preferred_language;
    }
}

function get_translated_title($post, $field, $preferred_language) {
    $translated = get_post_meta($post->ID, $field.'_'.$preferred_language, true);
    $m = trim(empty($translated) ? get_the_title($post) : $translated);
    return $m;
}

function get_translated_field($post, $field, $preferred_language) {
    $translated = get_post_meta($post->ID, $field.'_'.$preferred_language, true);
    $m = trim(empty($translated) ? get_post_meta($post->ID, $field, true) : $translated);
    return $m;
}

function get_translated_field_paragraph($post, $field, $preferred_language) {
    $translated = get_post_meta($post->ID, $field.'_'.$preferred_language, true);
    $m = trim(empty($translated) ? get_post_meta($post->ID, $field, true) : $translated);
    return str_replace(array("\r\n\r\n\r\n\r\n", "\r\n\r\n\r\n", "\r\n\r\n", "\r\n", "\n\n", "\n"), '</p><p>', $m);
}
