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

$capabilites = array(
    'edit_post',
    'read_post',
    'delete_post',
    'edit_posts',
    'edit_others_posts', 
    'publish_posts',
    'read_private_posts',
    'edit_published_posts'
);

$per_page_topic = 10;
$per_page_task = 10;
$per_page_suggestion = 10;

$homepage = new stdClass();
$homepage->who_we_are = array(
    'en' => 'https://joinus4health.eu/about/cohorts/',
    'de' => 'https://joinus4health.eu/de/about/cohorts/',
    'pl' => 'https://joinus4health.eu/pl/about/cohorts/',
    'nl' => 'https://joinus4health.eu/nl/about/cohorts/'
);
$homepage->how_to_join_us = array(
    'en' => 'https://joinus4health.eu/join-us/',
    'de' => 'https://joinus4health.eu/de/join-us/',
    'pl' => 'https://joinus4health.eu/pl/join-us/',
    'nl' => 'https://joinus4health.eu/nl/join-us/'
);
$homepage->our_rules = array(
    'en' => 'https://joinus4health.eu/about/aim-and-ambition',
    'de' => 'https://joinus4health.eu/de/about/aim-and-ambition/',
    'pl' => 'https://joinus4health.eu/pl/about/aim-and-ambition/',
    'nl' => 'https://joinus4health.eu/nl/about/aim-and-ambition/',
);

//register post types (suggestion, topic) & taxonomies (topictag)
include_once 'includes/post/suggestion.php';
include_once 'includes/post/topic.php';
include_once 'includes/post/task.php';
include_once 'includes/post/slide.php';
include_once 'includes/post/page.php';
include_once 'includes/post/agreement.php';
include_once 'includes/post/useragreement.php';

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

function container_margin_top() {
    if (!is_front_page()) {
        echo "<style>#content { margin-top: 40px; }</style>";
    }
}
add_action('wp_head', 'container_margin_top', 100);

function hide_qt_bbp_topic_content_img() {
    echo "<style>#qt_bbp_topic_content_img { display: none; }</style>";
}
add_action('wp_head', 'hide_qt_bbp_topic_content_img', 100);

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
    
    ?>
<script src="<?= home_url() ?>/wp-content/plugins/joinus4health/assets/js/jquery.modal.min.js"></script>
<link rel="stylesheet" href="<?= home_url() ?>/wp-content/plugins/joinus4health/assets/css/jquery.modal.min.css" />
    <?php

    
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
            'var reply_to_text = "'.__('Reply to', 'joinus4health').'";'.
            'var comment_text = "'.__('comment', 'joinus4health').'";'.
            'var home_url = "'. home_url().'";'.
            'var is_logged_in = '.(is_user_logged_in() ? 'true' : 'false').';'.
            'var error_username_empty = "'.__('Username field cannot be empty', 'joinus4health').'";'.
            'var error_password_empty = "'.__('Password field cannot be empty', 'joinus4health').'";'.
            'var error_password_confirm_empty = "'.__('Password confirmation field cannot be empty', 'joinus4health').'";'.
            'var error_password_confirm_mismatch = "'.__('Password confirmation mismatch', 'joinus4health').'";'.
            'var error_password_too_weak = "'.__('Password is too weak', 'joinus4health').'";'.
            'var error_email_empty = "'.__('E-mail field cannot be empty', 'joinus4health').'";'.
            'var error_email_invalid = "'.__('E-mail format is invalid', 'joinus4health').'";'.
            'var deepl_url = "'. home_url().'/wp-content/plugins/joinus4health/deepl.php";'.
            'var ju4h_add_comment_url = "'. home_url().'/wp-content/plugins/joinus4health/includes/add_comment.php";'.
            'var ju4h_upload_url = "'. home_url().'/wp-content/plugins/joinus4health/includes/upload_by_user.php";'.
            'var upload_terms_text = "'.__('By uploading a file or image, you confirm that it neither violates applicable laws nor infringes the rights of third parties.', 'joinus4health').'";'.
         '</script>';
}
add_action('wp_head', 'add_language_vars', 12, 1);

