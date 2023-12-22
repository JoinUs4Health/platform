<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function ju4htask_custom_post_type() {
    $labels = array(
        'name'                => _x('Tasks', 'Post Type General Name'),
        'singular_name'       => _x('Task', 'Post Type Singular Name'),
        'menu_name'           => __('Tasks'),
        'parent_item_colon'   => __('Parent Task'),
        'all_items'           => __('All Tasks'),
        'view_item'           => __('View Task'),
        'add_new_item'        => __('Add New Task'),
        'add_new'             => __('Add New'),
        'edit_item'           => __('Edit Task'),
        'update_item'         => __('Update Task'),
        'search_items'        => __('Search Task'),
        'not_found'           => __('Not Found'),
        'not_found_in_trash'  => __('Not found in Trash'),
    );

    $args = array(
        'label'               => __('Tasks'),
        'description'         => __('Tasks'),
        'labels'              => $labels,
        'supports'            => array('title', 'author', 'comments', 'revisions'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'capability_type'     => 'ju4htask',
        'map_meta_cap'        => true,
        'capabilities'        => generate_capabilites_array('ju4htask'),
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
    );
    
    register_post_type('ju4htask', $args);
}
add_action('init', 'ju4htask_custom_post_type', 0);

function add_meta_boxes_ju4htask_callback($post) {
    $upload_max_size = ini_get('upload_max_filesize');
    add_meta_box('container_capabilites', __('Capabilites'), 'add_meta_box_ju4htask_capabilites_callback', 'ju4htask', 'normal', 'low');
    add_meta_box('container_followers_and_contributors', __('Contributors'), 'add_meta_box_ju4htask_contributors_callback', 'ju4htask', 'normal', 'low');
    add_meta_box('container_title', __('Title'), 'add_meta_box_ju4htask_title_callback', 'ju4htask', 'normal', 'low');
    add_meta_box('container_description', __('Description'), 'add_meta_box_ju4htask_description_callback', 'ju4htask', 'normal', 'low');
    add_meta_box('container_additional_fields', __('Additional fields'), 'add_meta_box_ju4htask_additional_fields_callback', 'ju4htask', 'normal', 'low');
    add_meta_box('container_attachments', __('Attachments').' (max file size: '.$upload_max_size.')', 'add_meta_box_ju4htask_attachments_callback', 'ju4htask', 'normal', 'low');
}
add_action('add_meta_boxes_ju4htask', 'add_meta_boxes_ju4htask_callback');

function add_meta_box_ju4htask_capabilites_callback($post) {
    $roles = array(
        'moderator' => __('Moderator'), 
        'facilitator' => __('Facilitator'), 
        'contributor' => __('Contributor')
    );
    
    foreach ($roles as $role_index => $role_value) {
        $users = get_users(array('role' => 'subscriber'));
        $users_select = array("" => "None");
        
        foreach ($users as $user) {
            $users_select[$user->ID] = $user->data->display_name;
        }
        
        if (ju4h_can_add_someone_to_topic($role_index, $post)) {
            html_admin_select_box($role_value, 'm_capabilites_ju4h_'.$role_index, $users_select, get_post_meta($post->ID, "m_capabilites_ju4h_".$role_index, true), false);
        }
    }
}

function add_meta_box_ju4htask_contributors_callback($post) {
    $m_contributors = get_post_meta($post->ID, 'm_contributes');
    $users = array(_('Contributors') => $m_contributors);
    
    foreach ($users as $caption => $list) {
        $i = 0;
        echo '<p><b>'.$caption.'</b>';
        if (!empty($list)) {
            $user_names = array();
            $query = new WP_User_Query(array('include' => $list));
            foreach ($query->get_results() as $user) {
                $user_names[] = $user->display_name;
                echo (($i++ == 0) ? ': ' : ', ').'<a href="'. bp_core_get_userlink($user->ID, false, true).'">'.$user->display_name.'</a>';
            }
            echo ', <a href="'.bp_core_get_userlink(get_current_user_id(), false, true).'messages/compose/#'.join(',', $user_names).'">[Send message]</a>';
        } else {
            echo ': '._('No users found.');
        }
        echo '</p>';
    }
}

function add_meta_box_ju4htask_additional_fields_callback($post) {
    global $meta_languages, $meta_task_types, $meta_stakeholder_group, $meta_task_duration, $meta_task_level, $meta_task_source, $meta_task_status;
    wp_nonce_field(basename( __FILE__ ), 'task_additional_fields_nonce');
    $topics = array();
    $query = new WP_Query(array('post_type' => 'ju4htopic', 'posts_per_page' => -1));
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $postloop = $query->post;
            $meta = get_post_meta($postloop->ID);
            $topics[$postloop->ID] = $postloop->post_title;
        }
    }
    
    $meta_task_status_copy = $meta_task_status;
    if (!ju4h_can_change_to_close_task($post)) {
        unset($meta_task_status_copy[2]);
    }
    
    html_admin_select_box(__('Status'), 'm_status', $meta_task_status_copy, get_post_meta($post->ID, 'm_status', true));
    html_admin_select_box(__('Language'), 'm_language', $meta_languages, get_post_meta($post->ID, "m_language", true), false);
    html_admin_select_box(__('Duration'), 'm_duration', $meta_task_duration, get_post_meta($post->ID, "m_duration", true));
    html_admin_select_box(__('Type'), 'm_type', $meta_task_types, get_post_meta($post->ID, "m_type", true));
    html_admin_select_box(__('Level'), 'm_level', $meta_task_level, get_post_meta($post->ID, "m_level", true), false);
    html_admin_select_box(__('Source'), 'm_source', $meta_task_source, get_post_meta($post->ID, "m_source", true), false);
    html_admin_select_box(__('Targeted stakeholder group'), 'm_target_group', $meta_stakeholder_group, get_post_meta($post->ID, "m_target_group", true));
    html_admin_date_input(__('Valid thru'), 'm_valid_thru', get_post_meta($post->ID, 'm_valid_thru', true));    
    html_admin_select_box(__('Related topic'), 'm_related_topic', $topics, get_post_meta($post->ID, 'm_related_topic', true));
}

