<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Creates topic tag taxonomy
 */
function create_ju4htopictag_taxonomy() { 
    $labels = array(
        'name' => __( 'Topic tags'),
        'singular_name' => __( 'Topic tag'),
        'search_items' =>  __( 'Search Topic tags' ),
        'popular_items' => __( 'Popular Topic tags' ),
        'all_items' => __( 'All Topic tags' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Edit Topic tag' ), 
        'update_item' => __( 'Update Topic tag' ),
        'add_new_item' => __( 'Add New Topic tag' ),
        'new_item_name' => __( 'New Topic tag' ),
        'separate_items_with_commas' => __( 'Separate topic tags with commas' ),
        'add_or_remove_items' => __( 'Add or remove topic tags' ),
        'choose_from_most_used' => __( 'Choose from the most used topic tags' ),
        'menu_name' => __( 'Topic tags' ),
    );

    register_taxonomy('ju4htopictag','ju4htopic',array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'ju4htopictag' ),
    ));
}
add_action('init', 'create_ju4htopictag_taxonomy', 0); 

/**
 * Creates custom post type 'topic'
 */
function ju4htopic_custom_post_type() {
    $labels = array(
        'name'                => _x('Topics', 'Post Type General Name'),
        'singular_name'       => _x('Topic', 'Post Type Singular Name'),
        'menu_name'           => __('Topics'),
        'parent_item_colon'   => __('Parent Topic'),
        'all_items'           => __('All Topics'),
        'view_item'           => __('View Topic'),
        'add_new_item'        => __('Add New Topic'),
        'add_new'             => __('Add New'),
        'edit_item'           => __('Edit Topic'),
        'update_item'         => __('Update Topic'),
        'search_items'        => __('Search Topic'),
        'not_found'           => __('Not Found'),
        'not_found_in_trash'  => __('Not found in Trash'),
    );

    $args = array(
        'label'               => __('Topics'),
        'description'         => __('Topics'),
        'labels'              => $labels,
        'supports'            => array('title', 'author', 'comments', 'revisions'),     
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'capability_type'     => 'ju4htopic',
        'map_meta_cap'        => true,
        'capabilities'        => generate_capabilites_array('ju4htopic'),
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
    
    register_post_type('ju4htopic', $args);
}
add_action('init', 'ju4htopic_custom_post_type', 0);

/**
 * Adds new meta boxes to create/edit post form
 * 
 * @param type $post
 */
function add_meta_boxes_ju4htopic_callback($post) {
    $upload_max_size = ini_get('upload_max_filesize');
    add_meta_box('container_capabilites', __('Capabilites'), 'add_meta_box_ju4htopic_capabilites_callback', 'ju4htopic', 'normal', 'low');
    add_meta_box('container_followers_and_contributors', __('Followers, contributors & voters'), 'add_meta_box_ju4htopic_followers_contributors_voters_callback', 'ju4htopic', 'normal', 'low');
    add_meta_box('container_topimage', __('Top image').' (best size: 1228x346) (max file size: '.$upload_max_size.')', 'add_meta_box_ju4htopic_topimage_callback', 'ju4htopic', 'normal', 'low');
    add_meta_box('container_title', __('Title'), 'add_meta_box_ju4htopic_title_callback', 'ju4htopic', 'normal', 'low');
    add_meta_box('container_intro', __('Introduction'), 'add_meta_box_ju4htopic_intro_callback', 'ju4htopic', 'normal', 'low');
    add_meta_box('container_description', __('Description'), 'add_meta_box_ju4htopic_description_callback', 'ju4htopic', 'normal', 'low');
    add_meta_box('container_additional_fields', __('Additional fields'), 'add_meta_box_ju4htopic_additional_fields_callback', 'ju4htopic', 'normal', 'low');
    add_meta_box('container_suggestions', __('Related suggestions'), 'add_meta_box_ju4htopic_related_suggestions_callback', 'ju4htopic', 'normal', 'low');
    add_meta_box('container_tasks', __('Related tasks'), 'add_meta_box_ju4htopic_related_tasks_callback', 'ju4htopic', 'normal', 'low');
    add_meta_box('container_attachments', __('Attachments').' (max file size: '.$upload_max_size.')', 'add_meta_box_ju4htopic_attachments_callback', 'ju4htopic', 'normal', 'low');
    add_meta_box('container_externals', __('External links'), 'add_meta_box_ju4htopic_externals_callback', 'ju4htopic', 'normal', 'low');
    add_meta_box('container_report_url', __('Report URL'), 'add_meta_box_ju4htopic_report_url', 'ju4htopic', 'normal', 'low');
    add_meta_box('container_groups', __('Related groups'), 'add_meta_box_ju4htopic_related_groups_callback', 'ju4htopic', 'normal', 'low');
}
add_action('add_meta_boxes_ju4htopic', 'add_meta_boxes_ju4htopic_callback');

function add_meta_box_ju4htopic_capabilites_callback($post) {
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

/**
 * 
 * 
 * @param type $post
 */
function add_meta_box_ju4htopic_followers_contributors_voters_callback($post) {
    $m_followers = get_post_meta($post->ID, 'm_follows');
    $m_contributors = get_post_meta($post->ID, 'm_contributes');
    $m_votes = get_post_meta($post->ID, 'm_votes');
    $users = array(_('Followers') => $m_followers, _('Contributors') => $m_contributors, _('Votes') => $m_votes);
    
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
 * Adds meta box "Description"
 * - textarea field with description of topic
 * 
 * @param type $post
 */
function add_meta_box_ju4htopic_intro_callback($post) {
    global $meta_translations;
    wp_nonce_field(basename( __FILE__ ), 'topic_intro_nonce');
    echo '<p>English:<br>';
    html_admin_textarea("m_intro", get_post_meta($post->ID, 'm_intro', true));
    echo '</p>';
    foreach ($meta_translations as $key => $value) {
        echo '<p>'.$value.':<br>';
        html_admin_textarea("m_intro_".$key, get_post_meta($post->ID, 'm_intro_'.$key, true));
        echo '</p>';
    }
}

/**
 * Adds meta box "Title"
 * - text field with title of topic
 * 
 * @param type $post
 */
function add_meta_box_ju4htopic_title_callback($post) {
    global $meta_translations;
    foreach ($meta_translations as $key => $value) {
        echo '<p>'.$value.':<br>';
        html_admin_text("m_title_".$key, get_post_meta($post->ID, 'm_title_'.$key, true));
        echo '</p>';
    }
}

/**
 * Adds meta box "Description"
 * - textarea field with description of topic
 * 
 * @param type $post
 */
function add_meta_box_ju4htopic_description_callback($post) {
    global $meta_translations;
    wp_nonce_field(basename( __FILE__ ), 'topic_description_nonce');
    echo '<p>English:<br>';
    html_admin_textarea("m_description", get_post_meta($post->ID, 'm_description', true));
    echo '</p>';
    foreach ($meta_translations as $key => $value) {
        echo '<p>'.$value.':<br>';
        html_admin_textarea("m_description_".$key, get_post_meta($post->ID, 'm_description_'.$key, true));
        echo '</p>';
    }
}

/**
 * Adds meta box "Additional fields"
 * - select field with status of topic
 * 
 * @param type $post
 */
function add_meta_box_ju4htopic_additional_fields_callback($post) {
    global $meta_topic_status, $meta_languages, $meta_topic_source, $meta_stakeholder_group;
    wp_nonce_field(basename( __FILE__ ), 'topic_additional_fields_nonce');
    $topics = array();
    $query = new WP_Query(array('post_type' => 'forum', 'posts_per_page' => -1));
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $postloop = $query->post;
            $meta = get_post_meta($postloop->ID);
            $topics[$postloop->ID] = $postloop->post_title;
        }
    }
    
    $meta_topic_status_copy = $meta_topic_status;
    if (!ju4h_can_change_to_close_topic($post)) {
        unset($meta_topic_status_copy[3]);
    }
    
    html_admin_select_box(__('Language'), 'm_language', $meta_languages, get_post_meta($post->ID, "m_language", true), false);
    html_admin_select_box(__('Status'), 'm_status', $meta_topic_status_copy, get_post_meta($post->ID, 'm_status', true));
    html_admin_select_box(__('Targeted stakeholder group'), 'm_target_group', $meta_stakeholder_group, get_post_meta($post->ID, "m_target_group", true));
    html_admin_select_box(__('Source'), 'm_source', $meta_topic_source, get_post_meta($post->ID, "m_source", true));
    html_admin_date_input(__('Valid thru'), 'm_valid_thru', get_post_meta($post->ID, 'm_valid_thru', true));
}

/**
 * Adds meta box "Related suggestions"
 * - select field with related suggestion
 * - anchors to add new related suggestion
 * - anchors to remove existing related suggestion
 * 
 * @param type $post
 */
function add_meta_box_ju4htopic_related_suggestions_callback($post) {    
    wp_nonce_field(basename( __FILE__ ), 'topic_related_suggestions_nonce');
    $topics = array();
    $query = new WP_Query(array('post_type' => 'ju4hsuggestion', 'posts_per_page' => -1));
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $postloop = $query->post;
            $meta = get_post_meta($postloop->ID);
            $topics[$postloop->ID] = $postloop->post_title;
        }
    }
    
    
    
    $related_suggestions = get_post_meta($post->ID, 'm_related_suggestions');
    echo '<div id="related-suggestions">';
    
    foreach ($related_suggestions as $related_suggestion) {
        echo '<p><label>'.__('Suggestion').'</label>&nbsp;&nbsp;&nbsp;<select name="m_related_suggestions[]">';
        echo '<option value="">None</option>';
        foreach ($topics as $key => $value) {
            $selected = '';
            if ($key == $related_suggestion) {
                $selected = ' selected';
            }
            echo '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
        }
        echo '</select>&nbsp;&nbsp;&nbsp;<a class="related-suggestion-remove" style="cursor: pointer">'.__('Remove suggestion').'</a>';
        echo '</p>';
    }
    echo '</div>';
    
    $append_html = '<p><label>'.__('Suggestion').'</label>&nbsp;&nbsp;&nbsp;<select name="m_related_suggestions[]">';
    $append_html .= '<option value="">None</option>';
    foreach ($topics as $key => $value) {
        $append_html .= '<option value="'.$key.'">'.$value.'</option>';
    }
    $append_html .= '</select>&nbsp;&nbsp;&nbsp;<a class="related-suggestion-remove" style="cursor: pointer">'.__('Remove suggestion').'</a>';
    $append_html .= '</p>';
    ?>
    
    <script type="text/javascript" src="<?= home_url() ?>/wp-content/plugins/joinus4health/assets/js/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#add-related-suggestion").click(function(){
                html = '<?= $append_html ?>';
                $('#related-suggestions').append(html);
            });
            
            $(".related-suggestion-remove").click(function(){
                $(this).parent().remove();
            });
        });
    </script>
    <?php
    echo '<a id="add-related-suggestion" style="cursor: pointer">'.__('Add related suggestion').'</a>';
}