function add_consent_vars() {
    
    global $meta_agreement_types, $meta_agreement_pages;
    
    $consent_agreement_type = '';
    $is_consent_needed = false;
    $consent_ids = [];
    $user_id = 0;
    $show_modal_consent_after_logout = false;
    $current_page = get_post();
    $parent_slug = null;
    
    if ($current_page && $current_page->post_parent) {
        $parent_page = get_post($current_page->post_parent);
        $parent_slug = $parent_page->post_name;
    }
    
    if ($parent_slug == 'privacy-policy' || $parent_slug == 'terms-of-use') {
        //nothing to do
    } else if (is_user_logged_in()) {
        $user = wp_get_current_user();
        $user_id = $user->ID;
        
        $query_agreements = [];
        foreach ($meta_agreement_types as $key => $value) {
            $query_agreements[$key] = new WP_Query(array(
                'post_type' => 'ju4hagreement', 
                'posts_per_page' => 1, 
                'orderby' => array('date' => 'DESC'), 
                'meta_query' => array(array('key' => 'm_agreement_type', 'value' => $key))
            ));
        }

        $user_needed_agreements = [];
        foreach ($query_agreements as $query_index => $query_agreement) {
            if ($query_agreement->have_posts()) {
                $post = $query_agreement->post;
                $consent_id = $post->ID;
                $consent_ids[] = $consent_id;

                $meta_query = array();
                $meta_query['relation'] = 'AND';
                $meta_query["m_consent_user_id_clause"] = array('key' => 'm_consent_user_id', 'value' => $user_id);
                $meta_query["m_post_value_clause"] = array('key' => 'm_post_value', 'value' => '1');
                $meta_query["m_consent_id_clause"] = array('key' => 'm_consent_id', 'value' => $consent_id);

                $query_useragreement = new WP_Query(array('post_type' => 'ju4huseragreement', 'posts_per_page' => 1, 'meta_query' => $meta_query));
                if (!$query_useragreement->have_posts()) {
                    $user_needed_agreements[] = "<a target='_blank' href='".home_url().'/'.$meta_agreement_pages[$query_index]."/'>".__($meta_agreement_types[$query_index], 'joinus4health').'</a>';
                }
            }
        }
        
        $is_consent_needed = !empty($user_needed_agreements);
        $consent_agreement_type = implode(' & ', $user_needed_agreements);
    }

    echo '<script type="text/javascript">'.
            'var is_consent_needed = '.($is_consent_needed ? 'true' : 'false').';'.
            'var consent_ids = '. json_encode($consent_ids).';'.
            'var consent_wpnonce = "'.wp_create_nonce('delete-user-id-'. $user_id).'";'.
            'var consent_agreement_type = "'.$consent_agreement_type.'";'.
            'var show_modal_consent_after_logout = '.($show_modal_consent_after_logout ? 'true' : 'false').';'.
         '</script>';
}
add_action('wp_head', 'add_consent_vars', 1, 1);

function add_consent_modal() {
    $translation = __('Welcome back to our platform! We have updated our %s and would like to ask you to accept them before you can continue. By clicking on "Agree and continue" you agree to the new document and can use our platform as usual. If you do not wish to accept the new changes, you can log out or delete your account.', 'joinus4health');
    $translation = str_replace("%s", '<span id="consent-type"></span>', $translation);
    ?>
<div id="modal-consent" class="modal" style="min-width: 1100px;">
    <div class="text" style="padding-top: 20px;"><?= $translation ?></div>
    <div class="buttons">
        <a href="#" rel="modal:close" id="consent-yes" class="blackbtn"><?= __('Agree and continue', 'joinus4health') ?></a>
        <a href="<?= wp_logout_url() ?><?= rawurlencode("&") ?>show_modal_consent_after_logout=true"><?= __('Disagree and log out', 'joinus4health') ?></a>
        <a href="#" rel="modal:close" id="consent-delete-account"><?= __('Disagree and delete my account', 'joinus4health') ?></a>
    </div>
</div>
<div id="modal-consent-logout" class="modal" style="min-width: 900px;">
    <div class="text" style="padding-top: 20px;"></div>
</div>
<div id="modal-consent-delete-account" class="modal">
    <div class="text" style="padding-top: 20px;"><?= __('We are very sorry that you do not agree to our changes and wish to delete your account. We would like to thank you for the time you have spent on our platform and wish you all the best for your future!', 'joinus4health') ?></div>
    <div class="buttons">
        <a href="#" rel="modal:close" id="consent-delete-account-yes" class="blackbtn"><?= __('Yes') ?></a>
        <a href="<?= wp_logout_url() ?>"><?= __('No') ?></a>
    </div>
</div>
<?php
}
add_action('wp_footer', 'add_consent_modal');

