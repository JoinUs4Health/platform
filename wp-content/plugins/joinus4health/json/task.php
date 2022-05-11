<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

header("Content-Type: application/json");

$meta = get_post_meta(get_the_ID());
$get_var_operation = $_GET['operation'];
$response = new stdClass();

if (!isset($meta['m_contributes'])) {
    $meta['m_contributes'] = array();
}

if (!is_user_logged_in()) {
    $response->error = __('You must be logged in', 'joinus4health');
} else if ($get_var_operation == 'contribute' && !in_array(get_current_user_id(), $meta['m_contributes'])) {
    add_post_meta(get_the_ID(), 'm_contributes', get_current_user_id());
} else if ($get_var_operation == 'uncontribute' && in_array(get_current_user_id(), $meta['m_contributes'])) {
    delete_post_meta(get_the_ID(), 'm_contributes', get_current_user_id());
} else {
    $response->error = __("You already make an operation", 'joinus4health');
}

$meta = get_post_meta(get_the_ID());
$response->contributes = isset($meta['m_contributes']) ? count($meta['m_contributes']) : 0;
update_post_meta(get_the_ID(), 'm_votes_count', $response->votes);

echo json_encode($response);