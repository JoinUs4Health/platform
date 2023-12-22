<?php
require_once('../../../../wp-load.php');

$allowed_referers = array( //todo move to config
    get_site_url()."/wp-admin/post-new.php",
    get_site_url()."/wp-admin/post.php"
);

$server_http_referer = explode('?', $_SERVER['HTTP_REFERER'])[0];
$is_allowed_referer = false;

foreach ($allowed_referers as $allowed_referer) {
    if (strlen($server_http_referer) >= strlen($allowed_referer) && substr($server_http_referer, 0, strlen($allowed_referer)) == $allowed_referer) {
        $is_allowed_referer = true;
    }
}

if (!$is_allowed_referer) {
    exit;
}

if (!isset($_POST['post_id'])) {
    exit;
}

$user_id = get_current_user_id();
$original_post = get_post($_POST['post_id']);

if (!$original_post) {
    return new WP_Error('invalid_post', 'Post not found');
}

$new_post = array(
    'post_title'    => $original_post->post_title,
    'post_status'   => 'draft', // Set the status of the new post
    'post_type'     => 'ju4htopic',
    'author'        => get_current_user_id(),
);

$new_post_id = wp_insert_post($new_post);

if (is_wp_error($new_post_id)) {
    return $new_post_id;
}

$meta_keys = array(
    'm_contributes',
    'm_description',
    'm_description_de',
    'm_description_nl',
    'm_description_pl',
    'm_follows',
    'm_language',
    'm_source',
    'm_title_de',
    'm_title_nl',
    'm_title_pl',
    'm_votes',
    'm_votes_count',
);

foreach ($meta_keys as $key) {
    $meta_value = get_post_meta($original_post->ID, $key, true);
    if ($meta_value) {
        update_post_meta($new_post_id, $key, $meta_value);
    }
}

update_post_meta($new_post_id, 'm_capabilites_ju4h_moderator', get_current_user_id());

$reponse = new stdClass();
$reponse->url = home_url().'/wp-admin/post.php?post='.$new_post_id.'&action=edit';
echo json_encode($reponse);