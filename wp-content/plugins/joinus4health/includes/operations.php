<?php
require_once('../../../../wp-load.php');

$response = new stdClass();
$response->status = 400;

if (!isset($_POST['operation'])) {
    echo json_encode($response);
    exit;
}

if (!isset($_POST['wpnonce']) ) {
    echo json_encode($response);
    exit;
}

$user = wp_get_current_user();
$user_id = $user->ID;
if (!wp_verify_nonce($_POST['wpnonce'], 'delete-user-id-'.$user_id)) {
    echo json_encode($response);
    exit;
}

if ($_POST['operation'] == 'delete-user') {
    $response->status = 200;
    bp_core_delete_account($user_id);
    echo json_encode($response);
    exit;
}

if ($_POST['operation'] == 'consent-user') {
    if (!isset($_POST['consentids'])) {
        exit;
    }
    
    $response->status = 200;

    foreach ($_POST['consentids'] as $value) {
        $new = array(
            'post_title'   => 'Consent of user #'.$user_id.' at '.time(),
            'post_status'  => 'publish',
            'post_type'    => 'ju4huseragreement',
        );

        $post_id = wp_insert_post($new);
        add_post_meta($post_id, 'm_consent_user_id', $user_id);
        add_post_meta($post_id, 'm_consent_id', $value);
        add_post_meta($post_id, 'm_post_value', '1');
    }
    
    echo json_encode($response);
    exit;
}
