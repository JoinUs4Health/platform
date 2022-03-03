<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$meta = get_post_meta(get_the_ID());
get_header();
?>
<script type="text/javascript" src="<?= home_url() ?>/wp-content/plugins/joinus4health/assets/js/moment.min.js"></script>
<link rel="stylesheet" href="<?= home_url() ?>/wp-content/plugins/joinus4health/assets/css/flatpickr.min.css">
<script src="<?= home_url() ?>/wp-content/plugins/joinus4health/assets/js/flatpickr.min.js"></script>
<?php
echo get_js_script_voting();
echo get_js_load_href();

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
        var fields = ["language", "country", "group", "type", "date_since", "date_till", "infrastructure", "methodology", "content"];
        
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
                params.delete('page');
                window.location.search = params.toString();
            });
            
            $('input.searchbox').on('keypress', function (e) {
                if (e.which === 13) {
                    $(this).attr("disabled", "disabled");
                    var params = new URLSearchParams(location.search);
                    params.set('search_content', this.value);
                    params.delete('page');
                    window.location.search = params.toString();
                }
            });
            
            $('#clear-all').click(function(){
                fields.forEach(function (item, index) {
                    $('#input-'+item).val('');
                });
            });
            
            $('#filter-results').click(function(){
                params = new URLSearchParams(location.search);
                fields.forEach(function (item, index) {
                    val_ = $('#input-'+item).val();
                    if (val_ == '' || val_ == undefined) {
                        params.delete(item);
                    } else {
                        params.set(item, val_);
                    }
                });
                params.delete('page');
                window.location.search = params.toString();
            });
            
            $('.search-tags > div').click(function(){
                param_id = $(this).attr('id').split('-')[2];
                params = new URLSearchParams(location.search);
                params.delete('page');
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
            margin-bottom: 50px;
        }
        
        .ast-container .first-column {
            flex: 0 0 300px;
            width: 300px;
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
        }
        
        .ast-container .first-column .push-your-idea {
            width: 100%;
            padding: 20px 16px 16px 16px;
            border-radius: 4px;
            background-color: #efe733;
            margin-bottom: 24px;
        }
        
        .ast-container .first-column .push-your-idea h3 {
            font-family: Recoleta;
            font-size: 28px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.14;
            letter-spacing: normal;
            color: #3b4045;
        }
        
        .ast-container .first-column .push-your-idea a.btn-push-idea {
            display: block;
            width: 100%;
            height: 52px;
            margin: 16px 0 0 0;
            border-radius: 4px;
            background-color: #000000;
            font-size: 16px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 52px;
            letter-spacing: normal;
            text-align: center;
            color: #ffffff;
        }
        
        .ast-container .first-column .filtering {
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
            padding: 16px;
            border-radius: 8px;
            border: solid 1px #dde1e5;
            background-color: #f9f9fa;
        }
        
        .ast-container .first-column .filtering div.filterheader {
            width: 100%;
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
            margin-bottom: 17px;
        }
        
        .ast-container .first-column .filtering div.filterheader div.on-left {
            flex: 1 0 0;
            font-size: 16px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 24px;
            letter-spacing: normal;
            color: #3b4045;
        }
        
        .ast-container .first-column .filtering div.filterheader div.on-right {
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
        
        .ast-container .first-column .filtering div.advanced {
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
        
        .ast-container .first-column .filtering label {
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
        
        .ast-container .first-column .filtering select {
            height: 40px;
            padding: 0 6px 0 10px;
            border-radius: 4px;
            border: solid 1px #ced4d9;
            background-color: #fff;
            flex: 0 0 100%;
            width: 100%;
            margin-bottom: 15px;
        }

        .ast-container .first-column .filtering input.text {
            height: 40px;
            padding: 0 6px 0 10px;
            border-radius: 4px;
            border: solid 1px #ced4d9;
            background-color: #fff;
            flex: 0 0 100%;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .ast-container .first-column .filtering input.btns {
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
            padding: 0 35px 0 10px;
            border-radius: 4px;
            border: solid 1px #ced4d9;
            background-color: #fff;
            flex: 1 0 0;
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
            margin-left: 23px;
        }
        
        
        .ast-container .second-column div.suggestion-filtering .search-icon {
            width: 0;
            height: 0;
            position: relative;
            left: -30px;
            top: 10px;
        }
        
        .ast-container .second-column div.suggestion-filtering .search-icon svg {
            width: 17px;
            height: 17px;
            left: 30px;
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
        
        .ast-container .second-column div.search-tags div.chip {
            display: inline-block;
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
        
        .ast-container .second-column div.search-tags div.chip:hover {
            background-color: #cd2c32;
        }
        
        .ast-container .second-column div.search-tags div.chip svg {
            float: left;
            width: 16px;
            height: 16px;
            margin-top: 7px;
            margin-right: 5px;
        }
        
        .ast-container .second-column div.search-tags div.chip div.text {
            float: left;
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
        
        .ast-container .second-column div.suggestion-list div.suggestion-item .voting {
            width: 88px;
            height: 44px;
            border-radius: 4px;
            display: flex;
            cursor: pointer;
            margin-right: 16px;
        }

        .ast-container .second-column div.suggestion-list div.suggestion-item .item-upvote {
            border: solid 1px #dde1e5;
            background-color: #f9f9fa;
        }

        .ast-container .second-column div.suggestion-list div.suggestion-item .item-downvote {
            border: solid 1px #efe733;
            background-color: #efe733;
        }
        
        .ast-container .second-column div.suggestion-list div.suggestion-item .voting .counter {
            height: 36px;
            margin-top: 3px;
            border-radius: 2px;
            border: solid 1px #ced4d9;
            line-height: 36px;
            background-color: #ffffff;
            margin-left: 3px;
            text-align: center;
            flex: 1 0 0;
        }

        .ast-container .second-column div.suggestion-list div.suggestion-item .voting svg {
            width: 18px;
            height: 18px;
            stroke: #3b4045;
            margin-top: 11px;
            margin-right: 10px;
            margin-left: 10px;
        }
        
        .ast-container .second-column div.suggestion-list div.suggestion-item .voting span:hover {
            background-color: #000000;
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
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
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
        
        .ast-container .second-column .pagination-down a.icon svg {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-bottom: 3px;
            stroke: #808a95;
            vertical-align: middle;
        }
    </style>
    <div class="first-column">
        <div class="push-your-idea">
            <h3><?= __('Take part in our project — suggest your idea!', 'joinus4health') ?></h3>
            <a href="<?= home_url() ?>/ju4hsuggestion-new/" class="btn-push-idea"><?= __('Create new suggestion', 'joinus4health') ?></a>
        </div>
        <div class="filtering">
            <div class="filterheader">
                <div class="on-left"><?= __('Filter', 'joinus4health') ?></div>
                <div class="on-right" id="clear-all"><?= __('Clear all filters', 'joinus4health') ?></div>
            </div>
            <label><?= __('Language', 'joinus4health') ?></label>
            <select name="language" id="input-language">
                <option value=''><?= __('any', 'joinus4health') ?></option>
                <?php foreach ($meta_countries as $key => $value): ?>
                <option value="<?= $key ?>"<?= (isset($_GET['language']) && $key == $_GET['language']) ? ' selected' : '' ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
            <label><?= __('Country of submission', 'joinus4health') ?></label>
            <select name="country" id="input-country">
                <option value=''><?= __('any', 'joinus4health') ?></option>
                <?php foreach ($meta_countries as $key => $value): ?>
                <option value="<?= $key ?>"<?= (isset($_GET['language']) && $key == $_GET['language']) ? ' selected' : '' ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
            <label><?= __('Stakeholder group', 'joinus4health') ?></label>
            <select name="target_group" id="input-group">
                <option value=''><?= __('any', 'joinus4health') ?></option>
                <?php foreach ($meta_target_group as $key => $value): ?>
                <option value="<?= $key ?>"<?= (isset($_GET['target_group']) && $key == $_GET['target_group']) ? ' selected' : '' ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
            <label><?= __('Type', 'joinus4health') ?></label>
            <select name="type" id="input-type">
                <option value=''><?= __('any', 'joinus4health') ?></option>
                <?php foreach ($meta_types as $key => $value): ?>
                <option value="<?= $key ?>"<?= (isset($_GET['type']) && $key == $_GET['type']) ? ' selected' : '' ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
            <label><?= __('Time period / from', 'joinus4health') ?></label>
            <input type="text" class="text" name="date_since" id="input-date_since" />
            <label><?= __('Time period / to', 'joinus4health') ?></label>
            <input type="text" class="text" name="date_till" id="input-date_till" />
            <div class="advanced">
                <div class="filterheader">
                    <div class="on-left"><?= __('Advanced filters', 'joinus4health') ?></div>
                </div>
                <label><?= __('Infrastructure', 'joinus4health') ?></label>
                <select name="infrastructure" id="input-infrastructure">
                    <option value=''><?= __('any', 'joinus4health') ?></option>
                    <?php foreach ($meta_infrastructure as $key => $value): ?>
                    <option value="<?= $key ?>"<?= (isset($_GET['infrastructure']) && $key == $_GET['infrastructure']) ? ' selected' : '' ?>><?= $value ?></option>
                    <?php endforeach; ?>
                </select>
                <label><?= __('Methodology', 'joinus4health') ?></label>
                <select name="methodology" id="input-methodology">
                    <option value=''><?= __('any', 'joinus4health') ?></option>
                    <?php foreach ($meta_methodology as $key => $value): ?>
                    <option value="<?= $key ?>"<?= (isset($_GET['methodology']) &&$key == $_GET['methodology']) ? ' selected' : '' ?>><?= $value ?></option>
                    <?php endforeach; ?>
                </select>
                <label><?= __('Content', 'joinus4health') ?></label>
                <select name="content" id="input-content">
                    <option value=''><?= __('any', 'joinus4health') ?></option>
                    <?php foreach ($meta_content as $key => $value): ?>
                    <option value="<?= $key ?>"<?= (isset($_GET['content']) && $key == $_GET['content']) ? ' selected' : '' ?>><?= $value ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="button" class="btns" id="filter-results" value="<?= __('Filter results', 'joinus4health') ?>"  />
        </div>
    </div>
    <div class="second-column">
        <h1><?= __('Suggestions', 'joinus4health') ?></h1>
        <div class="suggestion-filtering">
            <input type="text" class="searchbox" placeholder="<?= __('Search by title...', 'joinus4health') ?>" value="<?= isset($_GET['search_content']) ? esc_attr($_GET['search_content']) : '' ?>" />
            <div class="search-icon">
                <i data-feather="search"></i>
            </div>
            <div class="orderby"><?= __('Order by', 'joinus4health') ?></div>
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
        $get_params = array();

        if (isset($date_since_obj) || isset($date_till_obj)) {
            $query_params['date_query'] = array();

            if ($date_since_obj) {
                $query_params['date_query']['after'] = array(
                    'year' => $date_since_obj->format('Y'),
                    'month' => $date_since_obj->format('n'),
                    'day' => $date_since_obj->format('j')
                );
                
                $get_params['date_since'] = $date_since_obj->format('Y-m-d');
            }

            if ($date_till_obj) {
                $query_params['date_query']['before'] = array(
                    'year' => $date_till_obj->format('Y'),
                    'month' => $date_till_obj->format('n'),
                    'day' => $date_till_obj->format('j')
                );
                
                $get_params['date_till'] = $date_till_obj->format('Y-m-d');
            }

            $query_params['date_query']['inclusive'] = true;
        }
        
        $names = array(
            'sortby' => $meta_sortby_suggestion, 
            'language' => $meta_countries, 
            'duration' => $meta_contribute_duration, 
            'type' => $meta_types, 
            'level' => $meta_level, 
            'source' => $meta_source, 
            'target_group' => $meta_target_group, 
            'infrastructure' => $meta_infrastructure, 
            'methodology' => $meta_methodology, 
            'content' => $meta_content,
        );
        foreach ($names as $name => $values) {
            if (isset($_GET[$name]) && $_GET[$name] != '') {
                if ($name == 'sortby') {
                    if ($_GET[$name] == 'votes') {
                        $query_params['orderby'] = array('m_votes_count' => 'DESC', 'date' => 'DESC');
                        $query_params['meta_type'] = 'NUMERIC';
                        $query_params['meta_key'] = 'm_votes_count';                    
                        $get_params['sortby'] = $_GET['sortby'];                    
                    } else {
                        $query_params['orderby'] = array('date' => 'DESC');
                        $get_params['sortby'] = '';
                    }
                } else if (array_key_exists($_GET[$name], $values)) {
                    $meta_query['relation'] = 'AND';
                    $meta_query[$name."_clause"] = array(
                        'key' => 'm_'.$name,
                        'value' => $_GET[$name]
                    );
                    $get_params[$name] = $_GET[$name];
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
            $get_params['search_content'] = esc_attr($_GET['search_content']);
        }

        $page_ranges_left_right = 2;
        $query_params['posts_per_page'] = $per_page_suggestion;
        $paged = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $query_params['paged'] = $paged;
        $query = new WP_Query($query_params);
        ?>
        <div class="suggestions-found"><?= $query->found_posts ?> <?= __('suggestions found', 'joinus4health') ?></div>
        <div class="search-tags">
            <?php
            $tags_html = null;
            $filter_count = 0;
            $filters = array(
                'language' => array(
                    '_' => __('language', 'joinus4health'),
                    'items' => $meta_countries,
                ),
                'duration' => array(
                    '_' => __('duration', 'joinus4health'),
                    'items' => $meta_contribute_duration,
                ),
                'type' => array(
                    '_' => __('type', 'joinus4health'),
                    'items' => $meta_types,
                ),
                'level' => array(
                    '_' => __('level', 'joinus4health'),
                    'items' => $meta_level,
                ),
                'source' => array(
                    '_' => __('source', 'joinus4health'),
                    'items' => $meta_source,
                ),
                'target_group' => array(
                    '_' => __('targeted stakeholder group', 'joinus4health'),
                    'items' => $meta_target_group,
                ),
                'infrastructure' => array(
                    '_' => __('infrastructure', 'joinus4health'),
                    'items' => $meta_infrastructure,
                ), 
                'methodology' => array(
                    '_' => __('methodology', 'joinus4health'),
                    'items' => $meta_methodology,
                ), 
                'content' => array(
                    '_' => __('content', 'joinus4health'),
                    'items' => $meta_content,
                ),
            );
            ?>
            <?php foreach ($filters as $key => $value): ?>
                <?php 
                if (isset($_GET[$key]) && isset($value['items'][$_GET[$key]])) {
                    $tags_html .= '<div id="remove-filter-'.$key.'" class="chip"><i data-feather="x-circle"></i><div class="text">'.$value['_'].': '.$value['items'][$_GET[$key]].'</div></div>';
                    $filter_count++;
                }
                ?>
            <?php endforeach; ?>
            <?php 
            if (isset($_GET['search_content'])) {
                $tags_html .= '<div id="remove-filter-search_content" class="chip"><i data-feather="x-circle"></i><div class="text">'.__('search', 'joinus4health').': '.esc_attr($_GET['search_content']).'</div></div>';
                $filter_count++;
            }
            
            if (isset($get_params['date_since'])) {
                $tags_html .= '<div id="remove-filter-date_since" class="chip"><i data-feather="x-circle"></i><div class="text">'.__('date since', 'joinus4health').': '.$get_params['date_since'].'</div></div>';
                $filter_count++;
            }
            
            if (isset($get_params['date_till'])) {
                $tags_html .= '<div id="remove-filter-date_till" class="chip"><i data-feather="x-circle"></i><div class="text">'.__('date till', 'joinus4health').': '.$get_params['date_till'].'</div></div>';
                $filter_count++;
            }
            ?>
            <?php if ($tags_html != null): ?>
            <div id="remove-filter-" class="chip"><i data-feather="x-circle"></i><div class="text"><?= __('clear filters', 'joinus4health') ?> (<?= $filter_count ?>)</div></div>
            <?= $tags_html ?>
            <?php endif; ?>
        </div>
        <div class="suggestion-list">
        <?php $i = 1 ?>
        <?php while ($query->have_posts()): ?>
            <?php $query->the_post(); ?>
            <?php html_suggestion($post) ?>
            <?php if ($query->post_count != $i++): ?>
            <div class="separator"></div>
            <?php endif; ?>
        <?php endwhile; ?>
        </div>
        <?php $get_query = get_query($get_params); ?>
        <?php if ($query->max_num_pages > 1): ?>
        <div class="pagination-down">
            <?php $visible_pages = $page_ranges_left_right * 2 + 1 ?>
            <?php if ($query->max_num_pages <= $visible_pages): ?>
                <?php for ($page = 1; $page <= $query->max_num_pages; $page++): ?>
                <?php $selected = ($paged == $page) ? ' class="selected"' : ''; ?>
                <a href="?page=<?= $page ?>&amp;<?= $get_query ?>"<?= $selected ?>><?= $page ?></a>
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
                <a href="?page=<?= $paged - 1 ?>&amp;<?= $get_query ?>" class="icon"><i data-feather="chevron-left"></i></a>
                <?php endif; ?>
                <?php for ($page = $range_min; $page <= $range_max; $page++): ?>
                <?php $selected = ($paged == $page) ? ' class="selected"' : ''; ?>
                <a href="?page=<?= $page ?>&amp;<?= $get_query ?>"<?= $selected ?>><?= $page ?></a>
                <?php endfor; ?>
                <?php if ($next): ?>
                <a href="?page=<?= $paged + 1 ?>&amp;<?= $get_query ?>" class="icon"><i data-feather="chevron-right"></i></a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php
    get_footer();