<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function ju4hsuggestion_custom_post_type() {
    $labels = array(
        'name'                => _x('Suggestions', 'Post Type General Name'),
        'singular_name'       => _x('Suggestion', 'Post Type Singular Name'),
        'menu_name'           => __('Suggestions'),
        'parent_item_colon'   => __('Parent Suggestion'),
        'all_items'           => __('All Suggestions'),
        'view_item'           => __('View Suggestion'),
        'add_new_item'        => __('Add New Suggestion'),
        'add_new'             => __('Add New'),
        'edit_item'           => __('Edit Suggestion'),
        'update_item'         => __('Update Suggestion'),
        'search_items'        => __('Search Suggestion'),
        'not_found'           => __('Not Found'),
        'not_found_in_trash'  => __('Not found in Trash'),
    );

    $args = array(
        'label'               => __('Suggestions'),
        'description'         => __('Suggestions'),
        'labels'              => $labels,
        'supports'            => array('title', 'author', 'comments', 'revisions'),     
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'capability_type'     => 'ju4hsuggestion',
        'map_meta_cap'        => true,
        'capabilities'        => generate_capabilites_array('ju4hsuggestion'),
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
    
    register_post_type('ju4hsuggestion', $args);
}
add_action('init', 'ju4hsuggestion_custom_post_type', 0);

function add_meta_boxes_ju4hsuggestion_callback($post) {
    $can_transfer = ju4h_user_can_transfer_suggestion($post);
    
    add_meta_box('container_capabilites', __('Capabilites'), 'add_meta_box_ju4hsuggestion_capabilites_callback', 'ju4hsuggestion', 'normal', 'low');
    if ($can_transfer) {
        add_meta_box('container_transfer', __('Transfer suggestion to topic (only moderators)'), 'add_meta_box_ju4hsuggestion_transfer_callback', 'ju4hsuggestion', 'normal', 'low');
    }
    add_meta_box('container_followers_and_contributors', __('Followers, contributors & voters'), 'add_meta_box_ju4hsuggestion_followers_contributors_voters_callback', 'ju4hsuggestion', 'normal', 'low');
    add_meta_box('container_title', __('Title'), 'add_meta_box_ju4hsuggestion_title_callback', 'ju4hsuggestion', 'normal', 'low');
    add_meta_box('container_description', __('Description'), 'add_meta_box_ju4hsuggestion_description_callback', 'ju4hsuggestion', 'normal', 'low');
    add_meta_box('container_additional_fields', __('Additional fields'), 'add_meta_box_ju4hsuggestion_additional_fields_callback', 'ju4hsuggestion', 'normal', 'low');
}
add_action('add_meta_boxes_ju4hsuggestion', 'add_meta_boxes_ju4hsuggestion_callback');

function add_meta_box_ju4hsuggestion_capabilites_callback($post) {
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
                
        if (ju4h_can_add_someone_to_suggestion($role_index, $post)) {
            html_admin_select_box($role_value, 'm_capabilites_ju4h_'.$role_index, $users_select, get_post_meta($post->ID, "m_capabilites_ju4h_".$role_index, true), false);
        }
    }
}

function add_meta_box_ju4hsuggestion_additional_fields_callback($post) {
    global $meta_countries, $meta_languages, $meta_suggestion_types, $meta_stakeholder_group, $meta_suggestion_duration, $meta_suggestion_source, $meta_process, $meta_methods, $meta_contents;
    wp_nonce_field(basename( __FILE__ ), 'suggestion_additional_fields_nonce');
    html_admin_select_box(__('Language'), 'm_language', $meta_languages, get_post_meta($post->ID, "m_language", true), false);
    html_admin_select_box(__('Country'), 'm_country', $meta_countries, get_post_meta($post->ID, "m_country", true), false);
    html_admin_select_box(__('Targeted stakeholder group'), 'm_target_group', $meta_stakeholder_group, get_post_meta($post->ID, "m_target_group", true));
    html_admin_select_box(__('Type'), 'm_type', $meta_suggestion_types, get_post_meta($post->ID, "m_type", true));
    html_admin_select_box(__('Duration'), 'm_duration', $meta_suggestion_duration, get_post_meta($post->ID, "m_duration", true));
    html_admin_select_box(__('Source'), 'm_source', $meta_suggestion_source, get_post_meta($post->ID, "m_source", true));
    html_admin_select_box(__('Process'), 'm_infrastructure', $meta_process, get_post_meta($post->ID, "m_infrastructure", true));
    html_admin_select_box(__('Methodology'), 'm_methodology', $meta_methods, get_post_meta($post->ID, "m_methodology", true));
    html_admin_select_box(__('Content'), 'm_content', $meta_contents, get_post_meta($post->ID, "m_content", true));
}

