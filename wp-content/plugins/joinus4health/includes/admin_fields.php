<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

function html_admin_select_box($title, $name, $values, $key_selected = null) {
?>
    <p>
        <label for="<?= $name ?>" style="padding-right: 30px;"><?= $title ?></label>
        <select name="<?= $name ?>">
            <option value="">None</option>
            <?php foreach ($values as $key => $value): ?>
                <?php $selected = ($key == $key_selected) ? ' selected' : '' ?>
                <option value="<?= $key ?>"<?= $selected ?>><?= $value ?></option>';
            <?php endforeach; ?>
        </select>
    </p>
<?php
}

function html_admin_textarea($name, $value) {
?>
    <p>
        <textarea name="<?= $name ?>" style="width: 100%; height: 150px;"><?= sanitize_textarea_field($value) ?></textarea>
    </p>
<?php
}

