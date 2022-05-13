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

include 'includes/metas.php';

$meta_translations = array(
    'de' => 'German',
    'nl' => 'Dutch',
    'pl' => 'Polish',
);

$per_page_topic = 10;
$per_page_task = 10;
$per_page_suggestion = 10;

$homepage = new stdClass();
$homepage->who_we_are = array(
    'en' => 'https://joinus4health.eu/about/cohorts/',
    'de' => 'https://joinus4health.eu/de/about/cohorts/',
);
$homepage->how_to_join_us = array(
    'en' => 'https://joinus4health.eu/join-us/',
    'de' => 'https://joinus4health.eu/de/join-us/',
);
$homepage->our_rules = array(
    'en' => 'https://joinus4health.eu/about/aim-and-ambition',
    'de' => 'https://joinus4health.eu/de/about/aim-and-ambition/',
);

//register post types (suggestion, topic) & taxonomies (topictag)
include_once 'includes/post/suggestion.php';
include_once 'includes/post/topic.php';
include_once 'includes/post/task.php';
include_once 'includes/post/slide.php';
include_once 'includes/post/page.php';

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
 * Filtering home template and adding own template from plugin
 * 
 * @global type $post
 * @param type $page_template
 * @return type
 */
function filter_home_template($page_template) {
    return WP_PLUGIN_DIR.'/joinus4health/pages/home.php';
}
add_filter('home_template', 'filter_home_template');

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
    return human_time_diff(get_post_time('U', false, $post, true), current_time('timestamp')) . " " . __('ago', 'joinus4health');
}

function time_left($time) {
    $current_time = current_time('timestamp');
    if ($current_time > $time) {
        return __('expired', 'joinus4health').' '.human_time_diff($time, $current_time).' '.__('ago', 'joinus4health');
    } else {
        return human_time_diff($time, $current_time)." ".__('left', 'joinus4health');
    }
}