/**
 * Adds meta box "Related tasks"
 * - select field with related topic
 * - anchors to add new related topic
 * - anchors to remove existing related topic
 * 
 * @param type $post
 */
function add_meta_box_ju4htopic_related_tasks_callback($post) {
    wp_nonce_field(basename( __FILE__ ), 'topic_related_tasks_nonce');
    $tasks = array();
    $query = new WP_Query(array('post_type' => 'ju4htask', 'posts_per_page' => -1));
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $postloop = $query->post;
            $meta = get_post_meta($postloop->ID);
            $tasks[$postloop->ID] = $postloop->post_title;
        }
    }
    
    
    
    $related_tasks = get_post_meta($post->ID, 'm_related_tasks');
    echo '<div id="related-tasks">';
    
    foreach ($related_tasks as $related_task) {
        echo '<p><label>'.__('Task').'</label>&nbsp;&nbsp;&nbsp;<select name="m_related_tasks[]">';
        echo '<option value="">None</option>';
        foreach ($tasks as $key => $value) {
            $selected = '';
            if ($key == $related_task) {
                $selected = ' selected';
            }
            echo '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
        }
        echo '</select>&nbsp;&nbsp;&nbsp;<a class="related-task-remove" style="cursor: pointer">'.__('Remove task').'</a>';
        echo '</p>';
    }
    echo '</div>';
    
    $append_html = '<p><label>'.__('Task').'</label>&nbsp;&nbsp;&nbsp;<select name="m_related_tasks[]">';
    $append_html .= '<option value="">None</option>';
    foreach ($tasks as $key => $value) {
        $append_html .= '<option value="'.$key.'">'.$value.'</option>';
    }
    $append_html .= '</select>&nbsp;&nbsp;&nbsp;<a class="related-task-remove" style="cursor: pointer">'.__('Remove task').'</a>';
    $append_html .= '</p>';
    ?>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#add-related-task").click(function(){
                html = '<?= $append_html ?>';
                $('#related-tasks').append(html);
            });
            
            $(".related-task-remove").click(function(){
                $(this).parent().remove();
            });
        });
    </script>
    <?php
    echo '<a id="add-related-task" style="cursor: pointer">'.__('Add related task').'</a>';
}


