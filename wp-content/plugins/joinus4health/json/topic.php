<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

header("Content-Type: application/json");

$meta = get_post_meta(get_the_ID());
$get_var_operation = $_GET['operation'];
$response = new stdClass();

if (!isset($meta['m_votes'])) {
    $meta['m_votes'] = array();
}

if (!isset($meta['m_follows'])) {
    $meta['m_follows'] = array();
}

if (!isset($meta['m_contributes'])) {
    $meta['m_contributes'] = array();
}

if (!is_user_logged_in()) {
    $response->error = __('You must be logged in', 'joinus4health');
} else if ($get_var_operation == 'upvote' && !in_array(get_current_user_id(), $meta['m_votes'])) {
    add_post_meta(get_the_ID(), 'm_votes', get_current_user_id());
} else if ($get_var_operation == 'downvote' && in_array(get_current_user_id(), $meta['m_votes'])) {
    delete_post_meta(get_the_ID(), 'm_votes', get_current_user_id());
} else if ($get_var_operation == 'follow' && !in_array(get_current_user_id(), $meta['m_follows'])) {
    add_post_meta(get_the_ID(), 'm_follows', get_current_user_id());
} else if ($get_var_operation == 'unfollow' && in_array(get_current_user_id(), $meta['m_follows'])) {
    delete_post_meta(get_the_ID(), 'm_follows', get_current_user_id());
} else if ($get_var_operation == 'contribute' && !in_array(get_current_user_id(), $meta['m_contributes'])) {
    add_post_meta(get_the_ID(), 'm_contributes', get_current_user_id());
} else if ($get_var_operation == 'uncontribute' && in_array(get_current_user_id(), $meta['m_contributes'])) {
    delete_post_meta(get_the_ID(), 'm_contributes', get_current_user_id());
} else {
    $response->error = __("You already make an operation", 'joinus4health');
}

$meta = get_post_meta(get_the_ID());
$response->votes = isset($meta['m_votes']) ? count($meta['m_votes']) : 0;
$response->follows = isset($meta['m_follows']) ? count($meta['m_follows']) : 0;
$response->contributes = isset($meta['m_contributes']) ? count($meta['m_contributes']) : 0;
update_post_meta(get_the_ID(), 'm_votes_count', $response->votes);

echo json_encode($response);