function wp_head_add_message_input() {
        echo '<script type="text/javascript">'.
            'jQuery(document).ready(function(){ '.
                'var hashlocation = window.location.hash;'.
                'if (hashlocation.length > 0) {'.
                    '$("#send-to-input").val(window.location.hash.substring(1).replace("%20", " "));'.
                '}'.
            '});'.
        '</script>';
}
add_action('wp_head', 'wp_head_add_message_input', 11, 1);

function add_jquery_feather_icons_script() {
    global $post;
    global $meta_languages, $meta_countries, $meta_stakeholder_group;
    global $meta_suggestion_types, $meta_topic_types, $meta_task_types;
    global $meta_task_duration, $meta_suggestion_duration;
    global $meta_task_level;
    global $meta_suggestion_source, $meta_topic_source, $meta_task_source;
    global $meta_topic_status;
    global $meta_topic_sortby, $meta_task_sortby, $meta_suggestion_sortby;
    global $meta_process, $meta_methods, $meta_contents;

    global $wp_locale;
    
    $load_jquery_3_2_1 = true;
    if (isset($post) && isset($post->post_type) && $post->post_type == 'project') {
        $load_jquery_3_2_1 = false;
    }
    
    if ($load_jquery_3_2_1) {
        wp_enqueue_script('ju4h-jquery', home_url()."/wp-content/plugins/joinus4health/assets/js/jquery-3.2.1.min.js");
    } else {
        wp_enqueue_script('ju4h-jquery', home_url()."/wp-content/plugins/joinus4health/assets/js/jquery-2.1.0.min.js");
    }
    wp_enqueue_script('ju4h-modal', home_url()."/wp-content/plugins/joinus4health/assets/js/jquery.modal.min.js");
    wp_enqueue_script('ju4h-feather', home_url()."/wp-content/plugins/joinus4health/assets/js/feather.min.js");
    wp_enqueue_script('ju4h-feather-replace', home_url()."/wp-content/plugins/joinus4health/assets/js/feather.replace.js");
    wp_enqueue_script('ju4h-js-cookies', home_url().'/wp-content/plugins/joinus4health/assets/js/js.cookie.min.js');
    wp_enqueue_script('ju4h-js', home_url().'/wp-content/plugins/joinus4health/assets/js/ju4h.js', array(), time());
    
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

function group_activity_redirect() {
    if (!bp_is_activity_directory()) {
        return;
    }
    
    if (current_user_can('manage_options')) {
        return;
    }
    
    bp_core_redirect(home_url());
}
add_action('init', 'group_activity_redirect');

add_filter('bp_email_set_from', function($retval) {
    return new BP_Email_Recipient('noreply@platform.joinus4health.eu');
});

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
    
    if (current_user_can('administrator')){
        return;
    }
    
    if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
        die('REST API DISABLED');
    }
}
add_action('rest_api_init', 'ju4h_rest_api_init');

function remove_ip_for_user($comment_IP, $comment_ID, $comment) {
    if (current_user_can('manage_options')) {
        return $comment_IP;
    } else {
        return '';
    }
}
add_filter('get_comment_author_IP', 'remove_ip_for_user', 10, 3);

function remove_email_for_user($comment_email, $comment) {
    if (current_user_can('manage_options')) {
        return $comment_email;
    } else {
        return '';
    }
}
add_filter('comment_email', 'remove_email_for_user', 10, 2);


function remove_all_commentfields() {
    global $pagenow;
    if (current_user_can('manage_options')) {
        return;
    }

    if ($pagenow == 'comment.php' || $pagenow == 'edit-comments.php') {
    ?>
    <style>
        .comment-reply #edithead div:nth-child(2) {
            display: none;
        }
        
        .editcomment tr:nth-child(2) {
            display: none;
        }
    </style>
    <?php
    }
}
add_action( 'admin_print_styles', 'remove_all_commentfields' );

function admin_init_restrict_admin_ajax() {
	if ($_POST['action'] == 'joinleave_group') {
		return;
	}
	
    $filename = basename($_SERVER['SCRIPT_FILENAME']);
    if ($filename == 'admin-ajax.php') {
        if (get_current_user_id() == 0) {
            exit;
        }
    }
}
add_action('admin_init', 'admin_init_restrict_admin_ajax');

/**
 * Hide admin bar
 */
//add_filter('show_admin_bar', '__return_false');

/**
 * Sending email notification about deleting user account
 * 
 * @param type $user_id
 */
