<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$admin_file_licenses = array(
    '' => '',
    'public_domain' => 'Public domain',
    'cc0_1.0' => 'CC0 1.0',
    'cc-by_4.0' => 'CC-BY 4.0',
    'cc-by-nd_4.0' => 'CC-BY-ND 4.0',
    'unsplash_license' => 'Unsplash-License',
);

function html_admin_date_input($title, $name, $value) {
    $val_d = '';
    $val_m = '';
    $val_Y = '';
    
    if (is_numeric($value)) {
        $value = (int)$value;
        $val_d = date('d', $value);
        $val_m = date('m', $value);
        $val_Y = date('Y', $value);
    }
?>
    <p>
        <label for="<?= $name ?>" style="padding-right: 30px;"><?= $title ?></label>
        <select name="<?= $name ?>_Y">
            <option value=''></option>
            <?php for ($Y = date('Y') - 40; $Y < date('Y') + 40; $Y++): ?>
            <?php $selected = ($Y == $val_Y) ? ' selected' : ''; ?>
            <option value="<?= $Y ?>"<?= $selected ?>><?= $Y ?></option>
            <?php endfor; ?>
        </select>
        -
        <select name="<?= $name ?>_m">
            <option value=''></option>
            <?php for ($m = 1; $m <= 12; $m++): ?>
            <?php $selected = ($m == $val_m) ? ' selected' : ''; ?>
            <option value="<?= $m ?>"<?= $selected ?>><?= $m ?></option>
            <?php endfor; ?>
        </select>
        -
        <select name="<?= $name ?>_d">
            <option value=''></option>
            <?php for ($d = 1; $d <= 31; $d++): ?>
            <?php $selected = ($d == $val_d) ? ' selected' : ''; ?>
            <option value="<?= $d ?>"<?= $selected ?>><?= $d ?></option>
            <?php endfor; ?>
        </select>
    </p>
<?php
}

function html_admin_select_box($title, $name, $values, $key_selected = null, $with_none = true) {
?>
    <p>
        <label for="<?= $name ?>" style="padding-right: 30px;"><?= $title ?></label>
        <select name="<?= $name ?>">
            <?php if ($with_none): ?>
            <option value="">None</option>
            <?php endif; ?>
            <?php foreach ($values as $key => $value): ?>
                <?php $selected = ($key == $key_selected) ? ' selected' : '' ?>
                <option value="<?= $key ?>"<?= $selected ?>><?= $value ?></option>';
            <?php endforeach; ?>
        </select>
    </p>
<?php
}

function html_admin_button($title, $name, $value) {
?>
    <p>
        <label for="<?= $name ?>" style="padding-right: 30px;"><?= $title ?></label>
        <input type="button" value="Transfer" id="<?= $name ?>" data-id="<?= $value ?>" />
    </p>
<?php
}

