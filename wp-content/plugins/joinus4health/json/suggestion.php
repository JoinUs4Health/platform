<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

header("Content-Type: application/json");

$meta = get_post_meta(get_the_ID());
$get_var_operation = $_GET['operation'];
$response = new stdClass();

if (!is_user_logged_in()) {
    $response->error = __('User must be logged in to vote');
} else if ($get_var_operation == 'upvote' && !in_array(get_current_user_id(), $meta['m_votes'])) {
    add_post_meta(get_the_ID(), 'm_votes', get_current_user_id());
} else if ($get_var_operation == 'downvote' && in_array(get_current_user_id(), $meta['m_votes'])) {
    delete_post_meta(get_the_ID(), 'm_votes', get_current_user_id());
} else {
    $response->error = __("You already voted");
}

$meta = get_post_meta(get_the_ID());
$response->votes = count($meta['m_votes']);
update_post_meta(get_the_ID(), 'm_votes_count', $response->votes);

echo json_encode($response);