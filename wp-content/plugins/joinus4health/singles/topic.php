<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

the_post();
$topic_post = $post;
$meta = get_post_meta(get_the_ID());
get_header();
$preferred_language = get_preferred_language();
js_add_or_reply_comment();
echo get_js_script_voting(get_the_permalink());
echo get_js_script_follow(get_the_permalink());
echo get_js_script_contribute(get_the_permalink());
echo get_js_load_href();
html_modal_share(get_the_permalink());
html_modal_uncontribute();
html_modal_contribute();
html_modal_follow();
?>
    <style>
        .ast-container {
            align-items: flex-start;
            flex-flow: row wrap;
            margin-bottom: 40px;
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
            line-height: normal;
        }
        
        .ast-container .bread-crumb a.homepage svg {
            width: 14px;
            height: 14px;
            stroke: #808a95;
            margin: 0;
        }
        
        .ast-container .bread-crumb svg {
            width: 13px;
            height: 13px;
            stroke: #808a95;
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
        
        .ast-container .top-column-2-colspan .image {
            width: 100%;
            height: 346px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            border-radius: 4px 4px 0 0;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons {
            height: 88px;
            display: flex;
            align-items: center;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .voting {
            width: 88px;
            height: 48px;
            border-radius: 4px;
            margin-left: 20px;
            display: flex;
            cursor: pointer;
        }

        .ast-container .top-column-2-colspan .title-and-buttons .item-upvote {
            border: solid 1px #dde1e5;
            background-color: #f9f9fa;
        }

        .ast-container .top-column-2-colspan .title-and-buttons .item-downvote {
            border: solid 1px #efe733;
            background-color: #efe733;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .voting .counter {
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

        .ast-container .top-column-2-colspan .title-and-buttons .voting svg {
            width: 18px;
            height: 18px;
            stroke: #3b4045;
            margin-top: 13px;
            margin-right: 10px;
            margin-left: 10px;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .voting svg:hover {
            stroke: #000000;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .title {
            font-family: Recoleta;
            margin-left: 16px;
            flex: 1 0 0;
            font-size: 28px;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .btn {
            display: inline-block;
            border: solid 1px #dde1e5;
            border-radius: 4px;
            height: 48px;
            padding-left: 24px;
            padding-right: 24px;
            margin-right: 12px;
            background-color: #f9f9fa;
            font-size: 16px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 45px;
            letter-spacing: normal;
            text-align: center;
            color: #000000;
            cursor: pointer;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .btn:hover {
            background-color: #ededed;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .item-unfollow {
            background-color: #eceef0;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .btn svg {
            float: left;
            width: 17px;
            height: 17px;
            margin-top: 14px;
            margin-right: 8px;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .btn div.text {
            float: left;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .black-btn {
            display: inline-block;
            border-radius: 4px;
            height: 48px;
            padding-left: 24px;
            padding-right: 24px;
            margin-right: 12px;
            background-color: #000000;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 45px;
            letter-spacing: normal;
            text-align: center;
            color: #dde1e5;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .black-btn:hover {
            background-color: #777777;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .black-btn svg {
            float: left;
            width: 17px;
            height: 17px;
            margin-top: 14px;
            margin-right: 8px;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .black-btn div.text {
            float: left;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .item-contribute {
            background-color: #000000;
            color: #dde1e5;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .item-uncontribute {
            background-color: #efe733;
            color: #000000;
        }
        
        .ast-container .first-column {
            flex: 1 0 0;
            margin-right: 24px;
        }
        
        .ast-container .first-column h6.comments {
            display: block;
            width: 100%;
            margin-top: 32px;
            margin-bottom: 16px;
            color: #3b4045;
            font-size: 16px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.33;
            letter-spacing: normal;
        }
        
        .ast-container .first-column .add-comment {
            width: 100%;
            margin: 0 0 20px 0;
            padding: 15px 16px 16px;
            border-radius: 4px;
            border: solid 1px #dee2e6;
            background-color: #f8f9fa;
        }
        
        .ast-container .first-column .add-comment .caption {
            font-size: 14px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.43;
            letter-spacing: normal;
            color: #656d75;
        }
        
        .ast-container .first-column .add-comment .sub {
            font-size: 12px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.67;
            letter-spacing: normal;
            color: #abb4bd;
        }
        
        .ast-container .first-column .add-comment form {
            display: flex;
            flex-flow: row wrap;
            align-items: flex-start;
            padding-top: 8px;
            padding-bottom: 0;
            margin-bottom: 8px;
        }
        
        .ast-container .first-column .add-comment form textarea.new-comment {
            height: 40px;
            padding: 10px;
            border-radius: 4px;
            border: solid 1px #ced4d9;
            background-color: #fff;
            flex: 1 0 0;
        }
        
        .ast-container .first-column .add-comment form input.submit {
            height: 40px;
            border-radius: 4px;
            background-color: #000000;
            color: #ffffff;
            padding-left: 40px;
            padding-right: 40px;
            flex: 0 0 auto;
            
            font-size: 14px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            letter-spacing: normal;
            text-align: center;
            color: #ffffff;
            margin-left: 8px;
        }

        .ast-container .first-column .add-comment form input.submit:hover {
            background-color: #777777;
        }

        .ast-container .first-column .comments .comment {
            display: flex;
            flex-flow: row wrap;
            align-items: flex-start;
            padding-bottom: 20px;
        }
        
        .ast-container .first-column .comments .comment .avatar {
            height: 56px;
            border-radius: 28px;
            border: solid 1px #dde1e5;
            background-color: #f9f9fa;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            
            flex: 0 0 56px;
        }
        
        .ast-container .first-column .comments .comment .container {
            flex: 1 0 0;
            padding-left: 16px;
            display: flex;
            flex-flow: row wrap;
        }
        
        
        .ast-container .first-column .comments .comment .container .author {
            flex: 1 0 0;
            font-size: 14px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.43;
            letter-spacing: normal;
            color: #656d75;
        }
        
        .ast-container .first-column .comments .comment .container .date {
            flex: 0 0 300px;
            
            font-size: 12px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.5;
            letter-spacing: normal;
            text-align: right;
            color: #abb4bd;
        }

        .ast-container .first-column .comments .comment .container .txt {
            flex: 1 0 100%;
            font-size: 14px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.43;
            letter-spacing: normal;
            color: #808a95;
            margin-top: 4px;
        }
        
        .ast-container .first-column .comments .comment .container .urls {
            flex: 1 0 100%;
            margin-top: 8px;
        }
        
        .ast-container .first-column .comments .comment .container .urls a {
            font-size: 14px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: normal;
            color: #1176b2;
            padding-right: 16px;
            text-decoration: underline;
        }
        
        .ast-container .first-column .separator {
            width: 100%;
            height: 1px;
            background-color: #dde1e5;
            margin-bottom: 24px;
        }
        
        .ast-container .first-column .content {
            padding-top: 24px;
        }
        
        .ast-container .first-column .content h2 {
            padding-left: 20px;
            padding-bottom: 24px;
            font-family: Recoleta;
            font-size: 28px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.14;
            letter-spacing: normal;
            color: #3b4045;
        }
        
        .ast-container .first-column .content h6 {
            display: block;
            width: 100%;
            color: #3b4045;
            padding-left: 20px;
            font-size: 18px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.33;
            letter-spacing: normal;
            padding-bottom: 12px;
        }

        .ast-container .first-column .content p {
            font-size: 16px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            letter-spacing: normal;
            margin-bottom: 0;
            display: block;
            width: 100%;
            line-height: 24px;
            color: #3b4045;
            padding-left: 20px;
            padding-bottom: 24px;
        }
        
        .ast-container .first-column .content .tags {
            display: block;
            width: 100%;
            padding-left: 16px;
            padding-bottom: 12px;
        }
        
        .ast-container .first-column .content .tags a {
            display: inline-block;
            line-height: 32px;
            padding-left: 12px;
            padding-right: 12px;
            margin-right: 8px;
            margin-bottom: 12px;
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
        
        .ast-container .first-column .content .attachments {
            width: 100%;
            padding-left: 20px;
            margin-bottom: 12px;
        }
        
        .ast-container .first-column .content .attachments a {
            display: inline-block;
            margin: 0 16px 12px 0;
            font-size: 14px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: normal;
            color: #1176b2;
            text-decoration: underline;
        }
        
        .ast-container .first-column .content .related-tasks {
            display: flex;
            width: 100%;
            flex-flow: row wrap;
            padding-left: 12px;
            padding-right: 12px;
            padding-top: 12px;
        }
        
        .ast-container .first-column .content .related-tasks .related-task {
            flex: 0 0 257px;
            margin-left: 8px;
            margin-right: 8px;
            height: 152px;
            margin-bottom: 24px;
            padding: 16px;
            background-color: #ffffff;
        }
        
        .ast-container .first-column .content .related-tasks .related-task:hover {
            background-color: #f9f9fa;
            cursor: pointer;
        }
        
        .ast-container .first-column .content .related-tasks .related-task .title {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 16px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.5;
            letter-spacing: normal;
            color: #3b4045;
        }

        .ast-container .first-column .content .related-tasks .related-task .tags-info {
            display: block;
            width: 100%;
            padding-top: 16px;
        }
        
        .ast-container .first-column .content .related-tasks .related-task .tags-info div {
            display: inline-block;
            line-height: 32px;
            padding-left: 12px;
            padding-right: 12px;
            font-size: 12px;
            text-align: center;
            border-radius: 16px;
            background-color: #eceef0;
            color: #808a95;
        }

        .ast-container .first-column .content .related-tasks .related-task .days-left {
            font-size: 12px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.33;
            letter-spacing: normal;
            color: #808a95;
            margin-top: 8px;
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
        
        .ast-container .second-column .details {
            
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
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
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
        
        .ast-container .second-column .details .rows div.space {
            flex: 1 0 50%;
            height: 20px;
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
        
        .ast-container .second-column .details .rows2 svg {
            width: 12px;
            height: 12px;
            stroke: #3b4045;
            margin-top: 3px;
            margin-right: 9px;
        }
        
        .ast-container .second-column .details .rows2 div.value {
            text-align: right;
            color: #3b4045;
        }
        
        .ast-container .second-column .links {
            margin-top: 24px;
            padding-top: 20px;
            padding-bottom: 20px;
            background-color: #f9f9fa;
        }
        
        .ast-container .second-column .links .url-list {
            font-size: 14px;
        }
        
        .ast-container .second-column .links .url-list a {
            display: block;
            padding-left: 20px;
            width: 100%;
            font-size: 14px;
            color: #2570ae;
            text-decoration: underline;
        }
    </style>

    <div class="bread-crumb">
        <a href="<?= home_url() ?>" class="homepage"><i data-feather="home"></i></a>
        <i data-feather="chevron-right"></i>
        <a href="<?= home_url() ?>/<?= $topic_post->post_type ?>/" class="txt"><?= __('Topics', 'joinus4health') ?></a>
    </div>
    <div class="top-column-2-colspan column-common-border-style">
        <?php 
        $m_votes = get_post_meta($topic_post->ID, "m_votes");
        $vote_class = (is_array($m_votes) && in_array(get_current_user_id(), $m_votes)) ? 'item-downvote' : 'item-upvote';
        $m_votes_count = count($m_votes);
        $m_imageurl = get_post_meta($topic_post->ID, 'm_topimage', true);
        $m_report_url = get_post_meta($topic_post->ID, 'm_report_url', true);
        ?>
        <?php if ($m_imageurl != null) { $m_imageurl = json_decode($m_imageurl); } else { $m_imageurl = null; } ?>
        <?php if ($m_imageurl != null) { $m_imageurl = ' style="background-image: url('.home_url().'/wp-content/'.$m_imageurl->file.');"'; } ?>
        <div class="image"<?= $m_imageurl ?>></div>
        <div class="title-and-buttons">
            <div class="voting <?= $vote_class ?>" data-id="<?= $topic_post->ID ?>" data-url="<?= get_the_permalink($topic_post->ID) ?>" id="item-vote-<?= $topic_post->ID ?>">
                <div class="counter" id="item-votes-<?= $topic_post->ID ?>"><?= count($m_votes) ?></div>
                <i data-feather="thumbs-up"></i>
            </div>
            <div class="title"></div>
            <?php if ($m_report_url != null && get_preferred_language() == 'pl'): ?>
            <a href='<?= $m_report_url ?>' class="btn"><?= __('Pobierz raport teraz!', 'joinus4health') ?></a>
            <?php endif; ?>
            <a href='#share' class="btn" rel="modal:open"><?= __('Share', 'joinus4health') ?></a>
            <?php $m_follows = get_post_meta($topic_post->ID, "m_follows"); ?>
            <?php $is_following = (is_array($m_follows) && in_array(get_current_user_id(), $m_follows)) ?>
            <div class="btn <?= $is_following ? 'item-unfollow' : 'item-follow' ?>" data-id="<?= $topic_post->ID ?>" id="item-follow-<?= $topic_post->ID ?>">
                <i data-feather="<?= $is_following ? 'check' : 'eye' ?>"></i>
                <div class="text"><?= $is_following ? __('Following', 'joinus4health') : __("Follow", 'joinus4health') ?></div>
            </div>
            <?php $m_contributes = get_post_meta($topic_post->ID, "m_contributes"); ?>
            <?php $is_contributing = (is_array($m_contributes) && in_array(get_current_user_id(), $m_contributes)) ?>
            <div class="black-btn <?= $is_contributing ? 'item-uncontribute' : 'item-contribute' ?>" data-id="<?= $topic_post->ID ?>" id="item-contribute-<?= $topic_post->ID ?>">
                <i data-feather="<?= $is_contributing ? 'check' : 'user-plus' ?>"></i>
                <div class="text"><?= $is_contributing ? __('Contributing', 'joinus4health') : __("Contribute", 'joinus4health') ?></div>
            </div>
        </div>
    </div>
    <div class="first-column">
        <div class="content column-common-border-style">
            <h2><?= get_translated_title($topic_post, 'm_title', $preferred_language) ?></h2>
            <h6><?= __('Topic details', 'joinus4health') ?></h6>
            <?php
            echo '<p>'.get_translated_field_paragraph($topic_post, 'm_description', $preferred_language).'</p>';
            ?>
            <?php $tags = wp_get_post_terms($topic_post->ID, 'ju4htopictag') ?>
            <?php if (count($tags)): ?>
            <div class="tags">
                <?php foreach ($tags as $tag): ?>
                <a href="<?= get_home_url() ?>/<?= $topic_post->post_type ?>/?topictag=<?= $tag->term_id ?>"><?= $tag->name ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <?php $attachments = get_post_meta($topic_post->ID, 'm_attachments') ?>
            <?php if (count($attachments) > 0): ?>
            <div class="separator"></div>
            <h6><?= __('Attachments', 'joinus4health') ?></h6>
            <div class="attachments">
                <?php foreach ($attachments as $attachment): ?>
                <?php $attachment_obj = json_decode($attachment) ?>
                <a href="<?= home_url() ?>/wp-content/<?= $attachment_obj->file ?>" target="_blank"><?= $attachment_obj->text ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <?php $m_tasks = get_post_meta($topic_post->ID, 'm_related_tasks') ?>
            <?php if (!empty($m_tasks)): ?>
            <div class="separator"></div>
            <h6><?= __('Related tasks', 'joinus4health') ?></h6>
            <div class="related-tasks">
                <?php
                $query_params = array('post_type' => 'ju4htask', 'posts_per_page' => -1, 'post__in' => $m_tasks);
                $query_related_tasks = new WP_Query($query_params);
                ?>
                <?php while ($query_related_tasks->have_posts()): ?>
                <?php
                $query_related_tasks->the_post(); 
                $m_valid_thru = get_post_meta($post->ID, 'm_valid_thru', true);
                $m_valid_thru = is_numeric($m_valid_thru) ? $m_valid_thru : null;
                ?>
                <div class="related-task column-common-border-style" onclick="load_href('<?= get_the_permalink($post->ID) ?>');">
                    <a class="title" href="<?= get_the_permalink($post->ID) ?>"><?= $post->post_title ?></a>
                    <?php if ($m_valid_thru != null): ?><div class="days-left"><?= __('Valid thru', 'joinus4health').': '.wp_date('d F Y', $m_valid_thru) ?></div><?php endif; ?>
                    <div class="tags-info">
                        <?php $m_duration = get_post_meta($post->ID, 'm_duration', true) ?>
                        <?php if (is_numeric($m_duration) && array_key_exists($m_duration, $meta_task_duration)): ?>
                        <div><?= $meta_task_duration[$m_duration] ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php if (comments_open($topic_post->ID)): ?>
        <?php
        $comment_args = array(
            'status'                     => 'approve',
            'post_id'                    => $topic_post->ID,
            'update_comment_meta_cache'  => false,
            'hierarchical'               => 'threaded',
            'order'                      => 'ASC'
        );

        if (is_user_logged_in()) {
            $comment_args['include_unapproved'] = array(get_current_user_id());
        }

        $comment_query = new WP_Comment_Query($comment_args);
        $comments = $comment_query->get_comments();
        $count_comments = count_comments($comments);
        ?>
        <a id="reply-comment"></a>
        <h6 class="comments"><?= __('Comments', 'joinus4health') ?> (<?= $count_comments ?>)</h6>
        <?php if (is_user_logged_in()): ?>
        <div class="add-comment">
            <div class="caption"><?= __('Add comment', 'joinus4health') ?></div>
            <form action="<?= home_url() ?>/wp-comments-post.php" method="post">
                <textarea class="new-comment" name="comment"></textarea>
                <input type="button" value="<?= __('Submit', 'joinus4health') ?>" class="submit" name="submit" />
                <input type="hidden" name="comment_post_ID" value="<?= $topic_post->ID ?>" id="comment_post_ID">
                <input type="hidden" name="comment_parent" id="comment_parent" value="0">
            </form>
            <form id="upload">
                <input type="file" id="file" name="file" accept=".jpg, .png, .gif, .pjpeg, .pdf" />Max <?= ini_get('upload_max_filesize') ?>B
            </form>
            <div class="sub">
                <?= __('Comments and replies are moderated. Your comment will appear here once the site administrator accepts it.', 'joinus4health') ?><br>
                <?= __('By uploading a file or image, you confirm that it neither violates applicable laws nor infringes the rights of third parties.', 'joinus4health') ?><br>
                <?= __('For detailed information, take a look at our', 'joinus4health') ?> <a href="<?= home_url() ?>/terms-of-use/"><?= __('Terms of use', 'joinus4health') ?></a>.
            </div>
        </div>
        <?php endif; ?>
        <div class="comments">
            <?php
            foreach ($comments as $comment) {
                html_comment($comment, 0);
                
                foreach ($comment->get_children() as $comment_) {
                    html_comment($comment_, 72);
                    
                    foreach ($comment_->get_children() as $comment__) {
                        html_comment($comment__, 144, false);
                    }
                }
            }
            ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="second-column">
        <div class="details column-common-border-style">
            <div class="author">
                <div class="avatar" style="background-image: url(<?= bp_core_fetch_avatar(array('item_id' => $topic_post->post_author, 'html' => false, 'width' => 40, 'height' => 40)) ?>);"></div>
                <div class="lines">
                    <div class="name"><?php the_author() ?></div>
                    <div class="sub"><?= __('facilitator', 'joinus4health') ?></div>
                </div>
            </div>
            <div class="separator"></div>
            <div class="tags-info">
                <?php $m_status = get_post_meta($topic_post->ID, 'm_status', true) ?>
                <?= isset($meta_topic_status[$m_status]) ? '<div>'.$meta_topic_status[$m_status].'</div>' : "" ?>
            </div>
            <div class="rows">
                <?php $m_follows = get_post_meta($topic_post->ID, 'm_follows') ?>
                <?php $m_contributes = get_post_meta($topic_post->ID, 'm_contributes') ?>
                <?php $m_valid_thru = get_post_meta($topic_post->ID, 'm_valid_thru', true) ?>
                <div><?= __('Created', 'joinus4health') ?></div>
                <div><?= __('Valid thru', 'joinus4health') ?></div>
                <div class="value"><?= time_ago($topic_post) ?></div>
                <div class="value"><?= is_numeric($m_valid_thru) ? wp_date('d F Y', $m_valid_thru) : '-' ?></div>
                <div class="space"></div>
                <div class="space"></div>
                <div><?= __('Following', 'joinus4health') ?></div>
                <div><?= __('Contributing', 'joinus4health') ?></div>
                <div class="value" id="item-follows-<?= $topic_post->ID ?>"><?= count($m_follows) ?></div>
                <div class="value" id="item-contributes-<?= $topic_post->ID ?>"><?= count($m_contributes) ?></div>
            </div>
            <?php $m_language = get_post_meta($topic_post->ID, 'm_language', true) ?>
            <?php $m_target_group = get_post_meta($topic_post->ID, 'm_target_group', true) ?>
            <?php $m_source = get_post_meta($topic_post->ID, 'm_source', true) ?>
            <div class="separator"></div>
            <div class="rows2">
                <i data-feather="flag"></i>
                <div><?= __('Language', 'joinus4health') ?></div>
                <div class="value"><?= $m_language != '' && isset($meta_languages[$m_language]) ? $meta_languages[$m_language] : __('not specified', 'joinus4health') ?></div>
                <i data-feather="users"></i>
                <div><?= __('Stakeholder group', 'joinus4health') ?></div>
                <div class="value"><?= $m_target_group != '' && isset($meta_stakeholder_group[$m_target_group]) ? $meta_stakeholder_group[$m_target_group] : __('not specified', 'joinus4health') ?></div>
                <i data-feather="disc"></i>
                <div><?= __('Source', 'joinus4health') ?></div>
                <div class="value"><?= $m_source != '' && isset($meta_topic_source[$m_source]) ? $meta_topic_source[$m_source] : __('not specified', 'joinus4health') ?></div>
            </div>
        </div>
        <?php
        $m_externals = get_post_meta($topic_post->ID, 'm_externals');
        $m_suggestions = get_post_meta($topic_post->ID, 'm_related_suggestions');
        $m_related_groups = get_post_meta($topic_post->ID, 'm_related_groups');
        ?>
        <?php if (!empty($m_externals) || !empty($m_suggestions) || !empty($m_related_groups)): ?>
        <div class="links column-common-border-style">
            <?php if (!empty($m_related_groups)): ?>
            <?php
            $query_params = array('post_type' => 'forum', 'posts_per_page' => -1, 'post__in' => $m_related_groups);
            $query_bbpress_topics = new WP_Query($query_params);
            ?>
            <h6><?= __('Assigned working group', 'joinus4health') ?></h6>
            <div class="url-list">
                <?php while ($query_bbpress_topics->have_posts()): ?>
                <?php $query_bbpress_topics->the_post(); ?>
                <a href="<?= get_the_permalink($post->ID) ?>"><?= get_the_title($post->ID) ?></a>
                <?php endwhile; ?>
            </div>
            <div class="separator"></div>
            <?php endif; ?>
            <?php if (!empty($m_externals)): ?>
            <h6><?= __('External links', 'joinus4health') ?></h6>
            <div class="url-list">
                <?php foreach ($m_externals as $external): ?>
                <?php $external_obj = json_decode($external) ?>
                <a href="<?= $external_obj->url ?>"><?= $external_obj->text ?></a>
                <?php endforeach; ?>
            </div>
            <div class="separator"></div>
            <?php endif; ?>
            <?php if (!empty($m_suggestions)): ?>
            <?php
            $query_params = array('post_type' => 'ju4hsuggestion', 'posts_per_page' => -1, 'post__in' => $m_suggestions);
            $query_related_suggestions = new WP_Query($query_params);
            ?>
            <h6><?= __('Original suggestions', 'joinus4health') ?></h6>
            <div class="url-list">
                <?php while ($query_related_suggestions->have_posts()): ?>
                <?php $query_related_suggestions->the_post(); ?>
                <a href="<?= get_the_permalink($post->ID) ?>"><?= $post->post_title ?></a>
                <?php endwhile; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
<?php get_footer();