function delete_user_email_notification($user_id) {
    $user_meta = get_userdata($user_id);
    $admins = get_users(array('role' => 'administrator'));
    foreach ($admins as $admin) {
        $email = $admin->data->user_email;
        $headers = 'From: '.$email."\r\n" .'Reply-To: '.$email."\r\n";
        $sent = wp_mail($email, 'Account has been deleted', 'User named '.$user_meta->data->display_name.' deleted account');
    }
}
add_action('delete_user', 'delete_user_email_notification', 10);

function ju4h_deleted_user($user_id, $reassign, $user) {
    $comments = get_comments(array(
        'author__in' => $user_id
    ));
    $newname = 'anonymous'.time();
    foreach ($comments as $comment) {
        $update_comment = array();
        $update_comment['comment_author'] = $newname;
        $update_comment['comment_ID'] = $comment->comment_ID;
        $update_comment['comment_author_email'] = $newname.'@platform.joinus4health.eu';
        wp_update_comment($update_comment);
    }
}
add_filter('deleted_user', 'ju4h_deleted_user', 10, 3);

function theme_change_comment_field_names($translated_text, $text, $domain) {
    if ($domain == 'buddypress') {
        if ($translated_text == 'Usunięcie twojego konta spowoduje usunięcie zawartości, którą stworzyłeś. Jest to całkowicie nieodwracalne.') {
            return 'Likwidacja konta spowoduje usunięcie wszystkich danych osobowych z nim związanych, tzn., że nie będzie możliwości ich odtworzenia.';
        } else if ($translated_text == 'Het verwijderen van het account zal ook alle gegevens wissen die je hebt aangemaakt. Dit is niet terug te draaien.') {
            return 'Als u uw account verwijdert, zullen al uw persoonlijke gegevens die aan uw account zijn gekoppeld ook onherstelbaar worden verwijderd.';
        } else if ($translated_text == 'Durch die Löschung des Benutzerkontos, werden auch alle erstellten Inhalte gelöscht. Eine Wiederherstellung wird nicht möglich sein.') {
            return 'Durch die Löschung des Benutzerkontos, werden all Ihre personenbezogenen Daten, die mit Ihrem Account verknüpft sind, gelöscht. Eine Wiederherstellung wird nicht möglich sein.';
        } else if ($translated_text == 'Deleting your account will delete all of the content you have created. It will be completely irrecoverable.') {
            return 'Deleting your account will delete all of your personal data associated with your account. It will be completely irrecoverable.';
        }
    }

    return $translated_text;
}
add_filter('gettext', 'theme_change_comment_field_names', 20, 3);

function phpmailer_sender_update() {
    $args = func_get_args();
    $phpmailer = $args[0];
    $phpmailer->Sender = 'noreply@platform.joinus4health.eu';
}
add_action('phpmailer_init', 'phpmailer_sender_update', 10, 999);


function ju4h_add_agreement($user_id, $user_login, $user_password, $user_email, $usermeta) {
    global $meta_agreement_types;

    if (is_int($user_id)) {
        $query_agreements = [];
        foreach ($meta_agreement_types as $key => $value) {

            $query_agreements[$key] = new WP_Query(array(
                'post_type' => 'ju4hagreement', 
                'posts_per_page' => 1, 
                'orderby' => array('date' => 'DESC'), 
                'meta_query' => array(array('key' => 'm_agreement_type', 'value' => $key))
            ));
        }

        foreach ($query_agreements as $query_index => $query_agreement) {
            if ($query_agreement->have_posts()) {
                $post = $query_agreement->post;
                $consent_id = $post->ID;
                $new = array(
                    'post_title'   => 'Consent of user #'.$user_id.' at '.time(),
                    'post_status'  => 'publish',
                    'post_type'    => 'ju4huseragreement',
                );

                $post_id = wp_insert_post($new);
                add_post_meta($post_id, 'm_consent_user_id', $user_id);
                add_post_meta($post_id, 'm_consent_id', $consent_id);
                add_post_meta($post_id, 'm_post_value', '1');
            }
        }
    }
}
add_filter('bp_core_signup_user', 'ju4h_add_agreement', 10, 5);

add_filter('manage_edit-comments_columns', function ($columns) {
    $columns['attachment'] = __('Attachment');
    return $columns;
});

add_action('manage_comments_custom_column', function ($column, $comment_id) {
    if ('attachment' === $column) {
        $attachment = get_comment_meta($comment_id, 'attachment', true);
        $attachment_name = get_comment_meta($comment_id, 'attachment_name', true);
        echo "<a href='".$attachment."'>".$attachment_name."</a>";
    }
}, 10, 2);