/**
 * Adds meta box "Title"
 * - textarea field with description of topic
 * 
 * @param type $post
 */
function add_meta_box_ju4htask_title_callback($post) {
    global $meta_translations;
    foreach ($meta_translations as $key => $value) {
        echo '<p>'.$value.':<br>';
        html_admin_text("m_title_".$key, get_post_meta($post->ID, 'm_title_'.$key, true));
        echo '</p>';
    }
}

function add_meta_box_ju4htask_description_callback($post) {
    global $meta_translations;
    wp_nonce_field(basename( __FILE__ ), 'task_description_nonce');
    echo '<p>English:<br>';
    html_admin_textarea("m_description", get_post_meta($post->ID, 'm_description', true));
    echo '</p>';
    foreach ($meta_translations as $key => $value) {
        echo '<p>'.$value.':<br>';
        html_admin_textarea("m_description_".$key, get_post_meta($post->ID, 'm_description_'.$key, true));
        echo '</p>';
    }
}

function save_post_ju4htask_callback($post_id) {
    global $meta_translations;
    
    if (!isset($_POST['task_additional_fields_nonce']) || !wp_verify_nonce($_POST['task_additional_fields_nonce'], basename(__FILE__))) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    
    //
    if (isset($_POST['m_attachments_file']) && is_array($_POST['m_attachments_file']) && isset($_POST['m_attachments_text']) && is_array($_POST['m_attachments_text'])) {
        $_POST_attachments = array();
        
        foreach ($_POST['m_attachments_file'] as $index => $value) {
            $obj = new stdClass();
            $obj->file = $_POST['m_attachments_file'][$index];
            $obj->text = $_POST['m_attachments_text'][$index];
            $obj->url = $_POST['m_attachments_url'][$index];
            $obj->license = $_POST['m_attachments_license'][$index];
            $obj->license_holder = $_POST['m_attachments_holder'][$index];
            $obj->user_id = get_current_user_id();
            $obj->check = ($_POST['m_attachments_check'][$index] == 1) ? 1 : 0;
            $_POST_attachments[] = str_replace('\/', '/', json_encode($obj));
    
        }

        $_POST_attachments = array_diff($_POST_attachments, array(""));
    } else {
        $_POST_attachments = array();
    }
    
    //getting attachments
    $attachments = get_post_meta($post_id, 'm_attachments');

    //making intersection between attachments from POST & existing attachments
    //result should be keeped in db
    $attachments_intersect = array_intersect($_POST_attachments, $attachments);

    //removing attachments which should be keeped from POSTed attachments
    //result will be added to db
    $attachments_to_add = array_diff($_POST_attachments, $attachments_intersect);
    
    //removing attachments which should be keeped from existing attachments
    //result will be removed from db
    $attachments_to_remove = array_diff($attachments, $attachments_intersect);

    //looping add operation of new attachments
    foreach ($attachments_to_add as $value) {
        add_post_meta($post_id, 'm_attachments', $value);
    }

    //looping remove operation of related suggestions which should be removed
    foreach ($attachments_to_remove as $value) {
        delete_post_meta($post_id, 'm_attachments', $value);
    }
    
    $fields = array("m_language", "m_duration", "m_type", "m_level", "m_source", "m_target_group", "m_description", "m_related_topic");
    foreach ($meta_translations as $key => $value) {
        $fields[] = 'm_title_'.$key;
        $fields[] = 'm_description_'.$key;
    }
    
    foreach ($fields as $value) {
        if (!isset($_POST[$value])) {
            add_settings_error('missing-fields', 'missing-fields', __("You must fill all fields"), 'error');
            set_transient('settings_errors', get_settings_errors(), 30);
            return;
        }
    }
    
    foreach ($fields as $value) {
        if (isset($_REQUEST[$value])) {
            if ($_REQUEST[$value] == '') {
                delete_post_meta($post_id, $value);
            } else {
                update_post_meta($post_id, $value, esc_html($_POST[$value]));
            }
        }
    }
    
    $roles = array(
        'moderator' => __('Moderator'), 
        'facilitator' => __('Facilitator'), 
        'contributor' => __('Contributor')
    );
    
     
    foreach ($roles as $value) {
        if (isset($_REQUEST[$value])) {
            if ($_REQUEST['m_capabilites_ju4h_'.$value] != '' && ju4h_can_add_someone_to_task($value, $post_id)) {
                update_post_meta($post_id, 'm_capabilites_ju4h_'.$value, esc_html($_POST['m_capabilites_ju4h_'.$value]));
            }
        }
    }
    
    if (isset($_POST['m_valid_thru_d']) && isset($_POST['m_valid_thru_m']) && isset($_POST['m_valid_thru_Y']) &&
            is_numeric($_POST['m_valid_thru_d']) && is_numeric($_POST['m_valid_thru_m']) && is_numeric($_POST['m_valid_thru_Y'])) {
        $time = DateTime::createFromFormat("d-m-Y", $_POST['m_valid_thru_d'].'-'.$_POST['m_valid_thru_m'].'-'.$_POST['m_valid_thru_Y']);
        update_post_meta($post_id, 'm_valid_thru', $time->getTimestamp());
    } else {
        update_post_meta($post_id, 'm_valid_thru', '');
    }
    
    $fields = array(
        'moderator',
        'facilitator',
        'contributor'
    );
    
    foreach ($fields as $value) {
        if (isset($_REQUEST['m_capabilites_ju4h_'.$value])) {
            if (ju4h_can_add_someone_to_topic($value, $post_id)) {
                update_post_meta($post_id, 'm_capabilites_ju4h_'.$value, esc_html($_POST['m_capabilites_ju4h_'.$value]));
            }
        }
    }
}
add_action('save_post_ju4htask', 'save_post_ju4htask_callback', 10, 2);

