<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<?php js_script_voting() ?>
<h1>Suggestions</h1>
<?php
$labels = array(__("Country"), __("Language"), __("Duration"), __("Type"), __("Level"), __("Source"), __("Target stakeholder group"));
$names = array("country", "language", "duration", "type", "level", "source", "target_group");
$values = array($meta_countries, $meta_countries, $meta_contribute_duration, $meta_types, $meta_level, $meta_source, $meta_target_group);
$date_since = null;
$date_till = null;

if (isset($_GET['date_since'])) {
    $date_since_obj = date_create_from_format("Y-m-d", $_GET['date_since']);
    if ($date_since_obj) {
        $date_since = date_format($date_since_obj, 'Y-m-d');
    }
}

if (isset($_GET['date_till'])) {
    $date_till_obj = date_create_from_format("Y-m-d", $_GET['date_till']);
    if ($date_till_obj) {
        $date_till = date_format($date_till_obj, 'Y-m-d');
    }
}
?>
<form>
    <table>
    <?php foreach ($labels as $index => $label): ?>
        <tr>
            <td style="width: 300px;"><?= $label ?></td>
            <td>
                <select name="<?= $names[$index] ?>">
                    <option value="">-</option>
                    <?php foreach ($values[$index] as $key => $value): ?>
                    <?php
                    $selected = '';
                    if (isset($_GET[$names[$index]]) && $_GET[$names[$index]] == $key) {
                        $selected = ' selected';
                    }
                    ?>
                    <option value="<?= $key ?>"<?= $selected ?>><?= $value ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    <?php endforeach; ?>
        <tr>
            <td>Date since</td>
            <td>
                <input type="text" name="date_since" id='date_since'>
                <script type="text/javascript">
                $(function() {
                    $("#date_since").flatpickr({
                        dateFormat: "Y-m-d",
                        defaultDate: <?= ($date_since == null) ? 'null' : "'$date_since'" ?>
                    });
                });
                </script>
            </td>
        </tr>
        <tr>
            <td>Date till</td>
            <td>
                <input type="text" name="date_till" id='date_till'>
                <script type="text/javascript">
                $(function() {
                    $("#date_till").flatpickr({
                        dateFormat: "Y-m-d",
                        defaultDate: <?= ($date_till == null) ? 'null' : "'$date_till'" ?>
                    });
                });
                </script>
            </td>
        </tr>
        <tr><td></td><td><input type="submit"></td></tr>
    </table>
</form>
<?php
$query_params = array('post_type' => 'ju4hsuggestion');
$meta_query = array();
foreach ($names as $name) {
    if (isset($_GET[$name]) && $_GET[$name] != '') {
        $meta_query['relation'] = 'AND';
        $meta_query[$name."_clause"] = array(
            'key' => 'm_'.$name,
            'value' => $_GET[$name]
        );
    }
}
if (!empty($meta_query)) {
    $query_params['meta_query'] = $meta_query;
}

if ($date_since_obj || $date_till_obj) {
    $query_params['date_query'] = array();
    
    if ($date_since_obj) {
        $query_params['date_query']['after'] = array(
            'year' => $date_since_obj->format('Y'),
            'month' => $date_since_obj->format('n'),
            'day' => $date_since_obj->format('j')
        );
    }
    
    if ($date_till_obj) {
        $query_params['date_query']['before'] = array(
            'year' => $date_till_obj->format('Y'),
            'month' => $date_till_obj->format('n'),
            'day' => $date_till_obj->format('j')
        );
    }
    
    $query_params['date_query']['inclusive'] = true;
}
$query = new WP_Query($query_params);
?>
<?php if ($query->have_posts()): ?>
    <?php while ($query->have_posts()): ?>
    <?php $query->the_post(); ?>
    <?php $meta = get_post_meta($post->ID); ?>
    <table border="1" style="width: 100%; margin-bottom: 40px;">
    <tr>
        <td>
            <table style="width: 100%">
                <tr>
                    <?php if (is_user_logged_in()): ?>
                    <td style="width: 50px">
                        <?php if (is_array($meta['m_votes']) && in_array(get_current_user_id(), $meta['m_votes'])): ?>
                        <h2 class="item-downvote" id="item-vote-<?= $post->ID ?>" style="cursor: pointer">
                            [-]
                        </h2>
                        <?php else: ?>
                        <h2 class="item-upvote" id="item-vote-<?= $post->ID ?>" style="cursor: pointer">
                            [+]
                        </h2>
                        <?php endif; ?>
                    </td>
                    <?php endif; ?>
                    <td style="width: 50px"><h2 id="item-votes-<?= $post->ID ?>"><?= count($meta['m_votes']) ?></h2></td>
                    <td><h2><a class="item-url" id="item-url-<?= $post->ID ?>" href='<?php the_permalink(); ?>'><?php the_title() ?></a></h2></td>
                </tr>
            </table>
        </td>
    </tr>
    <?php if (isset($meta['m_description']) && is_array($meta['m_description']) && count($meta['m_description'])): ?>
    <tr>
        <td>
            <?= __('Description') ?>: <?= $meta['m_description'][0] ?>
        </td>
    </tr>
    <?php endif; ?>
    <tr>
        <td>
            <?php
            foreach ($names as $index => $name) {
                if (isset($meta['m_'.$name]) && is_array($meta['m_'.$name]) && count($meta['m_'.$name]) && $meta['m_'.$name][0] != '') {
                    echo $labels[$index].': '.$values[$index][$meta['m_'.$name][0]].' | ';
                }
            }
            ?>
        </td>
    </tr>
    <tr><td><?= get_the_date(); ?></td></tr>
    </table>
    <?php endwhile; ?>
<?php endif;