function generate_capabilites_array($post_type) {
    global $capabilites;
    
    $return = array();
    foreach($capabilites as $capability) {
        $return[$capability] = $capability.'_'.$post_type;
    }
    
    return $return;
}

$ju4h_capabilites = array();

function add_custom_caps() {
    global $capabilites, $ju4h_capabilites;
    $post_types = array('ju4hsuggestion', 'ju4htopic', 'ju4htask');
    

    add_role('ju4h_administrator', __('JU4H Administrator/moderator'));
    $admin_role = get_role('ju4h_administrator');
    if ($admin_role) {
        $admin_role->add_cap('read');
        $admin_role->add_cap('upload_files');
        foreach ($post_types as $post_type) {
            $ju4h_capabilites[$post_type] = array();
            foreach ($capabilites as $capability) {
               $admin_role->add_cap($capability.'_'.$post_type);
            }
        }
    }

    $admin_post_types = array('ju4hsuggestion', 'ju4htopic', 'ju4htask', 'ju4hslide', 'ju4hagreement', 'ju4huseragreement');
    $administrator = get_role('administrator');
    if ($administrator) {
        foreach ($admin_post_types as $post_type) {
            $ju4h_capabilites[$post_type] = array();
            foreach ($capabilites as $capability) {
               $administrator->add_cap($capability.'_'.$post_type);
            }
        }
    }
    
    remove_role('ju4h_moderator');
    remove_role('ju4h_contributor');
    remove_role('ju4h_facilitator');
    
    $role = get_role('subscriber');
    if ($role) {
        $role->add_cap('edit_posts_ju4hsuggestion');
    }  
    
    $user = wp_get_current_user();
    if (in_array('subscriber', (array)$user->roles)) {
        $post_types_roles = array(
            'ju4hsuggestion' => array('moderator', 'facilitator', 'contributor'),
            'ju4htopic' => array('moderator', 'facilitator'),
            'ju4htask' => array('moderator', 'facilitator')
        );
        
        foreach ($post_types_roles as $post_type => $roles) {
            foreach ($roles as $role) {
                $query = new WP_Query(array(
                    'post_type'      => $post_type,
                    'posts_per_page' => -1,
                    'meta_query'     => array(
                        array(
                            'key'     => 'm_capabilites_ju4h_'.$role,
                            'value'   => get_current_user_id(),
                            'compare' => '=',
                        ),
                    ),
                ));

                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $ju4h_capabilites[$post_type][] = get_the_ID();
                    }
                }

                wp_reset_postdata();
            }
        }
    }
    
    $query = new WP_Query(array(
        'post_type'      => 'ju4hsuggestion',
        'posts_per_page' => -1,
        'author'         => get_current_user_id()
    ));

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $ju4h_capabilites['ju4hsuggestion'][] = get_the_ID();
        }
    }

    wp_reset_postdata();
}
add_action('init', 'add_custom_caps', 5 );

function remove_add_new_custom_post_type_capability() {
    global $pagenow;
    $user = wp_get_current_user();
    
    if (in_array('subscriber', (array)$user->roles)) {
        $custom_post_types = array('ju4hsuggestion', 'ju4htopic', 'ju4htask');

        foreach($custom_post_types as $custom_post_type) {
            remove_submenu_page("edit.php?post_type={$custom_post_type}", "post-new.php?post_type={$custom_post_type}");

            if ('post-new.php' === $pagenow && isset($_GET['post_type']) && $_GET['post_type'] === $custom_post_type && !current_user_can('publish_posts')) {
                wp_redirect(admin_url("edit.php?post_type={$custom_post_type}"));
                exit;
            }
        }
    }
}
add_action('admin_init', 'remove_add_new_custom_post_type_capability');

function hide_add_new_custom_post_type_button() {
    $user = wp_get_current_user();
    if (!in_array('subscriber', (array)$user->roles)) {
        return;
    }
    
    $post_types = array('ju4hsuggestion', 'ju4htopic', 'ju4htask');

    foreach ($post_types as $post_type) {
        $screen = get_current_screen();
        if (isset($screen->post_type) && $post_type === $screen->post_type) {
            echo '<style type="text/css">
                .page-title-action { display: none !important; }
            </style>';
        }
    }
}
add_action('admin_head', 'hide_add_new_custom_post_type_button');

