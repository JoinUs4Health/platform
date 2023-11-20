<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

the_post();
$task = $post;
$meta = get_post_meta(get_the_ID());
get_header();
echo get_js_script_voting(get_the_permalink());
echo get_js_script_contribute(get_the_permalink());
echo get_js_script_follow(get_the_permalink());
echo get_js_load_href();
html_modal_uncontribute();
html_modal_contribute();
$preferred_language = get_preferred_language();
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
            flex: 0 0 100%;
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
        
        .ast-container .first-column {
            flex: 1 0 0;
            margin-right: 24px;
        }
        
        .ast-container .first-column .separator {
            width: 100%;
            height: 1px;
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
            margin-bottom: 28px;
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
            margin-bottom: 12px;
        }

        .ast-container .first-column .content p {
            font-size: 16px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            letter-spacing: normal;
            margin-bottom: 24px;
            display: block;
            width: 100%;
            line-height: 24px;
            color: #3b4045;
            padding-left: 20px;
            padding-right: 20px;
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
            margin: 0 0 20px;
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
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
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
        
        .ast-container .second-column .estimate .black-btn {
            cursor: pointer;
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
            text-align: center;
        }
        
        .ast-container .second-column .estimate .black-btn:hover {
            background-color: #777777;
        }
        
        .ast-container .second-column .estimate .black-btn .content {
            display: inline-block;
            margin: 12px auto 0 auto;
        }
        
        .ast-container .second-column .estimate .black-btn .content svg {
            float: left;
            width: 17px;
            height: 17px;
            margin-top: 3px;
            margin-right: 8px;
        }
        
        .ast-container .second-column .estimate .black-btn .content div.text {
            float: left;
        }
        
        
        .ast-container .second-column .estimate .item-contribute {
            background-color: #000000;
            color: #dde1e5;
        }
        
        .ast-container .second-column .estimate .item-uncontribute {
            background-color: #efe733;
            color: #000000;
        }
        
    </style>
    <div class="bread-crumb">
        <a href="<?= home_url() ?>" class="homepage"><i data-feather="home"></i></a>
        <i data-feather="chevron-right"></i>
        <a href="<?= home_url() ?>/<?= $task->post_type ?>/" class="txt"><?= __('Tasks', 'joinus4health') ?></a>
    </div>
    <div class="first-column">
        <div class="content column-common-border-style">
            <h2><?= get_translated_title($task, 'm_title', $preferred_language) ?></h2>
            <div class="separator"></div>
            <h6><?= __('Task details', 'joinus4health') ?></h6>
            <?= '<p>'.get_translated_field_paragraph($task, 'm_description', $preferred_language).'</p>' ?>
            <?php $attachments = get_post_meta($task->ID, 'm_attachments') ?>
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
            <?php $m_related_topic = get_post_meta($task->ID, 'm_related_topic', true) ?>
            <?php if (is_numeric($m_related_topic)): ?>
            <?php
            $query_params = array('post_type' => 'ju4htopic', 'posts_per_page' => 1, 'post__in' => array($m_related_topic));
            $query_related_tasks = new WP_Query($query_params);
            ?>
            <?php while ($query_related_tasks->have_posts()): ?>
            <?php $query_related_tasks->the_post(); ?>
            <?php $m_status = get_post_meta($post->ID, 'm_status', true); ?>
            <div class="separator"></div>
            <h6><?= __('Related topic', 'joinus4health') ?></h6>
            <div class="related-topic column-common-border-style" onclick="load_href('<?= get_the_permalink($post->ID) ?>');">
                <div class="two-line-content">
                    <a href="<?= get_the_permalink($post) ?>" class="title"><?= get_translated_title($post, 'm_title', $preferred_language) ?></a>
                    <div class="days-left"><?= time_ago($post) ?></div>
                    <div class="submit-by"><?php the_author() ?></div>
                </div>
                <?= isset($meta_topic_status[$m_status]) ? '<div class="tag">'.$meta_topic_status[$m_status].'</div>' : "" ?>
            </div>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>
        <?php if (comments_open($task->ID)): ?>
        <?php
        $comment_args = array(
            'status'                     => 'approve',
            'post_id'                    => $task->ID,
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
                <input type="hidden" name="comment_post_ID" value="<?= $task->ID ?>" id="comment_post_ID">
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
                <div class="avatar" style="background-image: url(<?= bp_core_fetch_avatar(array('item_id' => $task->post_author, 'html' => false, 'width' => 40, 'height' => 40)) ?>);"></div>
                <div class="lines">
                    <div class="name"><?php the_author() ?></div>
                    <div class="sub"><?= __('facilitator', 'joinus4health') ?></div>
                </div>
            </div>
            <div class="separator"></div>
            <div class="tags-info">
            </div>
            <div class="rows">
                <?php $m_valid_thru = get_post_meta($task->ID, 'm_valid_thru', true) ?>
                <div><?= __('Created', 'joinus4health') ?></div>
                <div><?= __('Valid thru', 'joinus4health') ?></div>
                <div class="value"><?= time_ago($task) ?></div>
                <div class="value"><?= is_numeric($m_valid_thru) ? wp_date('d F Y', $m_valid_thru) : '-' ?></div>
            </div>
            <?php $m_language = get_post_meta($task->ID, 'm_language', true) ?>
            <?php $m_target_group = get_post_meta($task->ID, 'm_target_group', true) ?>
            <?php $m_source = get_post_meta($task->ID, 'm_source', true) ?>
            <?php $m_level = get_post_meta($task->ID, 'm_level', true); ?>
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
                <div class="value"><?= $m_source != '' && isset($meta_task_source[$m_source]) ? $meta_task_source[$m_source] : __('not specified', 'joinus4health') ?></div>
                <i data-feather="layers"></i>
                <div><?= __('Level', 'joinus4health') ?></div>
                <div class="value"><?= $m_level != '' && isset($meta_task_level[$m_level]) ? $meta_task_level[$m_level] : __('not specified', 'joinus4health') ?></div>
            </div>
        </div>
        <?php $m_duration = get_post_meta($task->ID, 'm_duration', true) ?>
        <?php if (is_numeric($m_duration) && array_key_exists($m_duration, $meta_task_duration)): ?>
        <div class="estimate column-common-border-style">
            <h6><?= __('Time estimate', 'joinus4health') ?></h6>
            <div class="time"><?= $meta_task_duration[$m_duration] ?></div>
            <?php $m_contributes = get_post_meta($task->ID, "m_contributes"); ?>
            <?php $is_contributing = (is_array($m_contributes) && in_array(get_current_user_id(), $m_contributes)) ?>
            <div class="black-btn <?= $is_contributing ? 'item-uncontribute' : 'item-contribute' ?>" data-id="<?= $task->ID ?>" id="item-contribute-<?= $task->ID ?>">
                <div class="content">
                    <i data-feather="<?= $is_contributing ? 'check' : 'user-plus' ?>"></i>
                    <div class="text"><?= $is_contributing ? __('Contributing', 'joinus4health') : __("Contribute", 'joinus4health') ?></div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
<?php get_footer();