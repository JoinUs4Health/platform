<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();

if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['type']) && get_current_user_id() > 0) {
    
    if (empty($_POST['title']) || empty($_POST['description'])) {
        $is_error = true;
    }
    
    if (!array_key_exists($_POST['type'], $meta_suggestion_types)) {
        $is_error = true;
    }
    
    if (!isset($is_error)) {
        $new = array(
            'post_title'   => esc_html(wp_unslash($_POST['title'])),
            'post_status'  => 'draft',
            'post_type'    => 'ju4hsuggestion',
        );

        $post_id = wp_insert_post($new);

        if ($post_id) {
            add_post_meta($post_id, 'm_description', esc_html(wp_unslash($_POST['description'])));
            add_post_meta($post_id, 'm_type', $_POST['type']);

            $_POST['title'] = '';
            $_POST['description'] = '';
            $_POST['type'] = '';
            $added_new = true;
        }
    }
}
?>
    <style>
        .ast-container {
            align-items: flex-start;
            flex-flow: row wrap;
            margin-bottom: 40px;
        }
        
        .ast-container h1 {
            width: 100%;
            font-family: Recoleta;
            font-size: 28px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.14;
            letter-spacing: normal;
            color: #3b4045;
            margin-bottom: 20px;
        }

        .ast-container form.suggestion-new {
            border-radius: 4px;
            border: solid 1px #ced4d9;
            background-color: #fff;
            align-items: flex-start;
            flex-flow: row wrap;
            display: flex;
            width: 100%;
            padding: 20px;
        }
        
        .ast-container form.suggestion-new label {
            margin-left: 5px;
            margin-bottom: 5px;
            flex: 1 0 100%;
        }
        
        .ast-container form.suggestion-new label {
            margin-left: 5px;
            margin-bottom: 5px;
            flex: 1 0 100%;
        }
        
        .ast-container form.suggestion-new input[type="text"] {
            height: 40px;
            padding: 0 35px 0 10px;
            border-radius: 4px;
            border: solid 1px #ced4d9;
            background-color: #fff;
            flex: 1 0 100%;
            margin-bottom: 20px;
        }
        
        .ast-container form.suggestion-new input[type="submit"] {
            border-radius: 4px;
            background-color: #000000;
            color: #ffffff;
            padding-left: 40px;
            padding-right: 40px;
            font-size: 14px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            letter-spacing: normal;
            text-align: center;
            color: #ffffff;
            line-height: 28px;
        }
        
        .ast-container form.suggestion-new textarea {
            padding: 0 35px 0 10px;
            border-radius: 4px;
            border: solid 1px #ced4d9;
            background-color: #fff;
            flex: 1 0 100%;
            margin-bottom: 20px;
            height: 200px;
        }
        
        .ast-container form.suggestion-new select {
            height: 40px;
            padding: 0 35px 0 10px;
            border-radius: 4px;
            border: solid 1px #ced4d9;
            background-color: #fff;
            flex: 1 0 100%;
            margin-bottom: 20px;
        }
        
        .ast-container form.suggestion-new div {
            border-radius: 4px;
            border: solid 1px #ced4d9;
            flex: 1 0 100%;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .ast-container form.suggestion-new div.error {
            background-color: #ff6e6e;
        }
        
        .ast-container form.suggestion-new div.ok {
            background-color: #78c278;
        }
    </style>
    <h1><?= __('Create new suggestion', 'joinus4health') ?></h1>
    <form class="suggestion-new" method="post">
        <?php if (get_current_user_id() == 0): ?>
        <div class="error"><?= __('Suggestions can be added only by registered users', 'joinus4health') ?></div>
        <?php elseif (isset($is_error)): ?>
        <div class="error"><?= __('Your form contains errors. All fields must be completed', 'joinus4health') ?></div>
        <?php elseif (isset($added_new)): ?>
        <div class="ok"><?= __('New suggestion was added successfuly. Currently it is marked as draft', 'joinus4health') ?></div>
        <?php endif; ?>
        <label><?= __('Type', 'joinus4health') ?></label>
        <select name="type">
            <?php foreach ($meta_suggestion_types as $key => $value): ?>
            <option value="<?= $key ?>"<?= isset($_POST['type']) && $_POST['type'] == $key ? ' selected' : '' ?>><?= $value ?></option>
            <?php endforeach; ?>
        </select>
        <label><?= __('Title', 'joinus4health') ?></label>
        <input type="text" name="title" value="<?= isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '' ?>" />
        <label><?= __('Additional details', 'joinus4health') ?></label>
        <textarea name="description"><?= isset($_POST['description']) ? sanitize_textarea_field($_POST['description']) : '' ?></textarea>
        <input type="submit" value="<?= __('Create new suggestion', 'joinus4health') ?>"<?= (get_current_user_id() == 0) ? ' disabled' : '' ?> />
    </form>
    <?php
    get_footer();