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
} else if ($get_var_operation == 'upvote' && !in_array(get_current_user_id(), $meta['m_votes'])) {
    add_post_meta(get_the_ID(), 'm_votes', get_current_user_id());
    add_post_meta(get_the_ID(), 'm_votes_time', get_current_user_id().":".time());
} else if ($get_var_operation == 'downvote' && in_array(get_current_user_id(), $meta['m_votes'])) {
    $meta_votes_time = $meta['m_votes_time'];

    foreach ($meta_votes_time as $index => $m_vote_time) {
        if (explode(':', $m_vote_time)[0] == get_current_user_id()) {
            delete_post_meta(get_the_ID(), 'm_votes_time', $m_vote_time);
        }

        if (explode(':', $m_vote_time)[1] < (time() - 24*3600)) {
            delete_post_meta(get_the_ID(), 'm_votes_time', $m_vote_time);
        }
    }

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
$response->votes = count($meta['m_votes']);
$response->follows = count($meta['m_follows']);
$response->contributes = count($meta['m_contributes']);
update_post_meta(get_the_ID(), 'm_votes_count', $response->votes);
update_post_meta(get_the_ID(), 'm_trending_votes', count($meta['m_votes_time']));

echo json_encode($response);