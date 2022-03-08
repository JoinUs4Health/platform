<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$preferred_language = get_preferred_language();

get_header();
echo get_js_script_voting();
echo get_js_load_href();

?>

    <script type="text/javascript" src="<?= home_url() ?>/wp-content/plugins/joinus4health/assets/js/moment.min.js"></script>
    <link rel="stylesheet" href="<?= home_url() ?>/wp-content/plugins/joinus4health/assets/css/flatpickr.min.css">
    <script src="<?= home_url() ?>/wp-content/plugins/joinus4health/assets/js/flatpickr.min.js"></script>
    <style>
        .ast-container .voting {
            width: 88px;
            height: 44px;
            border-radius: 4px;
            display: flex;
            cursor: pointer;
        }

        .ast-container .item-upvote {
            border: solid 1px #dde1e5;
            background-color: #f9f9fa;
        }

        .ast-container .item-downvote {
            border: solid 1px #efe733;
            background-color: #efe733;
        }
        
        .ast-container .voting .counter {
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

        .ast-container .voting svg {
            width: 18px;
            height: 18px;
            stroke: #3b4045;
            margin-top: 11px;
            margin-right: 10px;
            margin-left: 10px;
        }
        
        .ast-container .voting span:hover {
            background-color: #000000;
        }
        
        .ast-desktop .ast-primary-header-bar.main-header-bar {
            margin-bottom: 0 !important;
        }
        
        .ast-container {
            align-items: flex-start;
            flex-flow: row wrap;
            margin-bottom: 40px;
            max-width: none !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        
        .site-primary-header-wrap {
            max-width: 1270px !important;
            margin-bottom: 0 !important;
        }
        
        .ast-container .yellow-section {
            background-color: #efe733;
            flex: 1 0 100%;
            padding-bottom: 64px;
        }
        
        .ast-container .yellow-section .tri-column-container { 
            margin: 0 auto;
            width: 1270px;
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
        }
        
        .ast-container .yellow-section ::selection {
            background-color: #000000;
            color: #fff;
        }

        .ast-container .yellow-section ::-moz-selection {
            background-color: #000000;
            color: #fff;
        }
        
        .ast-container .yellow-section .tri-column-container div.header {
            flex: 0 0 100%;
            margin: 64px 0 56px 0;
            font-size: 36px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 0.9;
            letter-spacing: -0.4px;
            color: #3b4045;
        }
        
        .ast-container .yellow-section .tri-column-container .col1 {
            flex: 1 0 36.29%;
        }
        
        .ast-container .yellow-section .tri-column-container .col2 {
            flex: 1 0 34.25%;
        }
        
        .ast-container .yellow-section .tri-column-container .col3 {
            flex: 1 0 29.4%;
        }
        
        .ast-container .yellow-section .tri-column-container .col1 p {
            padding-right: 172px;
        }
        
        .ast-container .yellow-section .tri-column-container .col2 p {
            padding-right: 146px;
        }
        
        .ast-container .yellow-section .tri-column-container .col3 p {
            padding-right: 72px;
        }
        
        .ast-container .yellow-section .tri-column-container div h5 {
            font-family: 'Recoleta';
            font-size: 28px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.14;
            letter-spacing: normal;
            color: #3b4045;
        }
        
        .ast-container .yellow-section .tri-column-container div p {
            font-size: 16px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: normal;
            color: #000000;
            margin-top: 10px;
        }
        
        .ast-container .yellow-section .tri-column-container div a {
            font-size: 16px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: normal;
            color: #2570ae;
            text-decoration: underline;
        }
        
        .ast-container .yellow-section .tri-column-container div svg {
            stroke: #2570ae;
            width: 15px;
            height: 15px;
        }
        
        .ast-container .white-section {
            background-color: #ffffff;
            flex: 1 0 100%;
        }
        
        .ast-container .white-section .two-column-container {
            margin: 0 auto 20px auto;
            width: 1270px;
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
        }
        
        .ast-container .white-section .two-column-container .header {
            font-family: 'Recoleta';
            font-size: 28px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.14;
            letter-spacing: normal;
            color: #3b4045;
            flex: 0 0 100%;
            margin-top: 40px;
            margin-bottom: 24px;
        }
        
        .ast-container .white-section .two-column-container .first-col {
            flex: 0 0 852px;
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
        }
        
        .ast-container .white-section .two-column-container .first-col div.item-topic {
            width: 394px;
            height: 256px;
            margin: 0 24px 24px 0;
            border-radius: 4px;
            align-items: flex-start;
            flex-flow: column wrap;
            display: flex;
        }
        
        .ast-container .white-section .two-column-container .first-col div.item-topic div.layer0x0 {
            width: 0;
            height: 0;
        }
        
        .ast-container .white-section .two-column-container .first-col div.item-topic div.layer0x0 div.image {
            width: 394px;
            height: 256px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            border-radius: 4px;
        }
        
        .ast-container .white-section .two-column-container .first-col div.item-topic div.layer0x0 div.gradient {
            width: 394px;
            height: 256px;
            background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.79), rgba(0, 0, 0, 0.28) 75%);
            border-radius: 4px;
            cursor: pointer;
        }
        
        .ast-container .white-section .two-column-container .first-col div.item-topic a {
            flex: 0 0 auto;
            font-size: 24px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 1;
            letter-spacing: normal;
            color: #ffffff;
            margin: 24px 24px 0 24px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .ast-container .white-section .two-column-container .first-col div.item-topic div.tags {
            flex: 1 0 0;
            margin: 6px 24px 0 24px;
        }
        
        .ast-container .white-section .two-column-container .first-col div.item-topic div.tags a {
            float: left;
            height: 32px;
            line-height: 32px;
            border-radius: 16px;
            background-color: #181b1e;
            font-size: 12px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            letter-spacing: normal;
            color: #ffffff;
            padding: 0 12px;
            margin-right: 8px;
            margin-top: 6px;
            margin-left: 0;
            margin-bottom: 0;
        }
        
        .ast-container .white-section .two-column-container .first-col div.item-topic div.voting {
            flex: 0 0 auto;
            margin: 0 24px 24px 24px;
        }
        
        .ast-container .white-section .two-column-container .first-col div.item-suggestion {
            width: 812px;
            height: 60px;
            border-radius: 4px;
            border: solid 1px #dde1e5;
            background-color: #ffffff;
            margin-bottom: 12px;
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
        }
        
        .ast-container .white-section .two-column-container .first-col div.item-suggestion a {
            font-size: 18px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 60px;
            letter-spacing: normal;
            color: #3b4045;
            padding-left: 16px;
            flex: 1 0 0;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .ast-container .white-section .two-column-container .first-col div.item-suggestion  div.voting {
            width: 88px;
            height: 44px;
            border-radius: 4px;
            flex: 0 0 auto;
            margin-top: 7px;
            margin-right: 8px;
        }
        
        .ast-container .white-section .two-column-container .second-col {
            flex: 1 0 0;
        }
        
        .ast-container .white-section .two-column-container .second-col div.separator {
            width: 100%;
            height: 1px;
            background-color: #dde1e5;
        }
        
        .ast-container .white-section .two-column-container .second-col h6 {
            margin-top: 19px;
            width: 100%;
            font-size: 20px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.2;
            letter-spacing: normal;
            color: #656d75;
        }
        
        .ast-container .white-section .two-column-container .second-col p {
            margin: 16px 0;
            font-size: 16px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.5;
            letter-spacing: normal;
            color: #3b4045;
        }
        
        .ast-container .white-section .two-column-container .second-col a {
            display: inline-block;
            height: 48px;
            padding: 0 28px;
            border-radius: 4px;
            background-color: #000000;
            font-size: 16px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 48px;
            letter-spacing: normal;
            text-align: center;
            color: #ffffff;
        }
        
        .ast-container .grey-section {
            background-color: #f9f9fa;
            flex: 1 0 100%;
            padding-bottom: 64px;
        }
        
        .ast-container .grey-section .four-column-container {
            margin: 0 auto;
            width: 1270px;
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
            column-gap: 15px;
        }
        
        .ast-container .grey-section .four-column-container .separator {
            flex: 0 0 100%;
            height: 1px;
            background-color: #dde1e5;
            margin-top: 40px;
        }
        
        .ast-container .grey-section .four-column-container .header-with-button {
            margin-top: 40px;
            flex: 0 0 100%;
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
        }
        
        
        .ast-container .grey-section .four-column-container .header-with-button h5 {
            font-family: 'Recoleta';
            font-size: 28px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.14;
            letter-spacing: normal;
            color: #3b4045;
            flex: 1 0 0;
        }
        
        .ast-container .grey-section .four-column-container .header-with-button .button-black {
            height: 32px;
            padding: 0 16px;
            border-radius: 16px;
            background-color: #000000;
            font-size: 12px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            letter-spacing: normal;
            color: #ffffff;
            flex: 0 0 auto;
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
        }

        .ast-container .grey-section .four-column-container .header-with-button .button-black b {
            flex: 0 0 auto;
            margin-top: 4px;
        }
        
        .ast-container .grey-section .four-column-container .header-with-button .button-black svg {
            width: 14px;
            height: 14px;
            stroke: #ffffff;
            flex: 0 0 auto;
            margin-top: 9px;
            margin-left: 4px;
        }
        
        .ast-container .grey-section .four-column-container p {
            flex: 0 0 100%;
            font-size: 16px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.5;
            letter-spacing: normal;
            color: #3b4045;
            margin: 16px 0 0 0;
            padding: 0;
        }
        
        .ast-container .grey-section .four-column-container .item {
            flex: 0 0 306px;
            border-radius: 8px;
            box-shadow: 0 2px 16px 0 rgba(0, 0, 0, 0.05);
            border: solid 1px #dde1e5;
            background-color: #ffffff;
            padding: 16px;
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
            margin-top: 16px;
            cursor: pointer;
        }
        
        .ast-container .grey-section .four-column-container .item:hover {
            background-color: #f9f9fa;
        }
        
        .ast-container .grey-section .four-column-container .item div.date {
            width: 56px;
            height: 56px;
            margin: 0 0 12px 0;
            border-radius: 4px;
            background-color: #eceef0;
        }
        
        .ast-container .grey-section .four-column-container .item div.date div.day {
            font-size: 24px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: normal;
            text-align: center;
            color: #808a95;
            line-height: 1;
            margin-top: 10px;
        }
        
        .ast-container .grey-section .four-column-container .item div.date div.month {
            font-size: 12px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            letter-spacing: normal;
            text-align: center;
            color: #808a95;
            line-height: 1;
        }
        
        .ast-container .grey-section .four-column-container .item a {
            font-size: 16px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            letter-spacing: normal;
            color: #3b4045;
            flex: 0 0 100%;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .ast-container .grey-section .four-column-container .item div.sup {
            font-size: 12px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.33;
            letter-spacing: normal;
            color: #808a95;
            margin-top: 8px;
        }
        
        .ast-container .grey-section .four-column-container .item div.tags {
            flex: 0 0 100%;
            margin-top: 16px;
        }
        
        .ast-container .grey-section .four-column-container .item div.tags div {
            float: left;
            height: 32px;
            line-height: 32px;
            border-radius: 16px;
            background-color: #eceef0;
            font-size: 12px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            letter-spacing: normal;
            color: #808a95;
            padding: 0 12px;
            margin-right: 8px;
            margin-bottom: 4px;
        }
        
        .ast-container .grey-section .four-column-container .register-now {
            flex: 0 0 100%;
            display: flex;
            align-items: flex-start;
            flex-flow: row wrap;
            border-radius: 4px;
            background-color: #efe733;
            height: 120px;
            align-items: center;
            margin-top: 56px;
        }
        
                
        .ast-container .grey-section .four-column-container .register-now ::selection {
            background-color: #000000;
            color: #fff;
        }

        .ast-container .grey-section .four-column-container .register-now ::-moz-selection {
            background-color: #000000;
            color: #fff;
        }
        
        .ast-container .grey-section .four-column-container .register-now h5 {
            font-family: 'Recoleta';
            font-size: 28px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.14;
            letter-spacing: normal;
            color: #3b4045;
            margin-left: 40px;
            flex: 1 0 0;
        }
        
        .ast-container .grey-section .four-column-container .register-now a {
            height: 48px;
            padding: 0 28px;
            border-radius: 4px;
            background-color: #000000;
            font-size: 16px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 48px;
            letter-spacing: normal;
            text-align: center;
            color: #ffffff;
            flex: 0 0 auto;
            margin-right: 40px;
        }
    </style>
    <div class="yellow-section">
        <div class="tri-column-container">
            <div class="header"><?= __('Let’s shape the face of modern science.', 'joinus4health') ?> <br><?= __('Join us and change the world.', 'joinus4health') ?></div>
            <div class="col1">
                <h5><?= __('Who we are', 'joinus4health') ?></h5>
                <p><?= __('home.who.we.are.description', 'joinus4health') ?></p>
                <a href="#"><?= __('Read more', 'joinus4health') ?> <i data-feather="external-link"></i></a>
            </div>
            <div class="col2">
                <h5><?= __('How to join us', 'joinus4health') ?></h5>
                <p><?= __('home.how.to.join.us.description', 'joinus4health') ?></p>
                <a href="#"><?= __('Read more', 'joinus4health') ?> <i data-feather="external-link"></i></a>
            </div>
            <div class="col3">
                <h5><?= __('Our rules', 'joinus4health') ?></h5>
                <p><?= __('home.our.rules.description', 'joinus4health') ?></p>
                <a href="#"><?= __('Read more', 'joinus4health') ?> <i data-feather="external-link"></i></a>
            </div>
        </div>
    </div>
    <div class="white-section">
        <div class="two-column-container">
            <div class="header"><?= __('Hot topics', 'joinus4health') ?></div>
            <div class="first-col">
                <?php
                $query_params = array(
                    'post_type' => 'ju4htopic', 
                    'posts_per_page' => 4,
                    'orderby' => array('m_votes_count' => 'DESC', 'date' => 'DESC'),
                    'meta_type' => 'NUMERIC',
                    'meta_key' => 'm_votes_count'
                );
                $query = new WP_Query($query_params);
                while ($query->have_posts()):
                $query->the_post();
                $tags = wp_get_post_terms($post->ID, 'ju4htopictag');
                shuffle($tags);
                $m_imageurl = get_post_meta($post->ID, 'm_topimage', true);
                if ($m_imageurl != null) { $m_imageurl = json_decode($m_imageurl); } else { $m_imageurl = null; }
                if ($m_imageurl != null) { $m_imageurl = ' style="background-image: url('.home_url().'/wp-content/'.$m_imageurl->file.');"'; }
                $m_votes = get_post_meta($post->ID, "m_votes");
                $vote_class = (is_array($m_votes) && in_array(get_current_user_id(), $m_votes)) ? 'item-downvote' : 'item-upvote';
                ?>
                <div class="item-topic">
                    <div class="layer0x0">
                        <div class="image"<?= $m_imageurl ?>></div>
                    </div>
                    <div class="layer0x0">
                        <div class="gradient" onclick="load_href('<?= get_the_permalink($post->ID) ?>');"></div>
                    </div>
                    <a href="<?= get_the_permalink($post->ID) ?>"><?= get_translated_title($post, 'm_title', $preferred_language) ?></a>
                    <div class="tags">
                        <?php $i = 0 ?>
                        <?php foreach ($tags as $tag): ?>
                        <a href="<?= get_home_url() ?>/ju4htopic/?topictag=<?= $tag->term_id ?>"><?= $tag->name ?></a>
                        <?php if ($i++ == 2){ break; } ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="voting <?= $vote_class ?>" data-id="<?= $post->ID ?>" id="item-vote-<?= $post->ID ?>" data-url="<?= get_the_permalink($post->ID) ?>">
                        <div class="counter" id="item-votes-<?= $post->ID ?>"><?= count($m_votes) ?></div>
                        <i data-feather="thumbs-up"></i>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <div class="second-col">
                <div class="separator"></div>
                <h6><?= __('What are topics?', 'joinus4health') ?></h6>
                <p><?= __('home.what.are.topics.description.paragraph.1', 'joinus4health') ?></p>
                <p><?= __('home.what.are.topics.description.paragraph.2', 'joinus4health') ?></p>
                <a href="<?= home_url() ?>/ju4htopic/"><?= __('Browse topics', 'joinus4health') ?></a>
            </div>
        </div>
        <div class="two-column-container">
            <div class="header"><?= __('Upcoming suggestions', 'joinus4health') ?></div>
            <div class="first-col">
                <?php
                $query = new WP_Query(array('post_type' => 'ju4hsuggestion', 'posts_per_page' => 5, 'orderby' => array('date' => 'DESC')));
                while ($query->have_posts()):
                $query->the_post();
                $m_votes = get_post_meta($post->ID, "m_votes");
                $vote_class = (is_array($m_votes) && in_array(get_current_user_id(), $m_votes)) ? 'item-downvote' : 'item-upvote';
                ?>
                <div class="item-suggestion">
                    <a href="<?= get_the_permalink($post->ID) ?>"><?= get_translated_title($post, 'm_title', $preferred_language) ?></a>
                    <div class="voting <?= $vote_class ?>" data-id="<?= $post->ID ?>" id="item-vote-<?= $post->ID ?>" data-url="<?= get_the_permalink($post->ID) ?>">
                        <div class="counter" id="item-votes-<?= $post->ID ?>"><?= count($m_votes) ?></div>
                        <i data-feather="thumbs-up"></i>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <div class="second-col">
                <div class="separator"></div>
                <h6><?= __('What are suggestions?', 'joinus4health') ?></h6>
                <p><?= __('home.suggestion.description', 'joinus4health') ?></p>
                <a href="<?= home_url() ?>/ju4hsuggestion/"><?= __('Browse suggestions', 'joinus4health') ?></a>
            </div>
        </div>
    </div>
    <div class="grey-section">
        <div class="four-column-container">
            <div class="header-with-button">
                <h5><?= __('Tasks', 'joinus4health') ?></h5>
                <a href="<?= home_url() ?>/ju4htask/" class="button-black"><b><?= __('See all tasks', 'joinus4health') ?></b> <i data-feather="arrow-right"></i></a>
            </div>
            <p><?= __('home.task.description', 'joinus4health') ?></p>
            <?php
            $query = new WP_Query(array('post_type' => 'ju4htask', 'posts_per_page' => 4));
            while ($query->have_posts()):
            $query->the_post();
            $m_valid_thru = get_post_meta($post->ID, 'm_valid_thru', true);
            $m_valid_thru = is_numeric($m_valid_thru) ? $m_valid_thru : null;
            $m_language = get_post_meta($post->ID, 'm_language', true);
            $m_target_group = get_post_meta($post->ID, 'm_target_group', true);
            $m_source = get_post_meta($post->ID, 'm_source', true);
            $m_level = get_post_meta($post->ID, 'm_level', true);
            ?>
            <div class="item" onclick="load_href('<?= get_the_permalink($post->ID) ?>');">
                <a href="<?= get_permalink($post->ID) ?>"><?= $post->post_title ?></a>
                <?php if($m_valid_thru != null): ?><div class="sup"><?= time_left($m_valid_thru) ?></div><?php endif; ?>
                <div class="tags">
                    <?= $m_language != '' ? '<div>'.$meta_countries[$m_language].'</div>' : '' ?>
                    <?= $m_target_group!= '' ? '<div>'.$meta_target_group[$m_target_group].'</div>' : '' ?>
                    <?= $m_source != '' ? '<div>'.$meta_source[$m_source].'</div>' : '' ?>
                    <?= $m_level != '' ? '<div>'.$meta_level[$m_level].'</div>' : '' ?>
                </div>
            </div>
            <?php endwhile; ?>
            <div class="separator"></div>
            <div class="header-with-button">
                <h5><?= __('Working teams', 'joinus4health') ?></h5>
                <a href="<?= home_url() ?>/groups/" class="button-black"><b><?= __('See all teams', 'joinus4health') ?></b> <i data-feather="arrow-right"></i></a>
            </div>
            <p><?= __('home.working.teams.description', 'joinus4health') ?></p>
            <?php
            $topics = array();
            $query = new WP_Query(array('post_type' => 'forum', 'posts_per_page' => 4));
            while ($query->have_posts()):
            $query->the_post();
            ?>
            <div class="item" onclick="load_href('<?= get_the_permalink($post->ID) ?>');">
                <a href="<?= get_the_permalink($post->ID) ?>"><?= get_the_title($post->ID) ?></a>
                <div class="sup"><?= time_ago($post) ?></div>
            </div>
            <?php endwhile; ?>
            <div class="separator"></div>
            <div class="header-with-button">
                <h5><?= __('Events', 'joinus4health') ?> (todo)</h5>
                <a href="#" class="button-black"><b><?= __('See all events', 'joinus4health') ?></b> <i data-feather="arrow-right"></i></a>
            </div>
            <p><?= __('home.events.description', 'joinus4health') ?></p>
            <div class="item">
                <div class="date">
                    <div class="day">23</div>
                    <div class="month">Dec</div>
                </div>
                <a href="#">Link between fertilisers and agricultural pesticides to...</a>
                <div class="sup">2 days left</div>
            </div>
            <div class="item">
                <div class="date">
                    <div class="day">23</div>
                    <div class="month">Dec</div>
                </div>
                <a href="#">Link between fertilisers and agricultural pesticides to...</a>
                <div class="sup">2 days left</div>
            </div>
            <div class="item">
                <div class="date">
                    <div class="day">23</div>
                    <div class="month">Dec</div>
                </div>
                <a href="#">Link between fertilisers and agricultural pesticides to...</a>
                <div class="sup">2 days left</div>
            </div>
            <div class="item">
                <div class="date">
                    <div class="day">23</div>
                    <div class="month">Dec</div>
                </div>
                <a href="#">Link between fertilisers and agricultural pesticides to...</a>
                <div class="sup">2 days left</div>
            </div>
            <div class="register-now">
                <h5><?= __('home.call.to.register', 'joinus4health') ?></h5>
                <a href="<?= home_url() ?>/sign-up/">Register now</a>
            </div>
        </div>
    </div>
    <?php
    get_footer();