function manage_ju4htask_posts_columns_callback($columns) {
    $columns['country'] = __('Country');
    $columns['language'] = __('Language');
    $columns['type'] = __('Type');
    $columns['duration'] = __('Duration');
    return $columns;
}
add_filter('manage_ju4htask_posts_columns', 'manage_ju4htask_posts_columns_callback');

function manage_ju4htask_posts_custom_column_callback($column, $post_id) {
    global $meta_countries, $meta_task_types, $meta_languages, $meta_task_duration;
    
    if ('country' === $column) {
        $country = get_post_meta($post_id, 'm_country', true);
        if ($country != null && array_key_exists($country, $meta_countries)) {
            echo $meta_countries[$country];
        }
    }

    if ('language' === $column) {
        $language = get_post_meta($post_id, 'm_language', true);
        if ($language != null && array_key_exists($language, $meta_languages)) {
            echo $meta_languages[$language];
        }
    }
    
    if ('type' === $column) {
        $type = get_post_meta($post_id, 'm_type', true);
        if ($type != null && array_key_exists($type, $meta_task_types)) {
            echo $meta_task_types[$type];
        }
    }
    
    if ('duration' === $column) {
        $duration = get_post_meta($post_id, 'm_duration', true);
        if ($duration != null && array_key_exists($duration, $meta_task_duration)) {
            echo $meta_task_duration[$duration];
        }
    }
}
add_action('manage_ju4htask_posts_custom_column', 'manage_ju4htask_posts_custom_column_callback', 10, 2);

function add_meta_box_ju4htask_attachments_callback($post) {
    wp_nonce_field(basename( __FILE__ ), 'topic_attachments_nonce');
    html_admin_file_multiple_meta_box($post, 'attachments');
}

function ju4h_can_add_someone_to_task($someone, $post) {
    $user = wp_get_current_user();
    if (!in_array('subscriber', (array)$user->roles)) {
        return true;
    }
    
    if (is_int($post)) {
        $post_id = $post;
    } else if (is_object($post)) {
        $post_id = $post->ID;
    } else {
        return false;
    }
    if (get_post_meta($post_id, 'm_capabilites_ju4h_moderator', true) == get_current_user_id() && ($someone == 'facilitator')) {
        return true;
    }

    return false;
}

function ju4h_can_change_to_close_task($post) {
    $user = wp_get_current_user();
    if (!in_array('subscriber', (array)$user->roles)) {
        return true;
    }
    
    if (is_int($post)) {
        $post_id = $post;
    } else if (is_object($post)) {
        $post_id = $post->ID;
    } else {
        return false;
    }
    
    if (get_post_meta($post_id, 'm_capabilites_ju4h_moderator', true) == get_current_user_id()) {
        return true;
    }
    if (get_post_meta($post_id, 'm_capabilites_ju4h_facilitator', true) == get_current_user_id()) {
        return true;
    }

    return false;    
}