<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

get_header();
?>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <?php
    echo js_script_voting();
    echo js_load_href();
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('select.orderby').on('change', function() {
                var params = new URLSearchParams(location.search);
                params.set('sortby', this.value);
                window.location.search = params.toString();
            });
            
            $('input.searchbox').on('keypress', function (e) {
                if (e.which === 13) {
                    $(this).attr("disabled", "disabled");
                    var params = new URLSearchParams(location.search);
                    params.set('search_content', this.value);
                    window.location.search = params.toString();
                }
            });
        });
    </script>
    <style>
        .ast-container {
            align-items: flex-start;
            flex-flow: row wrap;
            padding-bottom: 100px;
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
        
        .ast-container .topics-found-counter {
            width: 100%;
            font-size: 20px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.2;
            letter-spacing: normal;
            color: #656d75;
            margin-bottom: 16px;
        }
        
        .ast-container .topic-filtering {
            width: 100%;
            display: flex;
            margin-bottom: 16px;
            align-items: flex-start;
            flex-flow: row wrap;
        }
        
        .ast-container .topic-filtering input.searchbox {
            height: 40px;
            padding: 0 8px 0 10px;
            border-radius: 4px;
            border: solid 1px #ced4d9;
            background-color: #fff;
            flex: 1 0 0;
            margin-right: 134px;
        }
        
        .ast-container .topic-filtering select.orderby {
            height: 40px;
            padding: 0 6px 0 10px;
            border-radius: 4px;
            border: solid 1px #ced4d9;
            background-color: #fff;
            flex: 0 0 286px;
        }
        
        .ast-container .topic-filtering div.orderby {
            height: 40px;
            font-size: 14px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 40px;
            letter-spacing: normal;
            color: #656d75;
            flex: 0 0 auto;
            margin-right: 15px;
        }
        
        .ast-container .topic-list {
            width: 100%;
            border-radius: 4px;
            border: solid 1px #dde1e5;
            background-color: #ffffff;
        }
        
        .ast-container .topic-list .separator {
            width: 100%;
            height: 1px;
            background-color: #dde1e5;
        }
        
        .ast-container .topic-list .topic-item {
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
        }
        
        .ast-container .topic-list .topic-item:hover {
            background-color: #f9f9fa;
        }
        
        .ast-container .topic-list .topic-item .voting-col {
            flex: 0 0 120px;
        }
        
        .ast-container .topic-list .topic-item .voting-col .voting {
            width: 88px;
            height: 48px;
            border-radius: 4px;
            margin: 16px auto;
            display: flex;
            cursor: pointer;
        }

        .ast-container .topic-list .topic-item .voting-col .item-upvote {
            border: solid 1px #dde1e5;
            background-color: #f9f9fa;
        }

        .ast-container .topic-list .topic-item .voting-col .item-downvote {
            border: solid 1px #efe733;
            background-color: #efe733;
        }
        
        .ast-container .topic-list .topic-item .voting-col .voting .counter {
            height: 40px;
            margin-top: 3px;
            border-radius: 2px;
            border: solid 1px #ced4d9;
            line-height: 40px;
            background-color: #ffffff;
            margin-left: 3px;
            text-align: center;
            flex: 1 0 0;
        }

        .ast-container .topic-list .topic-item .voting-col .voting span {
            width: 18px;
            height: 18px;
            mask: url(<?= home_url() ?>/wp-content/plugins/joinus4health/assets/svg/thumbs-up.svg);
            mask-size: 18px;
            background-color: #3b4045;
            margin-top: 13px;
            margin-right: 10px;
            margin-left: 10px;
        }
        
        .ast-container .topic-list .topic-item .voting-col .voting span:hover {
            background-color: #000000;
        }
        
        .ast-container .topic-list .topic-item .content-col {
            flex: 1 0 0;
            display: inline-block;
            margin-bottom: 16px;
        }
        
        .ast-container .topic-list .topic-item .content-col:hover {
            cursor: pointer;
        }
        
        .ast-container .topic-list .topic-item .content-col h5 {
            float: left;
            margin-top: 16px;
        }
        
        .ast-container .topic-list .topic-item .content-col h5 a {
            font-size: 18px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.33;
            letter-spacing: normal;
            color: #3b4045;
        }
        
        .ast-container .topic-list .topic-item .content-col .tag {
            float: right;
            height: 32px;
            line-height: 32px;
            padding: 0 12px;
            font-size: 12px;
            border-radius: 16px;
            background-color: #eceef0;
            color: #808a95;
            font-size: 12px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            letter-spacing: normal;
            margin-top: 16px;
            margin-right: 16px;
        }
        
        .ast-container .topic-list .topic-item .content-col .date-time {
            float: left;
            font-size: 12px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            letter-spacing: normal;
            color: #abb4bd;
            clear: left;
        }
        
        .ast-container .topic-list .topic-item .content-col .content {
            float: left;
            width: 100%;
            font-size: 14px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.43;
            letter-spacing: normal;
            margin-top: 8px;
            color: #808a95;
            clear: both;
            padding-right: 16px;
        }
        
        .ast-container .topic-list .topic-item .content-col .tags {
            clear: both;
        }
        
        .ast-container .topic-list .topic-item .content-col .tags a {
            display: inline-block;
            line-height: 32px;
            padding-left: 12px;
            padding-right: 12px;
            margin-right: 8px;
            margin-top: 12px;
            font-size: 12px;
            text-align: center;
            border-radius: 16px;
            border: solid 1px #dde1e5;
            background-color: #ffffff;
            color: #808a95;
        }
        
        .ast-container .topic-list .topic-item .content-col .tags a:hover {
            display: inline-block;
            border: solid 1px #000000;
            background-color: #ffffff;
            color: #000000;
        }
        
        .ast-container .topic-list .topic-item .image-col {
            flex: 0 0 248px;
        }
        
        .ast-container .topic-list .topic-item .image-col:hover {
            cursor: pointer;
        }
        
        .ast-container .topic-list .topic-item .image-col .image {
            width: 224px;
            height: 136px;
            margin: 16px auto;
            border-radius: 4px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }
        
        .ast-container .pagination-down {
            height: 56px;
            padding: 12px;
            border-radius: 4px;
            border: solid 1px #dde1e5;
            margin: 48px auto 0 auto;
        }
        
        .ast-container .pagination-down a {
            display: inline-block;
            width: 32px;
            height: 32px;
            margin: 0 6px;
            border-radius: 4px;
            text-align: center;
            font-size: 18px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 32px;
            letter-spacing: normal;
            text-align: center;
            color: #808a95;
        }
        
        .ast-container .pagination-down a:hover {
            color: #3b4045;
            background-color: #f9f9fa;
        }
        
        .ast-container .pagination-down a.selected {
            background-color: #efe733;
        }
        
        .ast-container .pagination-down a.selected:hover {
            background-color: #efe733;
        }
        
        .ast-container .pagination-down a.icon {
            display: inline-block;
        }
        
        .ast-container .pagination-down a.icon span {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-bottom: 3px;
            background-color: #808a95;
            vertical-align: middle;
            background-position: center center;
            background-repeat: no-repeat;
        }
        
        .ast-container .pagination-down a.icon span.prev {
            mask: url(<?= home_url() ?>/wp-content/plugins/joinus4health/assets/svg/chevron-left.svg);
            mask-size: 20px;
        }
        
        .ast-container .pagination-down a.icon span.next {
            mask: url(<?= home_url() ?>/wp-content/plugins/joinus4health/assets/svg/chevron-right.svg);
            mask-size: 20px;
        }
    </style>
    <?php
    $query_params = array('post_type' => 'ju4htopic');
    $meta_query = array();
    $tax_query = array();

    $names = array('topictag', 'sortby');
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
                        'taxonomy' => 'ju4htopictag',
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

    if (isset($_GET['search_content']) && $_GET['search_content'] != '') {
        $query_params['s'] = $_GET['search_content'];
    }

    $page_ranges_left_right = 2;
    $query_params['posts_per_page'] = 12;
    $paged = isset($_GET['paged']) && is_numeric($_GET['paged']) ? (int)$_GET['paged'] : 1;
    $query_params['paged'] = $paged;
    $query = new WP_Query($query_params);
    ?>
    <h1><?= __('Topics') ?></h1>
    <div class="topic-filtering">
        <input type="text" class="searchbox" value="<?= esc_attr($_GET['search_content']) ?>" />
        <div class="orderby"><?= __('Order by') ?></div>
        <select class="orderby" name="sortby">
            <?php foreach ($meta_sortby as $index => $value): ?>
            <?php $selected = (isset($_GET['sortby']) && $_GET['sortby'] == $index) ? ' selected' : '' ?> 
            <option value="<?= $index ?>"<?= $selected ?>><?= $value ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="topics-found-counter"><?= $query->found_posts ?> topics found</div>
    <?php if ($query->have_posts()): ?>
    <div class="topic-list">
    <?php while ($query->have_posts()): ?>
        <?php $query->the_post(); ?>
        <?= html_topic($post) ?>
        <div class="separator"></div>
    <?php endwhile; ?>
    </div>
    <?php endif; ?>
    <?php if ($query->max_num_pages > 1): ?>
    <div class="pagination-down">
        <?php $visible_pages = $page_ranges_left_right * 2 + 1 ?>
        <?php if ($query->max_num_pages <= $visible_pages): ?>
            <?php for ($page = 1; $page <= $query->max_num_pages; $page++): ?>
            <?php $selected = ($paged == $page) ? ' class="selected"' : ''; ?>
            <a href="?paged=<?= $page ?>"<?= $selected ?>><?= $page ?></a>
            <?php endfor; ?>
        <?php else: ?>
            <?php
            $prev = true;
            $next = true;
            
            $range_min = $paged - $page_ranges_left_right;
            $range_max = $paged + $page_ranges_left_right;
            
            if ($range_min < 1) {
                $range_min = 1;
                $range_max = $visible_pages;
                $prev = false;
            } else if ($range_max > $query->max_num_pages) {
                $range_min = $query->max_num_pages - $visible_pages;
                $range_max = $query->max_num_pages;
                $next = false;
            } 
            ?>
            <?php if ($prev): ?>
            <a href="?paged=<?= $paged - 1 ?>" class="icon"><span class="prev"></span></a>
            <?php endif; ?>
            <?php for ($page = $range_min; $page <= $range_max; $page++): ?>
            <?php $selected = ($paged == $page) ? ' class="selected"' : ''; ?>
            <a href="?paged=<?= $page ?>"<?= $selected ?>><?= $page ?></a>
            <?php endfor; ?>
            <?php if ($next): ?>
            <a href="?paged=<?= $paged + 1 ?>" class="icon"><span class="next"></span></a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php endif; ?>