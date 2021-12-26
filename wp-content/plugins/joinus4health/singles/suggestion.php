<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$meta = get_post_meta(get_the_ID());
$labels = array(__("Country"), __("Language"), __("Duration"), __("Type"), __("Level"), __('Source'), __("Target stakeholder group"));
$names = array("m_country", "m_language", "m_duration", "m_type", "m_level", "m_source", "m_target_group");
$values = array($meta_countries, $meta_countries, $meta_contribute_duration, $meta_types, $meta_level, $meta_source, $meta_target_group);
?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<?php js_script_voting() ?>
<?php get_header(); ?>

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
        
        .ast-container .bread-crumb a {
            font-family: Manrope;
            font-size: 12px;
            font-weight: 600;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.33;
            letter-spacing: normal;
            color: #808a95;
        }
        
        .ast-container .top-column-2-colspan {
            flex: 0 1 100%;
            margin-bottom: 24px;
        }
        
        .ast-container .top-column-2-colspan .image {
            width: 100%;
            height: 346px;
            background-image: url(http://zryjto.linuxpl.info/platforma_dev/d28c65af4044b1d2bc8ff5f058d7.webp);
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
            height: 48px;
            border-radius: 4px;
            border: solid 1px #dde1e5;
            background-color: #f9f9fa;

            margin-left: 20px;
        }

        .ast-container .top-column-2-colspan .title-and-buttons .voting .counter {
            height: 40px;
            margin-top: 3px;
            border-radius: 2px;
            border: solid 1px #ced4d9;
            line-height: 40px;
            background-color: #ffffff;
            margin-left: 3px;
            margin-right: 38px;
            padding-left: 8px;
            padding-right: 8px;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons .title {
            margin-left: 16px;
            flex: 1 0 0;
            font-size: 28px;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons a.btn {
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
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons a.btn:hover {
            background-color: #ededed;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons a.black-btn {
            border-radius: 4px;
            height: 48px;
            padding-left: 24px;
            padding-right: 24px;
            margin-right: 12px;
            background-color: #000000;
            
            font-size: 16px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 45px;
            letter-spacing: normal;
            text-align: center;
            color: #dde1e5;
        }
        
        .ast-container .top-column-2-colspan .title-and-buttons a.black-btn:hover {
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
            height: 126px;
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
            padding-bottom: 8px;
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
            
            background-image: url('http://zryjto.linuxpl.info/platforma_dev/d28c65af4044b1d2bc8ff5f058d7.webp');
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
            flex: 1 0 50%;
            font-size: 14px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.43;
            letter-spacing: normal;
            color: #808a95;
            margin-bottom: 16px;
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
        <a href="#">Topics</a>
    </div>
    <div class="top-column-2-colspan column-common-border-style">
        <div class="image"></div>
        <div class="title-and-buttons">
            <div class="voting">
                <div class="counter">340</div>
            </div>
            <div class="title"><?php the_title() ?></div>
            <a href="#" class="btn">Share</a>
            <a href="#" class="btn">Follow</a>
            <a href="#" class="black-btn">Contribute</a>
        </div>
    </div>
    <div class="first-column">
        <div class="content column-common-border-style">
            <h6>Topic details</h6>
            <p>Vivamus sed nunc at est elementum elementum. Nulla pretium tincidunt libero eget lobortis. Aliquam erat volutpat. Proin porta ex nec feugiat suscipit. Vivamus diam magna, iaculis eget placerat at, dignissim a turpis. Etiam bibendum, nunc eget posuere egestas, enim lorem euismod diam, quis tincidunt turpis lacus sed ipsum. Praesent convallis nibh lectus, a dignissim lectus tincidunt et. Donec ut enim mi. Quisque eu mi sed massa euismod cursus.</p>
            <p>Sed suscipit tortor eu consectetur consequat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nam pellentesque vehicula commodo. Fusce vitae libero vitae risus pharetra facilisis mattis vel quam. Duis vitae consequat lectus, ut sollicitudin quam. </p>
            <div class="tags">
                <a href="#">cancer</a>
                <a href="#">turbo</a>
                <a href="#">engine</a>
                <a href="#">bridge</a>
                <a href="#">antenna</a>
                <a href="#">cryptography</a>
                <a href="#">cancer</a>
                <a href="#">turbo</a>
                <a href="#">engine</a>
                <a href="#">bridge</a>
                <a href="#">antenna</a>
                <a href="#">cryptography</a>
            </div>
            <div class="separator"></div>
            <h6>Attachments</h6>
            <div class="attachments">
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
            <div class="separator"></div>
            <h6>Related tasks</h6>
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
        <h6 class="comments">Comments (16)</h6>
        <div class="add-comment">
            <div class="caption">Add comment</div>
            <form>
                <input type="text" class="new-comment" />
                <input type="submit" value="Submit" class="submit" />
            </form>
            <div class="sub">Comments and replies are moderated. Your comment will appear here once the site administrator accepts it.</div>
        </div>
        <div class="comments">
            <div class="comment">
                <div class="avatar"></div>
                <div class="container">
                    <div class="author">root</div>
                    <div class="date">6 September 2019, 11:10 am</div>
                    <div class="txt">Vivamus sed nunc at est elementum elementum. Nulla pretium tincidunt libero eget lobortis. Aliquam erat volutpat. Proin porta ex nec feugiat suscipit. Vivamus diam magna, iaculis eget placerat at, dignissim.</div>
                    <div class="urls">
                        <a href="#">Reply</a>
                        <a href="#">Edit</a>
                    </div>
                </div>
            </div>
            <div class="comment" style="padding-left: 72px;">
                <div class="avatar"></div>
                <div class="container">
                    <div class="author">root</div>
                    <div class="date">6 September 2019, 11:10 am</div>
                    <div class="txt">Vivamus sed nunc at est elementum elementum. Nulla pretium tincidunt libero eget lobortis. Aliquam erat volutpat. Proin porta ex nec feugiat suscipit. Vivamus diam magna, iaculis eget placerat at, dignissim.</div>
                </div>
            </div>
            <div class="comment" style="padding-left: 144px">
                <div class="avatar"></div>
                <div class="container">
                    <div class="author">root</div>
                    <div class="date">6 September 2019, 11:10 am</div>
                    <div class="txt">Vivamus sed nunc at est elementum elementum. Nulla pretium tincidunt libero eget lobortis. Aliquam erat volutpat. Proin porta ex nec feugiat suscipit. Vivamus diam magna, iaculis eget placerat at, dignissim.</div>
                </div>
            </div>
            
            <div class="comment">
                <div class="avatar"></div>
                <div class="container">
                    <div class="author">root</div>
                    <div class="date">6 September 2019, 11:10 am</div>
                    <div class="txt">Vivamus sed nunc at est elementum elementum. Nulla pretium tincidunt libero eget lobortis. Aliquam erat volutpat. Proin porta ex nec feugiat suscipit. Vivamus diam magna, iaculis eget placerat at, dignissim.</div>
                    <div class="urls">
                        <a href="#">Reply</a>
                        <a href="#">Edit</a>
                    </div>
                </div>
            </div>
            <div class="comment" style="padding-left: 72px;">
                <div class="avatar"></div>
                <div class="container">
                    <div class="author">root</div>
                    <div class="date">6 September 2019, 11:10 am</div>
                    <div class="txt">Vivamus sed nunc at est elementum elementum. Nulla pretium tincidunt libero eget lobortis. Aliquam erat volutpat. Proin porta ex nec feugiat suscipit. Vivamus diam magna, iaculis eget placerat at, dignissim.</div>
                </div>
            </div>
            <div class="comment" style="padding-left: 144px">
                <div class="avatar"></div>
                <div class="container">
                    <div class="author">root</div>
                    <div class="date">6 September 2019, 11:10 am</div>
                    <div class="txt">Vivamus sed nunc at est elementum elementum. Nulla pretium tincidunt libero eget lobortis. Aliquam erat volutpat. Proin porta ex nec feugiat suscipit. Vivamus diam magna, iaculis eget placerat at, dignissim.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="second-column">
        <div class="details column-common-border-style">
            <div class="author">
                <div class="avatar"></div>
                <div class="lines">
                    <div class="name">Author</div>
                    <div class="sub">Sub</div>
                </div>
            </div>
            <div class="separator"></div>
            <div class="tags-info">
                <div>review</div>
                <div>1 hours</div>
                <div>review 2nd</div>
                <div>3 hours</div>
                <div>1st review</div>
                <div>12 hours</div>
                <div>review again</div>
                <div>33 hours</div>
            </div>
            <div class="rows">
                <div>Created</div>
                <div>Valid thru</div>
                <div class="value">2 days ago</div>
                <div class="value">31 dec 2021</div>
                <div class="space"></div>
                <div class="space"></div>
                <div>Following</div>
                <div>Contributing</div>
                <div class="value">31</div>
                <div class="value">12</div>
            </div>
            <div class="separator"></div>
            <div class="rows2">
                <div>Language</div>
                <div class="value">German</div>
                <div>Stakeholder group</div>
                <div class="value">Policy makers</div>
                <div>Source</div>
                <div class="value">Platform user</div>
            </div>        
        </div>
        <div class="links column-common-border-style">
            <h6>Assigned working group</h6>
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
            <div class="separator"></div>
            <h6>Outcomes</h6>
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
            <div class="separator"></div>
            <h6>Original suggestions</h6>
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
