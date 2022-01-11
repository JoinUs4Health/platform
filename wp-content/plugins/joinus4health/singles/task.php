<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

the_post();
?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<?php
$meta = get_post_meta(get_the_ID());
get_header();
echo js_script_voting(get_the_permalink());
echo js_script_follow(get_the_permalink());
?>
    <style>
        .ast-container {
            align-items: flex-start;
            flex-flow: row wrap;
            padding-bottom: 100px;
        }
        
        .column-common-border-style {
            border: 1px solid #e7e7e7;
            background-color: #ffffff;
            border-radius: 4px;
        }
        
        .ast-container .bread-crumb {
            display: flex;
            flex-flow: row wrap;
            padding-bottom: 24px;
            flex: 0 0 100%;
        }
        
        .ast-container .bread-crumb a.homepage {
            width: 14px;
            height: 14px;
            mask: url(<?= home_url() ?>/wp-content/plugins/joinus4health/assets/svg/home.svg);
            background-color: #808a95;
            mask-size: 14px;
        }
        
        .ast-container .bread-crumb span {
            width: 13px;
            height: 13px;
            mask: url(<?= home_url() ?>/wp-content/plugins/joinus4health/assets/svg/chevron-right.svg);
            background-color: #808a95;
            mask-size: 13px;
            margin-top: 1px;
            margin-right: 10px;
            margin-left: 10px;
        }
        
        .ast-container .bread-crumb a.txt {
            font-family: 'Manrope', sans-serif;
            font-size: 12px;
            font-weight: 600;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.33;
            letter-spacing: normal;
            color: #808a95;
        }
        
        .ast-container .bread-crumb a.txt:hover {
            text-decoration: underline;
        }
        
        .ast-container .top-column-2-colspan {
            flex: 0 1 100%;
            margin-bottom: 24px;
        }
        
        .ast-container .first-column {
            flex: 1 0 0;
            margin-right: 24px;
        }
        
        .ast-container .first-column .separator {
            width: 100%;
            height: 1px;
            margin-top: 24px;
            margin-bottom: 24px;
            background-color: #dde1e5;
        }
        
        .ast-container .first-column .content {
            padding-top: 24px;
        }
        
        .ast-container .first-column .content h2 {
            font-family: Recoleta;
            font-size: 28px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.14;
            letter-spacing: normal;
            color: #3b4045;
            margin-left: 20px;
        }
        
        .ast-container .first-column .content h6 {
            display: block;
            width: 100%;
            line-height: 24px;
            color: #3b4045;
            padding-left: 20px;
            font-size: 18px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.33;
            letter-spacing: normal;
        }

        .ast-container .first-column .content p {
            font-size: 16px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.5;
            letter-spacing: normal;
            margin-bottom: 0;
            
            display: block;
            width: 100%;
            line-height: 24px;
            color: #3b4045;
            padding-left: 20px;
            padding-top: 12px;
        }
        
        .ast-container .first-column .content .tags {
            display: block;
            width: 100%;
            padding-left: 16px;
            padding-top: 12px;
        }
        
        .ast-container .first-column .content .tags a {
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
        
        
        .ast-container .first-column .content .tags a:hover {
            display: inline-block;
            border: solid 1px #000000;
            background-color: #ffffff;
            color: #000000;
        }
        
        .ast-container .first-column .content .related-topic {
            margin: 20px;
            background-color: #ffffff;
            display: flex;
            flex-flow: row wrap;
            align-items: center;
            cursor: pointer;
            height: 76px;
            padding-left: 16px;
            padding-right: 16px;
        }
        
        .ast-container .first-column .content .related-topic:hover {
            background-color: #f9f9fa;
        }
        
        .ast-container .first-column .content .related-topic div.two-line-content {
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
            flex: 1 0 0;
        }
        
        .ast-container .first-column .content .related-topic div.two-line-content a.title {
            flex: 0 0 100%;
            font-size: 18px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.33;
            letter-spacing: normal;
            color: #3b4045;
        }
        
       .ast-container .first-column .content .related-topic div.two-line-content div.days-left {
            flex: 0 0 auto;
            font-size: 12px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.67;
            letter-spacing: normal;
            color: #3b4045;
        }
        
       .ast-container .first-column .content .related-topic div.two-line-content div.submit-by {
            flex: 0 0 auto;
            font-size: 12px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.67;
            letter-spacing: normal;
            color: #abb4bd;
            margin-left: 8px;
        }
        
        .ast-container .first-column .content .related-topic div.tag {
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
        
        .ast-container .second-column {
            flex: 0 0 360px;
        }
        
        .ast-container .second-column .separator {
            width: 100%;
            height: 1px;
            margin-top: 20px;
            margin-bottom: 20px;
            background-color: #dde1e5;
        }
        
        .ast-container .second-column h6 {
            display: block;
            width: 100%;
            line-height: 24px;
            color: #3b4045;
            padding-left: 20px;
            padding-bottom: 8px;
            font-size: 16px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            letter-spacing: normal;
        }
        
        .ast-container .second-column .details .author {
            padding-left: 20px;
            padding-right: 20px;
            padding-top: 20px;
            display: flex;
            flex-flow: row wrap;
            align-items: flex-start;
        }
        
        .ast-container .second-column .details .author .avatar {
            width: 40px;
            height: 40px;
            border-radius: 28px;
            border: solid 1px #dde1e5;
            background-color: #f9f9fa;
            flex: 0 0 40px;
        }
        
        
        .ast-container .second-column .details .author .lines {
            flex: 1 0 auto;
            padding-left: 12px;
        }
        
        .ast-container .second-column .details .author .lines .name {
            font-size: 16px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.4;
            letter-spacing: normal;
            color: #3b4045;
        }
        
        .ast-container .second-column .details .author .lines .sub {
            font-size: 12px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.33;
            letter-spacing: normal;
            color: #808a95;
        }
        
        .ast-container .second-column .details .tags-info {
            display: block;
            width: 100%;
            padding-left: 20px;
            margin-bottom: 10px;
        }
        
        .ast-container .second-column .details .tags-info div {
            display: inline-block;
            line-height: 32px;
            padding-left: 12px;
            padding-right: 12px;
            margin-right: 8px;
            font-size: 12px;
            text-align: center;
            border-radius: 16px;
            background-color: #eceef0;
            color: #808a95;
            margin-bottom: 10px;
        }
        
        .ast-container .second-column .details .rows {
            display: flex;
            flex-flow: row wrap;
            padding-left: 20px;
        }
        
        .ast-container .second-column .details .rows div {
            flex: 1 0 50%;
            font-size: 12px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.33;
            letter-spacing: normal;
            color: #808a95;
            padding-bottom: 0;
        }
        
        .ast-container .second-column .details .rows div.value {
            font-size: 16px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.5;
            letter-spacing: normal;
            color: #3b4045;
        }
        
        .ast-container .second-column .details .rows2 {
            display: flex;
            flex-flow: row wrap;
            padding-left: 20px;
            padding-right: 20px;
        }
        
        .ast-container .second-column .details .rows2 div {
            flex: 1 0 146px;
            font-size: 14px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.43;
            letter-spacing: normal;
            color: #808a95;
            margin-bottom: 16px;
        }
        
        .ast-container .second-column .details .rows2 span {
            width: 12px;
            height: 12px;
            background-color: #3b4045;
            margin-top: 3px;
            margin-right: 9px;
        }
        
        .ast-container .second-column .details .rows2 span.flag {
            mask: url(<?= home_url() ?>/wp-content/plugins/joinus4health/assets/svg/flag.svg);
            mask-size: 12px;
        }
        
        .ast-container .second-column .details .rows2 span.users {
            mask: url(<?= home_url() ?>/wp-content/plugins/joinus4health/assets/svg/users.svg);
            mask-size: 12px;
        }
                
        .ast-container .second-column .details .rows2 span.disc {
            mask: url(<?= home_url() ?>/wp-content/plugins/joinus4health/assets/svg/disc.svg);
            mask-size: 12px;
        }
        
        .ast-container .second-column .details .rows2 div.value {
            text-align: right;
            color: #3b4045;
        }
        
        .ast-container .second-column .estimate {
            margin-top: 24px;
            padding: 20px;
            background-color: #f9f9fa;
        }
        
        .ast-container .second-column .estimate h6 {
            font-size: 16px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.5;
            letter-spacing: normal;
            color: #3b4045;
            padding: 0 0 8px 0;
        }
        
        .ast-container .second-column .estimate div.time {
            font-size: 24px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 1;
            letter-spacing: normal;
            color: #3b4045;
        }
        
        .ast-container .second-column .estimate input.btn-contribute {
            width: 100%;
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
            margin-top: 20px;
        }
    </style>
    <div class="bread-crumb">
        <a href="<?= home_url() ?>" class="homepage"></a>
        <span></span>
        <a href="<?= home_url() ?>/ju4htasks/" class="txt">Tasks</a>
    </div>
    <div class="first-column">
        <div class="content column-common-border-style">
            <h2><?= $post->post_title ?></h2>
            <div class="separator"></div>
            <h6><?= _('Task details') ?></h6>
            <p><?= get_post_meta(get_the_ID(), 'm_description', true) ?></p>
            <div class="separator"></div>
            <h6>Related topic (todo)</h6>
            <div class="related-topic column-common-border-style">
                <div class="two-line-content">
                    <a href="#" class="title">title</a>
                    <div class="days-left">2 days left</div>
                    <div class="submit-by">submitted by me</div>
                </div>
                <div class="tag">tag</div>
            </div>
        </div>
    </div>
    <div class="second-column">
        <div class="details column-common-border-style">
            <div class="author">
                <div class="avatar"></div>
                <div class="lines">
                    <div class="name"><?php the_author() ?></div>
                    <div class="sub">Subtitle (todo/question)</div>
                </div>
            </div>
            <div class="separator"></div>
            <div class="tags-info">
                <?php $m_status = get_post_meta($post->ID, 'm_status', true) ?>
                <?= isset($meta_status[$m_status]) ? '<div>'.$meta_status[$m_status].'</div>' : "" ?>
            </div>
            <div class="rows">
                <div>Created</div>
                <div>Valid thru</div>
                <div class="value"><?= time_ago($post) ?></div>
                <div class="value">31 dec 2021 (todo)</div>
            </div>
            <?php $m_language = get_post_meta($post->ID, 'm_language', true) ?>
            <?php $m_target_group = get_post_meta($post->ID, 'm_target_group', true) ?>
            <?php $m_source = get_post_meta($post->ID, 'm_source', true) ?>
            <?php if (isset($m_language) || isset($m_target_group) || isset($m_source)): ?>
            <div class="separator"></div>
            <div class="rows2">
                <?php if (isset($m_language)): ?>
                <span class="flag"></span>
                <div><?= __('Language') ?></div>
                <div class="value"><?= $meta_countries[$m_language] ?></div>
                <?php endif; ?>
                <?php if (isset($m_target_group)): ?>
                <span class="users"></span>
                <div><?= __('Stakeholder group') ?></div>
                <div class="value"><?= $meta_target_group[$m_target_group] ?></div>
                <?php endif; ?>
                <?php if (isset($m_source)): ?>
                <span class="disc"></span>
                <div><?= __('Source') ?></div>
                <div class="value"><?= $meta_source[$m_source] ?></div>
                <?php endif; ?>
                <?php if (isset($m_source)): ?>
                <span class="disc"></span>
                <div><?= __('Level (todo)') ?></div>
                <div class="value"><?= $meta_source[$m_source] ?></div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="estimate column-common-border-style">
            <h6>Time estimate</h6>
            <div class="time">2 hours</div>
            <input type="button" class="btn-contribute" value="<?= _('Contribute') ?>" />
        </div>
    </div>
<?php get_footer(); ?>