function hide_comments_menu() {
    if (!current_user_can('moderate_comments')) { // Check if user does not have 'moderate_comments' capability
        remove_menu_page('edit-comments.php'); // Hide comments menu
    }
}
add_action('admin_menu', 'hide_comments_menu');


function remove_comments_column_for_custom_post_type($columns) {
    unset($columns['comments']);
    return $columns;
}

// Apply to specific post types only
add_filter('manage_ju4hsuggestion_posts_columns', 'remove_comments_column_for_custom_post_type');
add_filter('manage_ju4htopic_posts_columns', 'remove_comments_column_for_custom_post_type');
add_filter('manage_ju4htask_posts_columns', 'remove_comments_column_for_custom_post_type');

$cap_to_remove = array();

function custom_permission_check_pre($allcaps, $caps, $args) {
    global $ju4h_capabilites, $capabilites, $pagenow, $cap_to_remove;    
    
    $user = wp_get_current_user();
    if (!in_array('subscriber', (array)$user->roles)) {
        return $allcaps;
    }
    
    $post_types = array('ju4hsuggestion', 'ju4htopic', 'ju4htask');

    foreach ($cap_to_remove as $cap) {
        unset($allcaps[$cap]);
    }

    if (is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type'])) {
        foreach ($post_types as $post_type) {
            if (is_array($args) && count($args) == 2 && 
                $args[0] == 'edit_posts_'.$post_type && 
                isset($ju4h_capabilites[$post_type]) &&
                !empty($ju4h_capabilites[$post_type])) {
                $allcaps['edit_posts_'.$post_type] = true;
                $allcaps['edit_others_posts_'.$post_type] = true;
                $allcaps['edit_published_posts_'.$post_type] = true;
            }
            
            if (is_array($args) && count($args) == 2 && 
                $args[0] == 'edit_posts' &&
                isset($ju4h_capabilites[$post_type]) &&
                !empty($ju4h_capabilites[$post_type])) {
                $allcaps['edit_posts_'.$post_type] = true;
                $allcaps['edit_others_posts_'.$post_type] = true;
                $allcaps['edit_published_posts_'.$post_type] = true;
            }
            
            if (is_array($args) && count($args) == 3 && 
                $args[0] == 'edit_post' &&
                isset($ju4h_capabilites[$post_type]) &&
                !empty($ju4h_capabilites[$post_type]) &&
                in_array($args[2], $ju4h_capabilites[$post_type])) {
                $allcaps['edit_posts_'.$post_type] = true;
                $allcaps['edit_published_posts_'.$post_type] = true;
                $allcaps['edit_others_posts_'.$post_type] = true;
                $cap_to_remove[] = 'edit_published_posts_'.$post_type;
                $cap_to_remove[] = 'edit_others_posts_'.$post_type;
            }
        }        
    } else if (is_admin() && $pagenow == 'post.php' && isset($_GET['post'])) {
        $post = get_post($_GET['post']);
        $moderator_can = get_post_meta($_GET['post'], 'm_capabilites_ju4h_moderator', true) == get_current_user_id();
        $facilitator_can = get_post_meta($_GET['post'], 'm_capabilites_ju4h_facilitator', true) == get_current_user_id();
        $contributor_can = get_post_meta($_GET['post'], 'm_capabilites_ju4h_contributor', true) == get_current_user_id();
        
        if ($moderator_can) {
            $allcaps['moderate_comments'] = true;
        }
        
        if ($post->post_type == 'ju4hsuggestion' && ($moderator_can || $facilitator_can || $contributor_can)) {
            $allcaps['edit_posts_'.$post->post_type] = true;
            $allcaps['edit_published_posts_'.$post->post_type] = true;
            $allcaps['edit_others_posts_'.$post->post_type] = true;
            $allcaps['edit_post_'.$post->post_type] = true;
        } else if ($post->post_type == 'ju4htopic' && ($moderator_can || $facilitator_can)) {
            $allcaps['edit_posts_'.$post->post_type] = true;
            $allcaps['edit_published_posts_'.$post->post_type] = true;
            $allcaps['edit_others_posts_'.$post->post_type] = true;
            $allcaps['edit_post_'.$post->post_type] = true;            
        } else if ($post->post_type == 'ju4htask' && ($moderator_can || $facilitator_can)) {
            $allcaps['edit_posts_'.$post->post_type] = true;
            $allcaps['edit_published_posts_'.$post->post_type] = true;
            $allcaps['edit_others_posts_'.$post->post_type] = true;
            $allcaps['edit_post_'.$post->post_type] = true;            
        }
        
        foreach ($post_types as $post_type) {
            if (is_array($args) && count($args) == 2 && 
                $args[0] == 'edit_posts_'.$post_type && 
                $args[1] == get_current_user_id() &&
                isset($ju4h_capabilites[$post_type]) &&
                !empty($ju4h_capabilites[$post_type])) {
                $allcaps['edit_posts_'.$post_type] = true;
            }
        }
    } else if ($pagenow == 'upload.php') {
        foreach ($ju4h_capabilites as $ju4h_capability) {
            if (!empty($ju4h_capability)) {
                $allcaps['upload_files'] = true;
            }
        }
    } else if (is_admin() && $pagenow == 'post.php' && isset($_POST['post_ID'])) {
        $post = get_post($_POST['post_ID']);
        $moderator_can = get_post_meta($_POST['post_ID'], 'm_capabilites_ju4h_moderator', true) == get_current_user_id();
        $facilitator_can = get_post_meta($_POST['post_ID'], 'm_capabilites_ju4h_facilitator', true) == get_current_user_id();
        $contributor_can = get_post_meta($_POST['post_ID'], 'm_capabilites_ju4h_contributor', true) == get_current_user_id();
        
        if ($post->post_type == 'ju4hsuggestion' && ($moderator_can || $facilitator_can || $contributor_can)) {
            $allcaps['edit_posts_'.$post->post_type] = true;
            $allcaps['edit_published_posts_'.$post->post_type] = true;
            $allcaps['edit_others_posts_'.$post->post_type] = true;
            $allcaps['edit_post_'.$post->post_type] = true;
        } else if ($post->post_type == 'ju4htopic' && ($moderator_can || $facilitator_can)) {
            $allcaps['edit_posts_'.$post->post_type] = true;
            $allcaps['edit_published_posts_'.$post->post_type] = true;
            $allcaps['edit_others_posts_'.$post->post_type] = true;
            $allcaps['edit_post_'.$post->post_type] = true;            
        } else if ($post->post_type == 'ju4htask' && ($moderator_can || $facilitator_can)) {
            $allcaps['edit_posts_'.$post->post_type] = true;
            $allcaps['edit_published_posts_'.$post->post_type] = true;
            $allcaps['edit_others_posts_'.$post->post_type] = true;
            $allcaps['edit_post_'.$post->post_type] = true;
        }
        
        foreach ($post_types as $post_type) {
            if (is_array($args) && count($args) == 2 && 
                $args[0] == 'edit_posts_'.$post_type && 
                $args[1] == get_current_user_id() &&
                isset($ju4h_capabilites[$post_type]) &&
                !empty($ju4h_capabilites[$post_type])) {
                $allcaps['edit_posts_'.$post_type] = true;
            }
        }
    } else if (is_admin() && $pagenow == 'post-new.php') {
    } else if (is_admin() && $pagenow == 'admin-ajax.php' && isset($_REQUEST['p'])) {
        if (get_post_meta($_REQUEST['p'], 'm_capabilites_ju4h_moderator', true) == get_current_user_id()) {
            $post = get_post($_REQUEST['p']);
            $allcaps['moderate_comments'] = true;
            $allcaps['edit_posts_'.$post->post_type] = true;
            $allcaps['edit_published_posts_'.$post->post_type] = true;
            $allcaps['edit_others_posts_'.$post->post_type] = true;
            $allcaps['edit_post_'.$post->post_type] = true;
        }
    } else if (is_admin() && $pagenow == 'admin-ajax.php' && isset($_REQUEST['action']) && ($_REQUEST['action'] == 'replyto-comment' || $_REQUEST['action'] == 'edit-comment') && isset($_REQUEST['id'])) {
        $post = get_post($_REQUEST['id']);
        $roles = array(
            'ju4hsuggestion' => array('moderator'),
            'ju4htopic' => array('moderator', 'facilitator'),
            'ju4htask' => array('moderator', 'facilitator')
        );

        if ($post) {
            foreach ($roles[$post->post_type] as $role) {
                if (get_post_meta($post->ID, 'm_capabilites_ju4h_'.$role, true) == get_current_user_id()) {
                    $allcaps['moderate_comments'] = true;
                    $allcaps['edit_posts_'.$post->post_type] = true;
                    $allcaps['edit_published_posts_'.$post->post_type] = true;
                    $allcaps['edit_others_posts_'.$post->post_type] = true;
                    $allcaps['edit_post_'.$post->post_type] = true;
                }
            }
        }
    } else if (is_admin() && $pagenow == 'admin-ajax.php' && isset($_REQUEST['action']) && str_contains($_REQUEST['action'], '-comment') && isset($_REQUEST['id'])) {
        $comment = get_comment($_REQUEST['id']);
        
        if ($comment) {
            $roles = array(
                'ju4hsuggestion' => array('moderator'),
                'ju4htopic' => array('moderator', 'facilitator'),
                'ju4htask' => array('moderator', 'facilitator')
            );
            $post_id = $comment->comment_post_ID;
            $post = get_post($post_id);
            
            if ($post) {
                foreach ($roles[$post->post_type] as $role) {
                    if (get_post_meta($post->ID, 'm_capabilites_ju4h_'.$role, true) == get_current_user_id()) {
                        $allcaps['moderate_comments'] = true;
                        $allcaps['edit_posts_'.$post->post_type] = true;
                        $allcaps['edit_published_posts_'.$post->post_type] = true;
                        $allcaps['edit_others_posts_'.$post->post_type] = true;
                        $allcaps['edit_post_'.$post->post_type] = true;
                    }
                }
            }
        }
    } else if ($pagenow == 'transfer.php' && isset($_REQUEST['post_id'])) {
        $post = get_post($_REQUEST['post_id']);

        if ($post) {
            foreach ($post_types as $post_type) {
                $allcaps['edit_posts_'.$post_type] = true;
                $allcaps['edit_published_posts_'.$post_type] = true;
                $allcaps['edit_others_posts_'.$post_type] = true;
                $allcaps['edit_post_'.$post_type] = true;
            }
        }
    } else if (is_admin() && $pagenow == 'comment.php' && isset($_REQUEST['c'])) {
        $comment = get_comment($_REQUEST['c']);
        
        if ($comment) {
            $roles = array(
                'ju4hsuggestion' => array('moderator'),
                'ju4htopic' => array('moderator', 'facilitator'),
                'ju4htask' => array('moderator', 'facilitator')
            );
            $post_id = $comment->comment_post_ID;
            $post = get_post($post_id);
            
            if ($post) {
                foreach ($roles[$post->post_type] as $role) {
                    if (get_post_meta($post_id, 'm_capabilites_ju4h_'.$role, true) == get_current_user_id()) {
                        $allcaps['moderate_comments'] = true;
                        $allcaps['edit_posts_'.$post->post_type] = true;
                        $allcaps['edit_published_posts_'.$post->post_type] = true;
                        $allcaps['edit_others_posts_'.$post->post_type] = true;
                        $allcaps['edit_post_'.$post->post_type] = true;
                    }
                }
            }
        }
    } else if (is_admin()) {
        foreach ($post_types as $post_type) {
            if (is_array($args) && count($args) == 2 && 
                $args[0] == 'edit_posts_'.$post_type && 
                $args[1] == get_current_user_id() &&
                isset($ju4h_capabilites[$post_type]) &&
                !empty($ju4h_capabilites[$post_type])) {
                $allcaps['edit_posts_'.$post_type] = true;
            }
        }
    }
    
    return $allcaps;
}
add_filter('user_has_cap', 'custom_permission_check_pre', -10, 3);

function ju4h_post_wide_range($query) {
    global $ju4h_capabilites, $capabilites, $pagenow;
    
    $user = wp_get_current_user();
    if (!in_array('subscriber', (array)$user->roles)) {
        return;
    }
    
    if (is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $query->is_main_query()) {
        $post_types = array('ju4hsuggestion', 'ju4htopic', 'ju4htask');
        
        foreach ($post_types as $post_type) {
            if ($_GET['post_type'] == $post_type && $query->get('post_type') == $post_type && !empty($ju4h_capabilites[$post_type])) {
                $query->set('post__in', $ju4h_capabilites[$post_type]);
            }
        }
    }
}
add_action('pre_get_posts', 'ju4h_post_wide_range');

function hide_posts_menu_for_specific_role() {
    global $ju4h_capabilites, $capabilites, $pagenow;
    
    remove_menu_page('edit.php');
    
    $user = wp_get_current_user();
    if (!in_array('subscriber', (array)$user->roles)) {
        return;
    }
    
    foreach ($ju4h_capabilites as $capability => $post_list) {
        if (empty($post_list)) {
            remove_menu_page('edit.php?post_type='.$capability);
        }
    }
}
add_action( 'admin_menu', 'hide_posts_menu_for_specific_role' );