function time_print($format, $unix_timestamp) {
    global $wp_locale;
    
    $wp_timezone = wp_timezone();
    $datetime = date_create_immutable_from_format('U', $unix_timestamp, $wp_timezone);
    return $datetime->format($format);
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

function add_language_vars() {
    $possible_languages = array();
    $possible_languages['pl'] = new stdClass();
    $possible_languages['pl']->text = 'Polski';
    $possible_languages['pl']->url = home_url()."/wp-content/plugins/joinus4health/assets/png/PL.png";
    $possible_languages['nl'] = new stdClass();
    $possible_languages['nl']->text = 'Nederlandse';
    $possible_languages['nl']->url = home_url()."/wp-content/plugins/joinus4health/assets/png/NL.png";
    $possible_languages['de'] = new stdClass();
    $possible_languages['de']->text = 'Deutsch';
    $possible_languages['de']->url = home_url()."/wp-content/plugins/joinus4health/assets/png/DE.png";
    $possible_languages['en'] = new stdClass();
    $possible_languages['en']->text = 'English';
    $possible_languages['en']->url = home_url()."/wp-content/plugins/joinus4health/assets/png/GB.png";
    
    $join_us = array();
    $join_us[0] = new stdClass();
    $join_us[0]->url = home_url()."/ju4hsuggestion/";
    $join_us[0]->text = __('Suggestions', 'joinus4health');
    $join_us[1] = new stdClass();
    $join_us[1]->url = home_url()."/ju4htopic/";
    $join_us[1]->text = __('Topics', 'joinus4health');
    $join_us[2] = new stdClass();
    $join_us[2]->url = home_url()."/ju4htask/";
    $join_us[2]->text = __('Tasks', 'joinus4health');
    $join_us[3] = new stdClass();
    $join_us[3]->url = home_url()."/groups/";
    $join_us[3]->text = __('Working teams', 'joinus4health');
    
    echo '<script type="text/javascript">'.
            'var possible_languages = '.json_encode($possible_languages).';'.
            'var join_us_items = '.json_encode($join_us).';'.
            'var language = "'.get_preferred_language().'";'.
            'var sign_up_url = "'.home_url().'/sign-up/";'.
            'var sign_up_text = "'.__('Register').'";'.
            'var sign_in_url = "'.home_url().'/wp-login.php";'.
            'var sign_in_text = "'.__('Log In').'";'.
            'var join_us_text = "'.__('Join us', 'joinus4health').'";'.
            'var home_text = "'.__('Home', 'joinus4health').'";'.
            'var home_url = "'. home_url().'";'.
            'var is_logged_in = '.(is_user_logged_in() ? 'true' : 'false').';'.
            'var error_username_empty = "'.__('Username field cannot be empty', 'joinus4health').'";'.
            'var error_password_empty = "'.__('Password field cannot be empty', 'joinus4health').'";'.
            'var error_password_confirm_empty = "'.__('Password confirmation field cannot be empty', 'joinus4health').'";'.
            'var error_password_confirm_mismatch = "'.__('Password confirmation mismatch', 'joinus4health').'";'.
            'var error_password_too_weak = "'.__('Password is too weak', 'joinus4health').'";'.
            'var error_email_empty = "'.__('E-mail field cannot be empty', 'joinus4health').'";'.
            'var error_email_invalid = "'.__('E-mail format is invalid', 'joinus4health').'";'.
         '</script>';
}
add_action('wp_head', 'add_language_vars', 1, 1);

function add_jquery_feather_icons_script() {
    global $meta_languages, $meta_countries, $meta_stakeholder_group;
    global $meta_suggestion_types, $meta_topic_types, $meta_task_types;
    global $meta_task_duration, $meta_suggestion_duration;
    global $meta_task_level;
    global $meta_suggestion_source, $meta_topic_source, $meta_task_source;
    global $meta_topic_status;
    global $meta_topic_sortby, $meta_task_sortby, $meta_suggestion_sortby;
    global $meta_process, $meta_methods, $meta_contents;

    global $wp_locale;
    
    wp_enqueue_script('ju4h-jquery', home_url()."/wp-content/plugins/joinus4health/assets/js/jquery.min.js");
    wp_enqueue_script('ju4h-feather', home_url()."/wp-content/plugins/joinus4health/assets/js/feather.min.js");
    wp_enqueue_script('ju4h-feather-replace', home_url()."/wp-content/plugins/joinus4health/assets/js/feather.replace.js");
    wp_enqueue_script('ju4h-js-cookies', home_url().'/wp-content/plugins/joinus4health/assets/js/js.cookie.min.js');
    wp_enqueue_script('ju4h-js', home_url().'/wp-content/plugins/joinus4health/assets/js/ju4h.js');
    
    $array = array('pl' => 'pl_PL', 'nl' => 'nl_NL', 'de' => 'de_DE', 'en' => 'en_GB');
    $get_preferred_language = get_preferred_language();
    $locale = isset($array[$get_preferred_language]) ? $array[$get_preferred_language] : 'en_GB';
    if ($locale != null) {
        $mo_file_default = WP_CONTENT_DIR.'/languages/'.$locale.'.mo';
        $mo_file = WP_CONTENT_DIR.'/languages/plugins/joinus4health-'.$locale.'.mo';
        $mo_file_buddypress = WP_CONTENT_DIR.'/languages/plugins/buddypress-'.$locale.'.mo';

        if (file_exists($mo_file)) {
            unload_textdomain('joinus4health');
            load_textdomain('joinus4health', $mo_file);
        }
        
        if (file_exists($mo_file_default)) {
            unload_textdomain('default');
            load_textdomain('default', $mo_file_default);
        }
        
        if (file_exists($mo_file_buddypress)) {
            unload_textdomain('buddypress');
            load_textdomain('buddypress', $mo_file_buddypress);
        }
    }
    
    $wp_locale = new WP_Locale();
    
    //reinclude metas definition
    include 'includes/metas.php';
}
add_action('wp_enqueue_scripts', 'add_jquery_feather_icons_script');

function get_preferred_language() {
    $field_id = 2; //ID field of language, user profile bbpress
    $field_array_accpeted_language = array('pl', 'en', 'de', 'nl');
    
    $current_user_id = get_current_user_id();
    $preferred_language = null;
    
    if (isset($_COOKIE['language'])) {
        if (in_array($_COOKIE['language'], $field_array_accpeted_language)) {
            return $_COOKIE['language'];
        }
    }
    
    /** Currently not used, maybe in future someone will need this feature
    if ($current_user_id > 0) {
        $obj = xprofile_get_field($field_id, $current_user_id, true);
        
        if (isset($obj->data) && isset($obj->data->value) && is_string($obj->data->value)) {
            $field_language = strtolower($obj->data->value);
            
            if (in_array($field_language, $field_array_accpeted_language)) {
                $preferred_language = $field_language;
            }
        }
    }
     */
    
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

function xprofile_template_display_profile_404($param) {
    return '404';
}
add_filter('xprofile_template_display_profile', 'xprofile_template_display_profile_404', 12, 1);

if (!function_exists('redirect_404_to_homepage')) {
    add_action('template_redirect', 'redirect_404_to_homepage');

    function redirect_404_to_homepage() {
       if (is_404()) {
            wp_safe_redirect( home_url('/') );
            exit;
       }
    }
}

function page_multilingual_redirect($query) {
    global $wp_query;
    
    $pagename = get_query_var('pagename');
    if ($query->is_main_query() && !is_admin() && !empty($pagename)) {
        $wp_query_check_page = new WP_Query(array(
            'post_type' => 'page',
            'name' => $pagename,
            'posts_per_page' => 1,
            'post_parent' => 0
        ));
        
        if ($wp_query_check_page->have_posts()) {
            
            $posts_check_pages = $wp_query_check_page->get_posts();
            if (count($posts_check_pages) == 0) {
                return;
            }
            
            $lookup_language = get_post_meta($posts_check_pages[0]->ID, 'm_lookup_language', true);
            if ($lookup_language == 1) {
                $wpq = new WP_Query(array(
                    'post_type' => 'page',
                    'post_parent' => $posts_check_pages[0]->ID,
                    'posts_per_page' => 1,
                    'meta_query' => array(
                        'm_language_clause' => array(
                            'key' => 'm_language',
                            'value' => strtoupper(get_preferred_language()),
                        )
                    )
                ));
                
                if ($wpq->have_posts()) {
                    $posts = $wpq->get_posts();
                    $query->init();
                    $query->set('page_id', $posts[0]->ID);
                }
            }
        }
    }
}
add_action('pre_get_posts', 'page_multilingual_redirect');

/**
 * Rewrites from signup username to field_1 (profile name)
 */
function username_rewrite_to_field_1_on_signup() {
    if (!is_user_logged_in()) {
        $_POST['field_1'] = $_POST['signup_username'];
    }    
}
add_action('bp_signup_pre_validate', 'username_rewrite_to_field_1_on_signup');

/**
 * Rewrites from signup username to field_1 (profile name)
 */
function username_rewrite_to_field_1_on_edit_profile($field) {
    if ($field == 1 && is_user_logged_in() && !empty($_POST)) {
        $user = wp_get_current_user();
        xprofile_set_field_data(1, $user->ID, $user->user_login, true);
    }
}
add_action('xprofile_profile_field_data_updated', 'username_rewrite_to_field_1_on_edit_profile');

function profile_privacy_redirect() {
    if (!bp_is_user()) {
        return;
    }
    
    if (current_user_can('manage_options')) {
        return;
    }
    
    if (bp_loggedin_user_id() == bp_displayed_user_id()) {
        return;
    }
    
    bp_core_redirect(home_url());
}
add_action('init', 'profile_privacy_redirect');

function members_redirect() {
    if (!bp_is_members_directory()) {
        return;
    }
    
    if (current_user_can('manage_options')) {
        return;
    }
    
    bp_core_redirect(home_url());
}
add_action('init', 'members_redirect');

function group_members_redirect() {
    if (!bp_is_group_members()) {
        return;
    }
    
    if (current_user_can('manage_options')) {
        return;
    }
    
    bp_core_redirect(home_url());
}
add_action('init', 'group_members_redirect');

add_filter('bp_email_set_reply_to', function($retval) {
    return new BP_Email_Recipient('contact@joinus4health.eu');
});

add_filter('bp_core_send_user_registration_admin_notification', function($retval) {
    return false;
});

function ju4h_comment_moderation_text($notify_message, $comment_id ) {
    $comment = get_comment($comment_id);
    $post    = get_post($comment->comment_post_ID );
    
    switch ($comment->comment_type) {
        case 'trackback':
            $notify_message  = sprintf( __( 'A new trackback on the post "%s" is waiting for your approval' ), $post->post_title ) . "\r\n";
            break;
        case 'pingback':
            $notify_message  = sprintf( __( 'A new pingback on the post "%s" is waiting for your approval' ), $post->post_title ) . "\r\n";
            break;
        default:
            $notify_message  = sprintf( __( 'A new comment on the post "%s" is waiting for your approval' ), $post->post_title ) . "\r\n";
            break;
    }
    return $notify_message;
}
add_filter( 'comment_moderation_text', 'ju4h_comment_moderation_text', 10, 2);
        
function ju4h_comment_notification_text($notify_message, $comment_id) {
    $comment = get_comment($comment_id);
    $post   = get_post($comment->comment_post_ID);
    
    switch ($comment->comment_type) {
        case 'trackback':
            $notify_message = sprintf( __( 'New trackback on your post "%s"' ), $post->post_title ) . "\r\n";
            break;
        case 'pingback':
            $notify_message = sprintf( __( 'New pingback on your post "%s"' ), $post->post_title ) . "\r\n";
            break;
        default:
            $notify_message = sprintf( __( 'New comment on your post "%s"' ), $post->post_title ) . "\r\n";
            break;
    }
    return $notify_message;
}
add_filter('comment_notification_text', 'ju4h_comment_notification_text', 10, 2);

function ju4h_rest_api_init() {
    $whitelist = array('127.0.0.1', '::1');
    
    if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
        die('REST API DISABLED');
    }
}
add_action('rest_api_init', 'ju4h_rest_api_init');