/**
 * Adds meta box "Related groups"
 * - select field with related topic
 * - anchors to add new related topic
 * - anchors to remove existing related topic
 * 
 * @param type $post
 */
function add_meta_box_ju4htopic_related_groups_callback($post) {
    wp_nonce_field(basename( __FILE__ ), 'topic_related_groups_nonce');
    $groups = array();
    $query = new WP_Query(array('post_type' => 'forum', 'posts_per_page' => -1));
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $postloop = $query->post;
            $meta = get_post_meta($postloop->ID);
            $groups[$postloop->ID] = $postloop->post_title;
        }
    }

    $related_groups = get_post_meta($post->ID, 'm_related_groups');
    echo '<div id="related-groups">';
    
    foreach ($related_groups as $related_group) {
        echo '<p><label>'.__('Related groups').'</label>&nbsp;&nbsp;&nbsp;<select name="m_related_groups[]">';
        echo '<option value="">None</option>';
        foreach ($groups as $key => $value) {
            $selected = '';
            if ($key == $related_group) {
                $selected = ' selected';
            }
            echo '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
        }
        echo '</select>&nbsp;&nbsp;&nbsp;<a class="related-group-remove" style="cursor: pointer">'.__('Remove group').'</a>';
        echo '</p>';
    }
    echo '</div>';
    
    $append_html = '<p><label>'.__('Related group').'</label>&nbsp;&nbsp;&nbsp;<select name="m_related_groups[]">';
    $append_html .= '<option value="">None</option>';
    foreach ($groups as $key => $value) {
        $append_html .= '<option value="'.$key.'">'.$value.'</option>';
    }
    $append_html .= '</select>&nbsp;&nbsp;&nbsp;<a class="related-group-remove" style="cursor: pointer">'.__('Remove group').'</a>';
    $append_html .= '</p>';
    ?>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#add-related-group").click(function(){
                html = '<?= $append_html ?>';
                $('#related-groups').append(html);
            });
            
            $(".related-group-remove").click(function(){
                $(this).parent().remove();
            });
        });
    </script>
    <?php
    echo '<a id="add-related-group" style="cursor: pointer">'.__('Add related group').'</a>';
}

