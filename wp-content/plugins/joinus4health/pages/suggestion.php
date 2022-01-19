<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<?php
$meta = get_post_meta(get_the_ID());
get_header();

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

    <script type="text/javascript">
        $(document).ready(function(){
            $("#input-date_since").flatpickr({
                dateFormat: "Y-m-d",
                defaultDate: <?= ($date_since == null) ? 'null' : "'$date_since'" ?>
            });

            $("#input-date_till").flatpickr({
                dateFormat: "Y-m-d",
                defaultDate: <?= ($date_till == null) ? 'null' : "'$date_till'" ?>
            });
            
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
            
            $('#clear-all').click(function(){
                $('#input-language').val('');
                $('#input-duration').val('');
                $('#input-type').val('');
                $('#input-level').val('');
                $('#input-source').val('');
                $('#input-group').val('');
            });
            
            $('#filter-results').click(function(){
                params = new URLSearchParams(location.search);
                fields = ["language", "duration", "type", "level", "source", "group"];
                fields.forEach(function (item, index) {
                    val_ = $('#input-'+item).val();
                    if (val_ == '') {
                        params.delete(item);
                    } else {
                        params.set(item, val_);
                    }
                });
                window.location.search = params.toString();
            });
            
            $('.search-tags > div').click(function(){
                param_id = $(this).attr('id').split('-')[2];
                params = new URLSearchParams(location.search);
                if (param_id != '') {
                    params.delete(param_id);
                    window.location.search = params.toString();
                } else {
                    window.location.search = '';
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
        
        .ast-container .first-column {
            flex: 0 0 300px;
            width: 300px;
            padding: 16px;
            border-radius: 8px;
            border: solid 1px #dde1e5;
            background-color: #f9f9fa;
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
        }
        
        .ast-container .first-column div.filterheader {
            width: 100%;
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
            margin-bottom: 17px;
        }
        
        .ast-container .first-column div.filterheader div.on-left {
            flex: 1 0 0;
            font-size: 16px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 24px;
            letter-spacing: normal;
            color: #3b4045;
        }
        
        .ast-container .first-column div.filterheader div.on-right {
            flex: 1 0 0;
            font-size: 14px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 24px;
            letter-spacing: normal;
            text-align: right;
            color: #2570ae;
            cursor: pointer;
            text-decoration: underline;
        }
        
        .ast-container .first-column div.advanced {
            padding: 15px 12px 0 12px;
            border-radius: 4px;
            border: solid 1px #eceef0;
            background-color: #dde1e5;
            flex: 0 0 100%;
            margin-bottom: 16px;
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
        }
        
        .ast-container .first-column label {
            font-size: 14px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.43;
            letter-spacing: normal;
            color: #656d75;
            width: 100%;
            margin-bottom: 7px;
        }
        
        .ast-container .first-column select {
            height: 40px;
            padding: 0 6px 0 10px;
            border-radius: 4px;
            border: solid 1px #ced4d9;
            background-color: #fff;
            flex: 0 0 100%;
            width: 100%;
            margin-bottom: 15px;
        }

        .ast-container .first-column input.text {
            height: 40px;
            padding: 0 6px 0 10px;
            border-radius: 4px;
            border: solid 1px #ced4d9;
            background-color: #fff;
            flex: 0 0 100%;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .ast-container .first-column input.btns {
            height: 52px;
            border-radius: 4px;
            background-color: #000000;
            font-size: 16px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.5;
            letter-spacing: normal;
            text-align: center;
            color: #ffffff;
            flex: 0 0 100%;
        }
        
        .ast-container .second-column div.suggestion-filtering select {
            height: 40px;
            padding: 0 6px 0 10px;
            border-radius: 4px;
            border: solid 1px #ced4d9;
            background-color: #fff;
            flex: 0 0 100%;
            width: 100%;
        }
        
        .ast-container .second-column {
            flex: 1 0 0;
            margin-left: 24px;
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
        }
        
        .ast-container .second-column h1 {
            flex: 1 0 0;
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
        
        .ast-container .second-column div.suggestion-filtering {
            width: 100%;
            display: flex;
            margin-bottom: 16px;
            align-items: flex-start;
            flex-flow: row wrap;
        }
        
        .ast-container .second-column div.suggestion-filtering input.searchbox {
            height: 40px;
            padding: 0 8px 0 10px;
            border-radius: 4px;
            border: solid 1px #ced4d9;
            background-color: #fff;
            flex: 1 0 0;
            margin-right: 23px;
        }
        
        .ast-container .second-column div.suggestion-filtering select.orderby {
            height: 40px;
            padding: 0 6px 0 10px;
            border-radius: 4px;
            border: solid 1px #ced4d9;
            background-color: #fff;
            flex: 0 0 286px;
        }
        
        .ast-container .second-column div.suggestion-filtering div.orderby {
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
        
        .ast-container .second-column div.suggestions-found {
            font-size: 20px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.2;
            letter-spacing: normal;
            color: #656d75;
            flex: 0 0 100%;
        }

        .ast-container .second-column div.search-tags {
            align-items: flex-start;
            flex-flow: row wrap;
            display: flex;
            margin-top: 16px;
        }
        
        .ast-container .second-column div.search-tags div {
            height: 32px;
            line-height: 32px;
            border-radius: 16px;
            background-color: #808a95;
            font-size: 12px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            letter-spacing: normal;
            color: #ffffff;
            padding-left: 9px;
            padding-right: 9px;
            cursor: pointer;
            margin-right: 8px;
            margin-bottom: 4px;
        }
        
        .ast-container .second-column div.search-tags div:hover {
            background-color: #cd2c32;
        }
        
        .ast-container .second-column div.suggestion-list {
            border-radius: 8px;
            border: solid 1px #dde1e5;
            background-color: #ffffff;
            flex: 0 0 100%;
            margin-top: 16px;
        }
        
        .ast-container .second-column div.suggestion-list div.suggestion-item {
            padding: 0 16px 0 16px;
            align-items: center;
            height: 76px;
            display: flex;
            flex-flow: row wrap;
            cursor: pointer;
        }
        
        .ast-container .second-column div.suggestion-list div.suggestion-item:hover {
            background-color: #f9f9fa;
        }
        
        .ast-container .second-column div.suggestion-list div.suggestion-item div.two-line-content {
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
            flex: 1 0 0;
        }
        
        .ast-container .second-column div.suggestion-list div.suggestion-item div.two-line-content a.title {
            flex: 0 0 100%;
            font-size: 18px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.33;
            letter-spacing: normal;
            color: #3b4045;
        }
        
       .ast-container .second-column div.suggestion-list div.suggestion-item div.two-line-content div.days-left {
            flex: 0 0 auto;
            font-size: 12px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.67;
            letter-spacing: normal;
            color: #3b4045;
            margin-right: 8px;
        }
        
       .ast-container .second-column div.suggestion-list div.suggestion-item div.two-line-content div.submit-by {
            flex: 0 0 auto;
            font-size: 12px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.67;
            letter-spacing: normal;
            color: #abb4bd;
        }
        
        .ast-container .second-column div.suggestion-list div.suggestion-item div.tag {
            height: 32px;
            border-radius: 16px;
            background-color: #eceef0;
            font-size: 12px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 32px;
            letter-spacing: normal;
            color: #808a95;
            padding-left: 12px;
            padding-right: 12px;
            margin-left: 8px;
        }
        
        .ast-container .second-column div.suggestion-list div.separator {
            height: 1px;
            background-color: #dde1e5;
            flex: 1 0 100%;
        }
        
        .ast-container .second-column .pagination-down {
            height: 56px;
            padding: 12px;
            border-radius: 4px;
            border: solid 1px #dde1e5;
            margin: 48px auto 0 auto;
        }
        
        .ast-container .second-column .pagination-down a {
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
        
        .ast-container .second-column .pagination-down a:hover {
            color: #3b4045;
            background-color: #f9f9fa;
        }
        
        .ast-container .second-column .pagination-down a.selected {
            background-color: #efe733;
        }
        
        .ast-container .second-column .pagination-down a.selected:hover {
            background-color: #efe733;
        }
        
        .ast-container .second-column .pagination-down a.icon {
            display: inline-block;
        }
        
        .ast-container .second-column .pagination-down a.icon span {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-bottom: 3px;
            background-color: #808a95;
            vertical-align: middle;
            background-position: center center;
            background-repeat: no-repeat;
        }
        
        .ast-container .second-column .pagination-down a.icon span.prev {
            mask: url(<?= home_url() ?>/wp-content/plugins/joinus4health/assets/svg/chevron-left.svg);
            mask-size: 20px;
        }
        
        .ast-container .second-column .pagination-down a.icon span.next {
            mask: url(<?= home_url() ?>/wp-content/plugins/joinus4health/assets/svg/chevron-right.svg);
            mask-size: 20px;
        }

    </style>
    <div class="first-column">
        <div class="filterheader">
            <div class="on-left">Filter</div>
            <div class="on-right" id="clear-all">Clear all filters</div>
        </div>
        <label><?= _('Language') ?></label>
        <select name="language" id="input-language">
            <option value=''>any</option>
            <?php foreach ($meta_countries as $key => $value): ?>
            <option value="<?= $key ?>"<?= ($key == $_GET['language']) ? ' selected' : '' ?>><?= $value ?></option>
            <?php endforeach; ?>
        </select>
        <label><?= _('Country of submission') ?></label>
        <select name="language" id="input-language">
            <option value=''>any</option>
            <?php foreach ($meta_countries as $key => $value): ?>
            <option value="<?= $key ?>"<?= ($key == $_GET['language']) ? ' selected' : '' ?>><?= $value ?></option>
            <?php endforeach; ?>
        </select>
        <label><?= _('Stakeholder group') ?></label>
        <select name="target_group" id="input-group">
            <option value=''>any</option>
            <?php foreach ($meta_target_group as $key => $value): ?>
            <option value="<?= $key ?>"<?= ($key == $_GET['target_group']) ? ' selected' : '' ?>><?= $value ?></option>
            <?php endforeach; ?>
        </select>
        <label><?= _('Type') ?></label>
        <select name="type" id="input-type">
            <option value=''>any</option>
            <?php foreach ($meta_types as $key => $value): ?>
            <option value="<?= $key ?>"<?= ($key == $_GET['type']) ? ' selected' : '' ?>><?= $value ?></option>
            <?php endforeach; ?>
        </select>
        <label><?= _('Time period / from') ?></label>
        <input type="text" class="text" name="date_since" id="input-date_since" />
        <label><?= _('Time period / to') ?></label>
        <input type="text" class="text" name="date_till" id="input-date_till" />
        <div class="advanced">
            <div class="filterheader">
                <div class="on-left">Advanced filters</div>
            </div>
            <label><?= _('Infrastructure') ?></label>
            <select name="infrastructure" id="input-infrastructure">
                <option value=''>any</option>
                <?php foreach ($meta_types as $key => $value): ?>
                <option value="<?= $key ?>"<?= ($key == $_GET['type']) ? ' selected' : '' ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
            <label><?= _('Methodology') ?></label>
            <select name="methodology" id="input-methodology">
                <option value=''>any</option>
                <?php foreach ($meta_types as $key => $value): ?>
                <option value="<?= $key ?>"<?= ($key == $_GET['type']) ? ' selected' : '' ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
            <label><?= _('Content') ?></label>
            <select name="content" id="input-content">
                <option value=''>any</option>
                <?php foreach ($meta_types as $key => $value): ?>
                <option value="<?= $key ?>"<?= ($key == $_GET['type']) ? ' selected' : '' ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <input type="button" class="btns" id="filter-results" value="<?= _('Filter results') ?>"  />
    </div>
    <div class="second-column">
        <h1><?= _('Suggestions') ?></h1>
        <div class="suggestion-filtering">
            <input type="text" class="searchbox" placeholder="<?= _('Search by title...') ?>" value="<?= esc_attr($_GET['search_content']) ?>" />
            <div class="orderby"><?= __('Order by') ?></div>
            <select class="orderby" name="sortby">
                <?php foreach ($meta_sortby_suggestion as $index => $value): ?>
                <?php $selected = (isset($_GET['sortby']) && $_GET['sortby'] == $index) ? ' selected' : '' ?> 
                <option value="<?= $index ?>"<?= $selected ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php
        $query_params = array('post_type' => 'ju4hsuggestion');
        $meta_query = array();
        $tax_query = array();

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
        
        $names = array('sortby', 'language', 'duration', 'type', 'level', 'source', 'target_group');
        foreach ($names as $name) {
            if (isset($_GET[$name]) && $_GET[$name] != '') {
                if ($name == 'sortby') {
                    if ($_GET[$name] == 'recent') {
                        $query_params['orderby'] = array('date' => 'DESC');
                    } else if ($_GET[$name] == 'oldest') {
                        $query_params['orderby'] = array('date' => 'ASC');
                    }
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
        <div class="suggestions-found"><?= $query->found_posts ?> suggestions found</div>
        <div class="search-tags">
            <?php
            $tags_html = null;
            $filter_count = 0;
            $filters = array(
                'language' => array(
                    '_' => 'language',
                    'items' => $meta_countries,
                ),
                'duration' => array(
                    '_' => 'duration',
                    'items' => $meta_contribute_duration,
                ),
                'type' => array(
                    '_' => 'type',
                    'items' => $meta_types,
                ),
                'level' => array(
                    '_' => 'level',
                    'items' => $meta_level,
                ),
                'source' => array(
                    '_' => 'source',
                    'items' => $meta_source,
                ),
                'target_group' => array(
                    '_' => 'targeted stakeholder group',
                    'items' => $meta_target_group,
                )
            );
            ?>
            <?php foreach ($filters as $key => $value): ?>
                <?php 
                if (isset($_GET[$key]) && isset($value['items'][$_GET[$key]])) {
                    $tags_html .= '<div id="remove-filter-'.$key.'">'._($value['_']).': '.$value['items'][$_GET[$key]].'</div>';
                    $filter_count++;
                }
                ?>
            <?php endforeach; ?>
            <?php if (isset($_GET['search_content'])) {
                $tags_html .= '<div id="remove-filter-search_content">'._('search').': '.esc_attr($_GET['search_content']).'</div>';
                $filter_count++;
            }
            ?>
            <?php if ($tags_html != null): ?>
            <div id="remove-filter-"><?= _('clear filters') ?> (<?= $filter_count ?>)</div>
            <?= $tags_html ?>
            <?php endif; ?>
        </div>
        <div class="suggestion-list">
        <?php while ($query->have_posts()): ?>
            <?php $query->the_post(); ?>
            <?php html_suggestion($post) ?>
            <div class="separator"></div>
        <?php endwhile; ?>
        </div>        
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
    </div>