function add_meta_box_ju4hsuggestion_transfer_callback($post) {
    ?>
    <script type="text/javascript" src="<?= home_url() ?>/wp-content/plugins/joinus4health/assets/js/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#m_transfer').click(function() {
                val_post_id = $(this).attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: "<?= home_url() ?>/wp-content/plugins/joinus4health/includes/transfer.php",
                    dataType: 'json',
                    data: {
                        post_id: val_post_id
                    },
                    success: function (data) {
                        if (data.url) {
                            window.location.href = data.url;
                        }
                    }
                });
            });
        });
    </script>
    <?php
    html_admin_button(__('Transfer suggestion to topic'), 'm_transfer', $post->ID);
}

function add_meta_box_ju4hsuggestion_followers_contributors_voters_callback($post) {
    $m_followers = get_post_meta($post->ID, 'm_follows');
    $m_contributors = get_post_meta($post->ID, 'm_contributes');
    $m_votes = get_post_meta($post->ID, 'm_votes');
    $users = array(__('Followers') => $m_followers, __('Contributors') => $m_contributors, __('Votes') => $m_votes);
    
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

/**
 * Adds meta box "Title"
 * - textarea field with description of topic
 * 
 * @param type $post
 */
function add_meta_box_ju4hsuggestion_title_callback($post) {
    global $meta_translations;
    foreach ($meta_translations as $key => $value) {
        echo '<p>'.$value.':<br>';
        html_admin_text("m_title_".$key, get_post_meta($post->ID, 'm_title_'.$key, true));
        echo '</p>';
    }
}

function add_meta_box_ju4hsuggestion_description_callback($post) {
    global $meta_translations;
    wp_nonce_field(basename( __FILE__ ), 'suggestion_description_nonce');
    echo '<p>English:<br>';
    html_admin_textarea("m_description", get_post_meta($post->ID, 'm_description', true));
    echo '</p>';
    foreach ($meta_translations as $key => $value) {
        echo '<p>'.$value.':<br>';
        html_admin_textarea("m_description_".$key, get_post_meta($post->ID, 'm_description_'.$key, true));
        echo '</p>';
    }
}

function save_post_ju4hsuggestion_callback($post_id) {
    global $meta_translations;
    
    if (!isset($_POST['suggestion_additional_fields_nonce']) || !wp_verify_nonce($_POST['suggestion_additional_fields_nonce'], basename(__FILE__))) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array("m_country", "m_language", "m_duration", "m_type", "m_source", "m_target_group", "m_description", "m_infrastructure", "m_methodology", "m_content");
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
    
    if (get_post_meta($post_id, 'm_votes_count', true) == '') {
        update_post_meta($post_id, 'm_votes_count', 0);
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
    
    $fields = array(
        'moderator',
        'facilitator',
        'contributor'
    );
    
    foreach ($fields as $value) {
        if (isset($_REQUEST['m_capabilites_ju4h_'.$value])) {
            if (ju4h_can_add_someone_to_suggestion($value, $post_id)) {
                update_post_meta($post_id, 'm_capabilites_ju4h_'.$value, esc_html($_POST['m_capabilites_ju4h_'.$value]));
            }
        }
    }
}
add_action('save_post_ju4hsuggestion', 'save_post_ju4hsuggestion_callback', 10, 2);

function manage_ju4hsuggestion_posts_columns_callback($columns) {
    $columns['country'] = __('Country');
    $columns['language'] = __('Language');
    $columns['type'] = __('Type');
    $columns['duration'] = __('Duration');
    return $columns;
}
add_filter('manage_ju4hsuggestion_posts_columns', 'manage_ju4hsuggestion_posts_columns_callback');

function manage_ju4hsuggestion_posts_custom_column_callback($column, $post_id) {
    global $meta_countries, $meta_languages, $meta_suggestion_types, $meta_suggestion_duration;
    
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
        if ($type != null && array_key_exists($type, $meta_suggestion_types)) {
            echo $meta_suggestion_types[$type];
        }
    }
    
    if ('duration' === $column) {
        $duration = get_post_meta($post_id, 'm_duration', true);
        if ($duration != null && array_key_exists($duration, $meta_suggestion_duration)) {
            echo $meta_suggestion_duration[$duration];
        }
    }
}
add_action('manage_ju4hsuggestion_posts_custom_column', 'manage_ju4hsuggestion_posts_custom_column_callback', 10, 2);

function ju4h_user_can_transfer_suggestion($post) {
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
    
    return false;
}

function ju4h_user_can_edit_specific_suggestion($post) {    
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

function ju4h_can_add_someone_to_suggestion($someone, $post) {
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
    
    $user = wp_get_current_user();
    
    if (in_array('subscriber', (array)$user->roles)) {
        if (get_post_meta($post_id, 'm_capabilites_ju4h_moderator', true) == get_current_user_id() && ($someone == 'facilitator')) {
            return true;
        }

        return false;
    } else {
        return true;
    }
}