/**
 * Adds meta box "Attachments"
 * - @todo
 * 
 * @param type $post
 */
function add_meta_box_ju4htopic_attachments_callback($post) {
    wp_nonce_field(basename( __FILE__ ), 'topic_attachments_nonce');
    html_admin_file_multiple_meta_box($post, 'attachments');
}

/**
 * Adds meta box "Attachments"
 * - @todo
 * 
 * @param type $post
 */
function add_meta_box_ju4htopic_externals_callback($post) {
    wp_nonce_field(basename( __FILE__ ), 'topic_attachments_nonce');
    html_admin_hyperlink_multiple_meta_box($post, 'externals');
}

/**
 * Adds meta box "Report URL"
 * - @todo
 * 
 * @param type $post
 */
function add_meta_box_ju4htopic_report_url($post) {
    wp_nonce_field(basename( __FILE__ ), 'topic_report_url_nonce');
    html_admin_text("m_report_url", get_post_meta($post->ID, 'm_report_url', true));
}

/**
 * Adds meta box "Attachments"
 * - @todo
 * 
 * @param type $post
 */
function add_meta_box_ju4htopic_topimage_callback($post) {
    wp_nonce_field(basename( __FILE__ ), 'topic_topimage_nonce');
    html_admin_file_meta_box($post, 'm_top_image', 'topimage');
}


