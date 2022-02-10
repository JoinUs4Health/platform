<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

header("Content-Type: application/json");

$meta = get_post_meta(get_the_ID());
$get_var_operation = $_GET['operation'];
$response = new stdClass();

if (!is_user_logged_in()) {
    $response->error = __('You must be logged in', 'joinus4health');
} else if ($get_var_operation == 'upvote' && isset ($meta['m_votes']) && !in_array(get_current_user_id(), $meta['m_votes'])) {
    add_post_meta(get_the_ID(), 'm_votes', get_current_user_id());
} else if ($get_var_operation == 'downvote' && isset ($meta['m_votes']) && in_array(get_current_user_id(), $meta['m_votes'])) {
    delete_post_meta(get_the_ID(), 'm_votes', get_current_user_id());
} else if ($get_var_operation == 'follow' && isset ($meta['m_follows']) && !in_array(get_current_user_id(), $meta['m_follows'])) {
    add_post_meta(get_the_ID(), 'm_follows', get_current_user_id());
} else if ($get_var_operation == 'unfollow' && isset ($meta['m_follows']) && in_array(get_current_user_id(), $meta['m_follows'])) {
    delete_post_meta(get_the_ID(), 'm_follows', get_current_user_id());
} else if ($get_var_operation == 'contribute' && isset ($meta['m_contributes']) && !in_array(get_current_user_id(), $meta['m_contributes'])) {
    add_post_meta(get_the_ID(), 'm_contributes', get_current_user_id());
} else if ($get_var_operation == 'uncontribute' && isset ($meta['m_contributes']) && in_array(get_current_user_id(), $meta['m_contributes'])) {
    delete_post_meta(get_the_ID(), 'm_contributes', get_current_user_id());
} else {
    $response->error = __("You already voted", 'joinus4health');
}

$meta = get_post_meta(get_the_ID());
$response->votes = count(isset($meta['m_votes']) ? $meta['m_votes'] : 0);
$response->follows = count(isset($meta['m_follows']) ? $meta['m_follows'] : 0);
$response->contributes = count(isset($meta['m_contributes']) ? $meta['m_contributes'] : 0);
update_post_meta(get_the_ID(), 'm_votes_count', $response->votes);

echo json_encode($response);