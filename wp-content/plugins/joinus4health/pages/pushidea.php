<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (isset($_POST['title']) && isset($_POST['description'])) {
    $new = array(
        'post_title'   => esc_html(wp_unslash($_POST['title'])),
        'post_status'  => 'draft',
        'post_type'    => 'suggestion',
    );
    
    $post_id = wp_insert_post($new);
    
    if ($post_id) {
        add_post_meta($post_id, 'm_description', esc_html(wp_unslash($_POST['description'])));
        
        $_POST['title'] = '';
        $_POST['description'] = '';
    }
}
?>
<form method="post">
    <table>
        <tr>
            <td style="width: 200px;"><?= __('Title') ?></td>
            <td><input type="text" name="title" value="<?= sanitize_text_field($_POST['title']) ?>" style="width: 500px;" /></td>
        </tr>
        <tr>
            <td><?= __('Add additional details') ?></td>
            <td><textarea name="description" style="width: 500px; height: 300px;"><?= sanitize_textarea_field($_POST['description']) ?></textarea></td>
        </tr>
        <tr>
        <tr><td></td><td><input type="submit"></td></tr>
    </table>
</form>