/**
 * Save topic post method
 * 
 * @param type $post_id
 * @return type
 */
function save_post_ju4htopic_callback($post_id) {
    global $meta_topic_source, $meta_languages, $meta_topic_status, $meta_stakeholder_group, $meta_translations;
    
    $nonces = array(
        'topic_additional_fields_nonce', 
        'topic_description_nonce', 
        'topic_related_suggestions_nonce',
        'topic_attachments_nonce'
    );
    
    //checking nonces
    foreach ($nonces as $nonce) {
        if (!isset($_POST[$nonce]) || !wp_verify_nonce($_POST[$nonce], basename(__FILE__))) {
            return;
        }
    }
    
    //check if current user can edit post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    //select fields
    $selectbox_fields = array(
        "m_status",
        "m_language",
        "m_source",
        "m_target_group",
    );
    
    //select options
    $selectbox_metas = array(
        $meta_topic_status,
        $meta_languages,
        $meta_topic_source,
        $meta_stakeholder_group
    );
    
    //looping over select fields & check if any given values exists on list, if not throw error
    foreach ($selectbox_fields as $index => $selectbox_field) {
        $selectbox_name = $selectbox_field[$index];
        $selectbox_possible_values = $selectbox_metas[$index];
        
        if (isset($_POST[$selectbox_name])) {
            $value = $_POST[$selectbox_name];
            
            if ($_POST[$selectbox_name] == '') {
                //nothing to do - everything is ok if it is empty - it means that someone choose "empty"/"no value"/"-"
            } else if (!isset($selectbox_possible_values[$value])) {
                add_settings_error('missing-fields', 'missing-fields', __("You must fill all fields"), 'error');
                set_transient('settings_errors', get_settings_errors(), 30);
                return;
            }
        }
    }
    
    
    //looping over related suggestions & chacking if any is not numeric, if it is throw error
    if (isset($_POST['m_related_suggestions'])) {
        foreach ($_POST['m_related_suggestions'] as $related_suggestion) {
            if (!is_numeric($related_suggestion)) {
                add_settings_error('missing-fields', 'missing-fields', __("You must fill all fields"), 'error');
                set_transient('settings_errors', get_settings_errors(), 30);
                return;
            }
        }
    }
    
    //
    if (isset($_POST['m_related_suggestions']) && is_array($_POST['m_related_suggestions'])) {
        $_POST['m_related_suggestions'] = array_diff($_POST['m_related_suggestions'], array(""));
    } else {
        $_POST['m_related_suggestions'] = array();
    }
    
    //getting related suggestions
    $related_suggestions = get_post_meta($post_id, 'm_related_suggestions');
    
    //making intersection between related suggestions from POST & existing related suggestions
    //result should be keeped in db
    $related_suggestions_intersect = array_intersect($_POST['m_related_suggestions'], $related_suggestions);

    //removing related suggestions which should be keeped from POSTed related suggestions
    //result will be added to db
    $related_suggestions_to_add = array_diff($_POST['m_related_suggestions'], $related_suggestions_intersect);
    
    //removing related suggestions which should be keeped from existing related suggestions
    //result will be removed from db
    $related_suggestions_to_remove = array_diff($related_suggestions, $related_suggestions_intersect);

    //looping add operation of new related suggestions
    foreach ($related_suggestions_to_add as $value) {
        add_post_meta($post_id, 'm_related_suggestions', $value);
    }

    //looping remove operation of related suggestions which should be removed
    foreach ($related_suggestions_to_remove as $value) {
        delete_post_meta($post_id, 'm_related_suggestions', $value);
    }
    
    
    //looping over related suggestions & chacking if any is not numeric, if it is throw error
    if (isset($_POST['m_related_tasks'])) {
        foreach ($_POST['m_related_tasks'] as $related_task) {
            if (!is_numeric($related_task)) {
                add_settings_error('missing-fields', 'missing-fields', __("You must fill all fields"), 'error');
                set_transient('settings_errors', get_settings_errors(), 30);
                return;
            }
        }
    }
    
    //
    if (isset($_POST['m_related_tasks']) && is_array($_POST['m_related_tasks'])) {
        $_POST['m_related_tasks'] = array_diff($_POST['m_related_tasks'], array(""));
    } else {
        $_POST['m_related_tasks'] = array();
    }
    
    //getting related tasks
    $related_tasks = get_post_meta($post_id, 'm_related_tasks');
    
    //making intersection between related tasks from POST & existing related tasks
    //result should be keeped in db
    $related_tasks_intersect = array_intersect($_POST['m_related_tasks'], $related_tasks);

    //removing related tasks which should be keeped from POSTed related tasks
    //result will be added to db
    $related_tasks_to_add = array_diff($_POST['m_related_tasks'], $related_tasks_intersect);
    
    //removing related tasks which should be keeped from existing related tasks
    //result will be removed from db
    $related_tasks_to_remove = array_diff($related_tasks, $related_tasks_intersect);

    //looping add operation of new related tasks
    foreach ($related_tasks_to_add as $value) {
        add_post_meta($post_id, 'm_related_tasks', $value);
    }

    //looping remove operation of related tasks which should be removed
    foreach ($related_tasks_to_remove as $value) {
        delete_post_meta($post_id, 'm_related_tasks', $value);
    }
    
    
    
    
    //looping over related suggestions & chacking if any is not numeric, if it is throw error
    if (isset($_POST['m_related_groups'])) {
        foreach ($_POST['m_related_groups'] as $related_groups) {
            if (!is_numeric($related_groups)) {
                add_settings_error('missing-fields', 'missing-fields', __("You must fill all fields"), 'error');
                set_transient('settings_errors', get_settings_errors(), 30);
                return;
            }
        }
    }
    
    //
    if (isset($_POST['m_related_groups']) && is_array($_POST['m_related_groups'])) {
        $_POST['m_related_groups'] = array_diff($_POST['m_related_groups'], array(""));
    } else {
        $_POST['m_related_groups'] = array();
    }
    
    //getting related groups
    $related_groups = get_post_meta($post_id, 'm_related_groups');
    
    //making intersection between related groups from POST & existing related groups
    //result should be keeped in db
    $related_groups_intersect = array_intersect($_POST['m_related_groups'], $related_groups);

    //removing related groups which should be keeped from POSTed related groups
    //result will be added to db
    $related_groups_to_add = array_diff($_POST['m_related_groups'], $related_groups_intersect);
    
    //removing related groups which should be keeped from existing related groups
    //result will be removed from db
    $related_groups_to_remove = array_diff($related_groups, $related_groups_intersect);

    //looping add operation of new related groups
    foreach ($related_groups_to_add as $value) {
        add_post_meta($post_id, 'm_related_groups', $value);
    }

    //looping remove operation of related groups which should be removed
    foreach ($related_groups_to_remove as $value) {
        delete_post_meta($post_id, 'm_related_groups', $value);
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
    
    
    //
    if (isset($_POST['m_externals_text']) && is_array($_POST['m_externals_text']) && isset($_POST['m_externals_url']) && is_array($_POST['m_externals_url'])) {
        $_POST_externals = array();
        
        foreach ($_POST['m_externals_url'] as $index => $value) {
            $obj = new stdClass();
            $obj->url = $_POST['m_externals_url'][$index];
            $obj->text = $_POST['m_externals_text'][$index];
            $_POST_externals[] = str_replace('\/', '/', json_encode($obj));
    
        }

        $_POST_externals = array_diff($_POST_externals, array(""));
    } else {
        $_POST_externals = array();
    }
    
    //getting attachments
    $externals = get_post_meta($post_id, 'm_externals');

    //making intersection between attachments from POST & existing attachments
    //result should be keeped in db
    $externals_intersect = array_intersect($_POST_externals, $externals);

    //removing attachments which should be keeped from POSTed attachments
    //result will be added to db
    $externals_to_add = array_diff($_POST_externals, $externals_intersect);
    
    //removing attachments which should be keeped from existing attachments
    //result will be removed from db
    $externals_to_remove = array_diff($externals, $externals_intersect);

    //looping add operation of new attachments
    foreach ($externals_to_add as $value) {
        add_post_meta($post_id, 'm_externals', $value);
    }

    //looping remove operation of related suggestions which should be removed
    foreach ($externals_to_remove as $value) {
        delete_post_meta($post_id, 'm_externals', $value);
    }
    
    
    if ($_POST['m_top_image_file'] != '') {
        $obj = new stdClass();
        $obj->file = $_POST['m_top_image_file'];
        $obj->text = $_POST['m_top_image_text'];
        $obj->url = $_POST['m_top_image_url'];
        $obj->license = $_POST['m_top_image_license'];
        $obj->license_holder = $_POST['m_top_image_holder'];
        $obj->check = ($_POST['m_top_image_check'] == 1) ? 1 : 0;
        update_post_meta($post_id, 'm_topimage', str_replace('\/', '/', json_encode($obj)));
    } else {
        delete_post_meta($post_id, 'm_topimage');
    }
    
    
    //saving select box fields
    foreach ($selectbox_fields as $value) {
        if (isset($_POST[$value])) {
            if ($_POST[$value] == '') {
                delete_post_meta($post_id, $value);
            } else {
                update_post_meta($post_id, $value, sanitize_text_field($_POST[$value]));
            }
        }
    }
    
    
    //saving intro textarea field
    update_post_meta($post_id, 'm_intro', esc_html($_POST['m_intro']));
    
    //saving description textarea field
    update_post_meta($post_id, 'm_description', esc_html($_POST['m_description']));
    
    foreach ($meta_translations as $key => $value) {
        update_post_meta($post_id, 'm_title_'.$key, esc_html($_POST['m_title_'.$key]));
        update_post_meta($post_id, 'm_intro_'.$key, esc_html($_POST['m_intro_'.$key]));
        update_post_meta($post_id, 'm_description_'.$key, esc_html($_POST['m_description_'.$key]));
    }
    
    if (get_post_meta($post_id, 'm_votes_count', true) == '') {
        update_post_meta($post_id, 'm_votes_count', 0);
    }
    
    update_post_meta($post_id, 'm_report_url', esc_html($_POST['m_report_url']));

    
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
add_action('save_post_ju4htopic', 'save_post_ju4htopic_callback', 10, 2);

function manage_ju4htopic_posts_columns_callback($columns) {
    $columns['status'] = __('Status');
    $columns['language'] = __('Language');
    return $columns;
}
add_filter('manage_ju4htopic_posts_columns', 'manage_ju4htopic_posts_columns_callback');

function manage_ju4htopic_posts_custom_column_callback($column, $post_id) {
    global $meta_languages, $meta_topic_status;
    
    if ($column == 'language') {
        $language = get_post_meta($post_id, 'm_language', true);
        if ($language != null && array_key_exists($language, $meta_languages)) {
            echo $meta_languages[$language];
        }
    }
    
    if ($column == 'status') {
        $status = get_post_meta($post_id, 'm_status', true);
        if ($status != null && array_key_exists($status, $meta_topic_status)) {
            echo $meta_topic_status[$status];
        }
    }
}
add_action('manage_ju4htopic_posts_custom_column', 'manage_ju4htopic_posts_custom_column_callback', 10, 2);

function ju4h_can_add_someone_to_topic($someone, $post) {
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

function ju4h_can_change_to_close_topic($post) {
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
    
    return false;
}