function html_admin_text($name, $value) {
?>
    <p>
        <input type="text" name="<?= $name ?>" style="width: 100%;" value="<?= sanitize_text_field($value) ?>" />
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

function html_admin_file_multiple($name, $value, $prefix, $id) {
    global $admin_file_licenses;
    
    ob_start();
    if ($value == null) {
        $value = new stdClass();
        $value->text = '';
        $value->license = '';
        $value->license_holder = '';
        $value->file = '';
        $value->url = '';
        $value->check = '';
    } else {
        $value = json_decode($value);
    }
?>
    <div id="<?= $prefix ?>-div-iframe-upload-<?= $id ?>" style="border: 1px solid black; margin-bottom: 10px; padding: 15px;">
        <div style="margin-bottom: 10px;">
            <div id="<?= $prefix ?>-status-iframe-upload-<?= $id ?>" style="display: none"></div>
            <label><?= __('File name') ?></label>&nbsp;&nbsp;&nbsp;<input type="text" name="<?= $name ?>_text[]" value="<?= $value->text ?>" id="<?= $prefix ?>-filename-iframe-upload-<?= $id ?>" /><br/><br/>
            <label><?= __('License') ?></label>&nbsp;&nbsp;&nbsp;<select name="<?= $name ?>_license[]" id="<?= $prefix ?>-license-iframe-upload-<?= $id ?>">
                <?php foreach ($admin_file_licenses as $license_code => $license_name): ?>
                <option value="<?= $license_code ?>"<?php if ($license_code == $value->license) { echo ' selected'; } ?>><?= $license_name ?></option>
                <?php endforeach; ?>
            </select><br/><br/>
            <label><?= __('License holder') ?></label>&nbsp;&nbsp;&nbsp;<input type="text" name="<?= $name ?>_holder[]" value="<?= $value->license_holder ?>" id="<?= $prefix ?>-holder-iframe-upload-<?= $id ?>" /><br/><br/>
            <label><?= __('Source URL') ?></label>&nbsp;&nbsp;&nbsp;<input type="text" name="<?= $name ?>_url[]" value="<?= $value->url ?>" id="<?= $prefix ?>-url-iframe-upload-<?= $id ?>" /><br/><br/>
            <label><?= __('I assure, that I have the right to use and upload the file in this context') ?></label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="<?= $name ?>_check[]" value="1" id="<?= $prefix ?>-check-iframe-upload-<?= $id ?>"<?php if ($value->check == 1): ?>checked<?php endif; ?> /><br/><br/>
            <a id="<?= $prefix ?>-a-iframe-upload-<?= $id ?>" target="_blank" href="<?= home_url() ?>/wp-content/<?= $value->file ?>"><?= $value->text ?></a>
        </div>
        <input type="hidden" id="<?= $prefix ?>-input-iframe-upload-<?= $id ?>" name="<?= $name ?>_file[]" value="<?= $value->file ?>" />
        <iframe id="<?= $prefix ?>-iframe-upload-<?= $id ?>" src="<?= home_url() ?>/wp-content/plugins/joinus4health/includes/upload.php?id=<?= $id ?>&amp;prefix=<?= $prefix ?>&amp;type=image" style="width: 400px; height: 30px;"></iframe>
        <br/>
        <a class="<?= $prefix ?>-remove" style="cursor: pointer"><?= __('Remove file') ?></a>
    </div>
<?php
    $output = ob_get_clean();
    return $output;
}


function html_admin_file_multiple_meta_box($post, $prefix) {
    
    $attachments = get_post_meta($post->ID, 'm_'.$prefix);
    
    echo '<div id="'.$prefix.'">';
    $i = 0;
    foreach ($attachments as $attachment) {
        echo html_admin_file_multiple('m_'.$prefix, $attachment, $prefix, $i++);
    }
    echo '</div>';
    
    $append_html = html_admin_file_multiple('m_'.$prefix, null, $prefix, 'new');
    ?>
    
    <script type="text/javascript" src="<?= home_url() ?>/wp-content/plugins/joinus4health/assets/js/jquery.min.js"></script>
    <script type="text/javascript">
        function <?= $prefix?>_handle_upload(object_js) {
            if (object_js.error) {
                alert(object_js.msg);
            } else {
                setTimeout(function(){
                    $("#<?= $prefix ?>-status-iframe-upload-"+object_js.id).hide();
                    $("#<?= $prefix ?>-a-iframe-upload-"+object_js.id).attr('href', object_js.filepath);
                    $("#<?= $prefix ?>-a-iframe-upload-"+object_js.id).html(object_js.filename);
                    $("#<?= $prefix ?>-filename-iframe-upload-"+object_js.id).val(object_js.filename);
                    $("#<?= $prefix ?>-input-iframe-upload-"+object_js.id).val(object_js.filepath);
                }, 200);
            }
        }
        
        $(document).ready(function(){
            $("#add-<?= $prefix ?>").click(function(){
                if ($("#<?= $prefix ?> > div").length == 0) {
                    val_id = 0;
                } else {
                    val_id = parseInt($('#<?= $prefix ?> > div:last').attr('id').split('-')[4]);
                    val_id = val_id + 1;
                }

                html = '<?= str_replace(array("\r", "\n"), '', $append_html) ?>';
                html = html.split("iframe-upload-new").join("iframe-upload-"+val_id);
                html = html.split("upload.php?id=new").join("upload.php?id="+val_id);
                $('#<?= $prefix ?>').append(html);
                $(".<?= $prefix ?>-remove").click(function(){
                    $(this).parent().remove();
                });
            });

            $(".<?= $prefix ?>-remove").click(function(){
                $(this).parent().remove();
            });
        });
    </script>
    <?php
    echo '<a id="add-'.$prefix.'" style="cursor: pointer;">'.__('Add attachment').'</a>';
}


function html_admin_file_meta_box($post, $name, $prefix) {
    global $admin_file_licenses;
    
    $value = get_post_meta($post->ID, 'm_'.$prefix, true);
    
    if ($value == null) {
        $value = new stdClass();
        $value->text = '';
        $value->license = '';
        $value->license_holder = '';
        $value->file = '';
        $value->url = '';
        $value->check = '';
    } else {
        $value = json_decode($value);
    }
?>
    
    <div id="<?= $prefix ?>-div-iframe-upload-0">
        <div style="margin-bottom: 10px;">
            <div id="<?= $prefix ?>-status-iframe-upload-0" style="display: none"></div>
            <label><?= __('File name') ?></label>&nbsp;&nbsp;&nbsp;<input type="text" name="<?= $name ?>_text" value="<?= $value->text ?>" id="<?= $prefix ?>-filename-iframe-upload-0" /><br/><br/>
            <label><?= __('License') ?></label>&nbsp;&nbsp;&nbsp;
            <select name="<?= $name ?>_license" id="<?= $prefix ?>-license-iframe-upload-0">
                <?php foreach ($admin_file_licenses as $license_code => $license_name): ?>
                <option value="<?= $license_code ?>"<?php if ($license_code == $value->license) { echo ' selected'; } ?>><?= $license_name ?></option>
                <?php endforeach; ?>
            </select><br/><br/>
            <label><?= __('License holder') ?></label>&nbsp;&nbsp;&nbsp;<input type="text" name="<?= $name ?>_holder" value="<?= $value->license_holder ?>" id="<?= $prefix ?>-holder-iframe-upload-0" /><br/><br/>
            <label><?= __('Source URL') ?></label>&nbsp;&nbsp;&nbsp;<input type="text" name="<?= $name ?>_url" value="<?= $value->url ?>" id="<?= $prefix ?>-url-iframe-upload-0" /><br/><br/>
            <label><?= __('I assure, that I have the right to use and upload the file in this context') ?></label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="<?= $name ?>_check" value="1" id="<?= $prefix ?>-check-iframe-upload-0"<?php if ($value->check == 1): ?>checked<?php endif; ?> /><br/><br/>
            <a id="<?= $prefix ?>-a-iframe-upload-0" style="padding-bottom: 10px;" target="_blank" href="<?= home_url() ?>/wp-content/<?= $value->file ?>"><?= $value->text ?></a>
        </div>
        <input type="hidden" id="<?= $prefix ?>-input-iframe-upload-0" name="<?= $name ?>_file" value="<?= $value->file ?>" />
        <iframe id="<?= $prefix ?>-iframe-upload-0" src="<?= home_url() ?>/wp-content/plugins/joinus4health/includes/upload.php?id=0&amp;prefix=<?= $prefix ?>" style="width: 400px; height: 30px;"></iframe>
        <a id="<?= $prefix ?>-remove-iframe-upload-0" style="cursor: pointer;"><?= __('Remove file') ?></a>
    </div>
    <script type="text/javascript" src="<?= home_url() ?>/wp-content/plugins/joinus4health/assets/js/jquery.min.js"></script>
    <script type="text/javascript">
        function <?= $prefix?>_handle_upload(object_js) {
            if (object_js.error) {
                alert(object_js.msg);
            } else {
                setTimeout(function(){
                    $("#<?= $prefix ?>-status-iframe-upload-"+object_js.id).hide();
                    $("#<?= $prefix ?>-a-iframe-upload-"+object_js.id).attr('href', object_js.filepath);
                    $("#<?= $prefix ?>-a-iframe-upload-"+object_js.id).html(object_js.filename);
                    $("#<?= $prefix ?>-filename-iframe-upload-"+object_js.id).val(object_js.filename);
                    $("#<?= $prefix ?>-input-iframe-upload-"+object_js.id).val(object_js.filepath);
                }, 200);
            }
        }
        
        $(document).ready(function(){
            $("#<?= $prefix ?>-remove-iframe-upload-0").click(function(){
                $("#<?= $prefix ?>-input-iframe-upload-0").val('');
                $("#<?= $prefix ?>-filename-iframe-upload-0").val('');
                $("#<?= $prefix ?>-url-iframe-upload-0").val('');
                $("#<?= $prefix ?>-license-iframe-upload-0").val('');
                $("#<?= $prefix ?>-holder-iframe-upload-0").val('');
                $("#<?= $prefix ?>-check-iframe-upload-0").prop('checked', false);
                $("#<?= $prefix ?>-a-iframe-upload-0").html('');
                $("#<?= $prefix ?>-a-iframe-upload-0").attr('href', '');
            });
        });
    </script>
    <?php
}


function html_admin_hyperlink_multiple($name, $value, $prefix, $id) {
        ob_start();
        if ($value == null) {
            $value = new stdClass();
            $value->text = '';
            $value->url = '';
        } else {
            $value = json_decode($value);
        }
       
?>
    <div id="<?= $prefix ?>-hyperlink-div-<?= $id ?>" style="border: 1px solid black; margin-bottom: 10px; padding: 15px;">
        <div style="margin-bottom: 10px;">
            <label><?= __('Title') ?></label>&nbsp;&nbsp;&nbsp;<input type="text" name="<?= $name ?>_text[]" value="<?= $value->text ?>" id="<?= $prefix ?>-hyperlink-text-<?= $id ?>" />
            <label><?= __('Url') ?></label>&nbsp;&nbsp;&nbsp;<input type="text" name="<?= $name ?>_url[]" value="<?= $value->url ?>" id="<?= $prefix ?>-hyperlink-url-<?= $id ?>" />
        </div>
        <br/>
        <a class="<?= $prefix ?>-remove" style="cursor: pointer"><?= __('Remove item') ?></a>
    </div>
<?php
    $output = ob_get_clean();
    return $output;
}



function html_admin_hyperlink_multiple_meta_box($post, $prefix) {
    $items = get_post_meta($post->ID, 'm_'.$prefix);
    
    echo '<div id="'.$prefix.'">';
    $i = 0;
    foreach ($items as $item) {
        echo html_admin_hyperlink_multiple('m_'.$prefix, $item, $prefix, $i++);
    }
    echo '</div>';
    
    $append_html = html_admin_hyperlink_multiple('m_'.$prefix, null, $prefix, 'new');
    ?>
    
    <script type="text/javascript" src="<?= home_url() ?>/wp-content/plugins/joinus4health/assets/js/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#add-<?= $prefix ?>").click(function(){
                if ($("#<?= $prefix ?> > div").length == 0) {
                    val_id = 0;
                } else {
                    val_id = parseInt($('#<?= $prefix ?> > div:last').attr('id').split('-')[4]);
                    val_id = val_id + 1;
                }

                html = '<?= str_replace(array("\r", "\n"), '', $append_html) ?>';
                $('#<?= $prefix ?>').append(html);
                $(".<?= $prefix ?>-remove").click(function(){
                    $(this).parent().remove();
                });
            });

            $(".<?= $prefix ?>-remove").click(function(){
                $(this).parent().remove();
            });
        });
    </script>
    <?php
    echo '<a id="add-'.$prefix.'" style="cursor: pointer;">'.__('Add another').'</a>';
}
