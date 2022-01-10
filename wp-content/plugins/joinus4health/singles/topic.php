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

        .ast-container .top-column-2-colspan .title-and-buttons .voting span {
            width: 18px;
            height: 18px;
            mask: url(<?= home_url() ?>/wp-content/plugins/joinus4health/assets/svg/thumbs-up.svg);
            mask-size: 18px;
            background-color: #3b4045;
            margin-top: 13px;
            margin-right: 10px;
            margin-left: 10px;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .voting span:hover {
            background-color: #000000;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .title {
            margin-left: 16px;
            flex: 1 0 0;
            font-size: 28px;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .btn {
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
        
        .ast-container .top-column-2-colspan .title-and-buttons .black-btn {
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
        
        .ast-container .first-column {
            flex: 1 0 0;
            margin-right: 24px;
        }
        
        .ast-container .first-column h6.comments {
            display: block;
            width: 100%;
            margin-top: 32px;
            line-height: 24px;
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
            margin: 16px 0 20px;
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
        
        .ast-container .first-column .add-comment form input.new-comment {
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
        
        .ast-container .first-column .comments {
            
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
            background-image: url(<?= home_url() ?>/d28c65af4044b1d2bc8ff5f058d7.webp);
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
            margin-top: 24px;
            margin-bottom: 24px;
            background-color: #dde1e5;
        }
        
        .ast-container .first-column .content {
            padding-top: 24px;
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
        
        .ast-container .first-column .content .attachments {
            width: 100%;
            padding-left: 20px;
            padding-top: 4px;
        }
        
        .ast-container .first-column .content .attachments a {
            display: inline-block;
            margin: 0 16px 0 0;
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
        <a href="<?= home_url() ?>" class="homepage"></a>
        <span></span>
        <a href="<?= home_url() ?>/ju4htopics/" class="txt">Topics</a>
    </div>
    <div class="top-column-2-colspan column-common-border-style">
        <?php $m_votes = get_post_meta($post->ID, "m_votes"); ?>
        <?php $vote_class = (is_array($m_votes) && in_array(get_current_user_id(), $m_votes)) ? 'item-downvote' : 'item-upvote' ?>
        <?php $m_votes_count = count($m_votes) ?>
        <?php $m_imageurl = get_post_meta(get_the_ID(), 'm_topimage', true) ?>
        <?php if ($m_imageurl != null) { $m_imageurl = json_decode($m_imageurl); } else { $m_imageurl = null; } ?>
        <?php if ($m_imageurl != null) { $m_imageurl = ' style="background-image: url('.home_url().'/wp-content/'.$m_imageurl->file.');"'; } ?>
        <div class="image"<?= $m_imageurl ?>></div>
        <div class="title-and-buttons">
            <div class="voting <?= $vote_class ?>" id="item-vote-<?= $post->ID ?>">
                <div class="counter" id="item-votes-<?= $post->ID ?>"><?= count($m_votes) ?></div>
                <span></span>
            </div>
            <div class="title"><?php the_title() ?></div>
            <a href="#" class="btn">Share</a>
            <?php $m_follows = get_post_meta($post->ID, "m_follows"); ?>
            <?php $follow_class = (is_array($m_follows) && in_array(get_current_user_id(), $m_follows)) ? 'item-unfollow' : 'item-follow' ?>
            <div class="btn <?= $follow_class ?>" id="item-follow-<?= $post->ID ?>">Follow</div>
            <div class="black-btn">Contribute</div>
        </div>
    </div>
    <div class="first-column">
        <div class="content column-common-border-style">
            <h6>Topic details</h6>
            <p><?= get_post_meta(get_the_ID(), 'm_description', true) ?></p>
            <?php $tags = wp_get_post_terms(get_the_ID(), 'ju4htopictag') ?>
            <?php if (count($tags)): ?>
            <div class="tags">
                <?php foreach ($tags as $tag): ?>
                <a href="<?= get_home_url() ?>/ju4htopics/?topictag=<?= $tag->term_id ?>"><?= $tag->name ?></a>
                <?php endforeach; ?>
            </div>
            <div class="separator"></div>
            <?php endif; ?>
            <?php $attachments = get_post_meta(get_the_ID(), 'm_attachments') ?>
            <?php if (count($attachments) > 0): ?>
            <h6>Attachments</h6>
            <div class="attachments">
                <?php foreach ($attachments as $attachment): ?>
                <?php $attachment_obj = json_decode($attachment) ?>
                <a href="<?= home_url() ?>/wp-content/<?= $attachment_obj->file ?>" target="_blank"><?= $attachment_obj->text ?></a>
                <?php endforeach; ?>
            </div>
            <div class="separator"></div>
            <?php endif; ?>
            <h6>Related tasks (todo)</h6>
            <div class="related-tasks">
                <div class="related-task column-common-border-style">
                    <div class="title">Link between fertilisers and agricultural pesticides to fertilisers</div>
                    <div class="days-left">2 days left</div>
                    <div class="tags-info">
                        <div>review</div>
                        <div>3 hours</div>
                    </div>
                </div>
                <div class="related-task column-common-border-style">
                    <div class="title">Link between fertilisers and agricultural pesticides to fertilisers</div>
                    <div class="days-left">2 days left</div>
                    <div class="tags-info">
                        <div>review</div>
                        <div>3 hours</div>
                    </div>
                </div>
                <div class="related-task column-common-border-style">
                    <div class="title">Link between fertilisers and agricultural pesticides to fertilisers</div>
                    <div class="days-left">2 days left</div>
                    <div class="tags-info">
                        <div>review</div>
                        <div>3 hours</div>
                    </div>
                </div>
                
                <div class="related-task column-common-border-style">
                    <div class="title">Link between fertilisers and agricultural pesticides to fertilisers</div>
                    <div class="days-left">2 days left</div>
                    <div class="tags-info">
                        <div>review</div>
                        <div>3 hours</div>
                    </div>
                </div>
                <div class="related-task column-common-border-style">
                    <div class="title">Link between fertilisers and agricultural pesticides to fertilisers</div>
                    <div class="days-left">2 days left</div>
                    <div class="tags-info">
                        <div>review</div>
                        <div>3 hours</div>
                    </div>
                </div>
                <div class="related-task column-common-border-style">
                    <div class="title">Link between fertilisers and agricultural pesticides to fertilisers</div>
                    <div class="days-left">2 days left</div>
                    <div class="tags-info">
                        <div>review</div>
                        <div>3 hours</div>
                    </div>
                </div>

                <div class="related-task column-common-border-style">
                    <div class="title">Link between fertilisers and agricultural pesticides to fertilisers</div>
                    <div class="days-left">2 days left</div>
                    <div class="tags-info">
                        <div>review</div>
                        <div>3 hours</div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (comments_open(get_the_ID())): ?>
        <?php
        $comment_args = array(
            'status'                     => 'approve',
            'post_id'                    => $post->ID,
            'update_comment_meta_cache'  => false,
            'hierarchical'               => 'threaded',
        );

        if (is_user_logged_in()) {
            $comment_args['include_unapproved'] = array(get_current_user_id());
        }

        $comment_query = new WP_Comment_Query($comment_args);
        $comments = &$comment_query->get_comments();
        $count_comments = count_comments($comments);
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.comment > .container > .urls > a').click(function() {
                    comment_reply_id = $(this).attr('id').split('-')[2];
                    $('#comment_parent').val(comment_reply_id);
                    comment_reply_to = $(this).parent().parent().find('.author').html();
                    $('.add-comment .caption').html("<?= _('Reply to') ?> " + comment_reply_to + " <?= _('comment') ?>");
                });
            });
        </script>
        <a id="reply-comment"></a>
        <h6 class="comments"><?= _('Comments') ?> (<?= $count_comments ?>)</h6>
        <div class="add-comment">
            <div class="caption"><?= _('Add comment') ?></div>
            <form action="<?= home_url() ?>/wp-comments-post.php" method="post">
                <input type="text" class="new-comment" name="comment" />
                <input type="submit" value="<?= _('Submit') ?>" class="submit" name="submit" />
                <input type="hidden" name="comment_post_ID" value="<?= get_the_ID() ?>" id="comment_post_ID">
                <input type="hidden" name="comment_parent" id="comment_parent" value="0">
            </form>
            <div class="sub"><?= _('Comments and replies are moderated. Your comment will appear here once the site administrator accepts it.') ?></div>
        </div>
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
                <?php $m_follows = get_post_meta($post->ID, 'm_follows') ?>
                <?php $m_contributes = get_post_meta($post->ID, 'm_contributes') ?>
                <div>Created</div>
                <div>Valid thru</div>
                <div class="value"><?= time_ago($post) ?></div>
                <div class="value">31 dec 2021 (todo)</div>
                <div class="space"></div>
                <div class="space"></div>
                <div>Following</div>
                <div>Contributing</div>
                <div class="value" id="item-follows-<?= $post->ID ?>"><?= count($m_follows) ?></div>
                <div class="value"><?= count($m_contributes) ?></div>
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
            </div>
            <?php endif; ?>
        </div>
        <div class="links column-common-border-style">
            <h6>Assigned working group (todo)</h6>
            <div class="url-list">
                <a href="#">Working team (one link)</a>
            </div>
            <div class="separator"></div>
            <h6>Outcomes (todo/questions)</h6>
            <div class="url-list">
                <a href="#">Not ready yet #1</a>
                <a href="#">Not ready yet #2</a>
                <a href="#">Not ready yet #3</a>
            </div>
            <div class="separator"></div>
            <h6>Original suggestions (todo)</h6>
            <div class="url-list">
                <a href="#">File cancer</a>
                <a href="#">File turbo</a>
                <a href="#">File engine</a>
                <a href="#">File bridge</a>
                <a href="#">File antenna</a>
                <a href="#">File cryptography</a>
                <a href="#">File cancer</a>
                <a href="#">File turbo</a>
                <a href="#">File engine</a>
                <a href="#">File bridge</a>
                <a href="#">File antenna</a>
                <a href="#">File cryptography</a>
            </div>
        </div>
    </div>
<?php get_footer(); ?>