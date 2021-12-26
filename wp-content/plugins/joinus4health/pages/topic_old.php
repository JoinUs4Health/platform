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
<h1>Topics</h1>
<?php
$topic_tags = get_terms('ju4htopictag', array('hide_empty' => false));

$meta_topictags = array();
foreach ($topic_tags as $item) {
    $meta_topictags[$item->term_id] = $item->name;
}
$labels = array(__("Sorty by"), __("Status"), __("Tag"));
$names = array("sortby", "status", "topictag");
$values = array($meta_sortby, $meta_status, $meta_topictags);
?>
<form>
    <table>
        <tr>
            <td style="width: 300px;"><?= __('Search') ?></td>
            <td><input type="text" name="search" value="<?= esc_attr($_GET['search']) ?>" /></td>
        </tr>
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
        <tr><td></td><td><input type="submit"></td></tr>
    </table>
</form>
<?php
$query_params = array('post_type' => 'ju4htopic');
$meta_query = array();
$tax_query = array();

foreach ($names as $name) {
    if (isset($_GET[$name]) && $_GET[$name] != '') {
        if ($name == 'sortby') {
            if ($_GET[$name] == 'popular') {
                $query_params['orderby'] = array('m_votes_count' => 'DESC', 'date' => 'DESC');
                $query_params['meta_type'] = 'NUMERIC';
                $query_params['meta_key'] = 'm_votes_count';
            } else if ($_GET[$name] == 'recent') {
                $query_params['orderby'] = array('date' => 'DESC');
            } else if ($_GET[$name] == 'trending') {
                $query_params['orderby'] = array('m_trending_votes' => 'DESC');
                $query_params['meta_type'] = 'NUMERIC';
                $query_params['meta_key'] = 'm_trending_votes';
            }
        } else if ($name == 'topictag') {
            $tax_query = array(
                array(
                    'taxonomy' => 'topictag',
                    'field'    => 'term_id',
                    'terms'    => $_GET[$name],
             ));
        } else {
            $meta_query['relation'] = 'AND';
            $meta_query[$name."_clause"] = array(
                'key' => 'm_'.$name,
                'value' => $_GET[$name]
            );
        }
    }
}
if (!empty($meta_query)) {
    $query_params['meta_query'] = $meta_query;
}

if (!empty($tax_query)) {
    $query_params['tax_query'] = $tax_query;
}

if (isset($_GET['search']) && $_GET['search'] != '') {
    $query_params['s'] = $_GET['search'];
}

$query = new WP_Query($query_params);
?>
<?php if ($query->have_posts()): ?>
    <?php while ($query->have_posts()): ?>
    <?php $query->the_post(); ?>
    <?php $meta = get_post_meta($post->ID); ?>
    <?php $tags = wp_get_post_terms($post->ID, 'topictag'); ?>
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
    <?php if(count($tags) > 0): ?>
    <tr>
        <td>
            
            <?php foreach ($tags as $tag): ?>
            <a href="?topictag=<?= $tag->term_id ?>"><?= $tag->name ?><a>&nbsp;|&nbsp;
            <?php endforeach; ?>
        </td>
    </tr>
    <?php endif; ?>
    <tr><td><?= get_the_date(); ?></td></tr>
    </table>
    <?php endwhile; ?>
<?php endif;