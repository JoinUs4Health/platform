<?php
require_once('../../../../wp-load.php');

$response = array();

// Input validation
if (!is_user_logged_in()) {
    $response['error'] = 'To add comment you must be logged in';
} else if (!isset($_POST['comment']) || empty($_POST['comment'])) {
    $response['error'] = 'Comment is required';
} elseif (!isset($_POST['comment_post_ID']) || !is_numeric($_POST['comment_post_ID'])) {
    $response['error'] = 'Post ID is required and must be numeric';
} else {
    $comment_content = sanitize_text_field($_POST['comment']);
    $comment_post_ID = intval($_POST['comment_post_ID']);
    $comment_parent = isset($_POST['comment_parent']) ? intval($_POST['comment_parent']) : 0;

    // Check if post exists
    if (get_post($comment_post_ID) === null) {
        $response['error'] = 'Invalid Post ID';
    } else {
        $current_user = wp_get_current_user();
        
        // Prepare comment data
        $commentdata = array(
            'comment_content' => $comment_content,
            'comment_post_ID' => $comment_post_ID,
            'comment_parent' => $comment_parent,
            'user_id' => $current_user->ID,
            'comment_author' => $current_user->display_name,
            'comment_author_email' => $current_user->user_email,
            'comment_approved' => 0
        );

        // Insert comment and get comment ID
        $comment_id = wp_insert_comment($commentdata);

        if ($comment_id !== 0) {
            $response['success'] = 'Comment added';
            $response['comment_id'] = $comment_id;
            
            if (isset($_POST['comment_filename']) && isset($_POST['comment_filepath'])) {
                add_comment_meta($comment_id, 'attachment', $_POST['comment_filepath']);
                add_comment_meta($comment_id, 'attachment_name', $_POST['comment_filename']);
            }
        } else {
            $response['error'] = 'Failed to add comment';
        }
    }
}

// Output response
header('Content-Type: application/json');
echo json_encode($response);
