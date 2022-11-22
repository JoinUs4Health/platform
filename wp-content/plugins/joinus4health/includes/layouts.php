<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

function get_js_load_href() {
    ob_start()
?>
<script type="text/javascript">
    function load_href(url) {
        window.location.href = url;
    }
</script><?php
    $output = ob_get_clean();
    return $output;
}

function get_js_script_voting($url = null) {
    ob_start()
?>  
<script type="text/javascript">
    $(document).ready(function() {
        $(".item-upvote,.item-downvote").click(function() {
            if ($(this).hasClass("item-upvote")) {
                elOperation = "upvote";
            } else {
                elOperation = "downvote";
            }
            
            elId = $(this).attr("data-id");
            elUrl = $(this).attr('data-url');
            $.ajax({
                type: 'GET',
                <?php if ($url == null): ?>
                url: elUrl + "?operation=" + elOperation,
                <?php else: ?>
                url: "<?= $url ?>?operation=" + elOperation,
                <?php endif; ?>
                dataType: 'json',
                success: function (data) {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        $('#item-votes-' + elId).text(data.votes);
                        if (elOperation == "upvote") {
                            $("#item-vote-" + elId).attr("class", "voting item-downvote");
                        } else {
                            $("#item-vote-" + elId).attr("class", "voting item-upvote");
                        }
                    }
                }
            });
        });
    });
</script><?php
    $output = ob_get_clean();
    return $output;
}

function get_js_script_follow($url) {
    ob_start()
?>  
<script type="text/javascript">
    $(document).ready(function() {
        $(".item-follow,.item-unfollow").click(function() {
            if ($(this).hasClass("item-follow")) {
                elOperation = "follow";
            } else {
                elOperation = "unfollow";
            }
            
            elId = $(this).attr("data-id");
            $.ajax({
                type: 'GET',
                url: "<?= $url ?>?operation=" + elOperation,
                dataType: 'json',
                success: function (data) {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        if (elOperation == 'follow') {
                            $('.item-follow > div.text').html("<?= __("Following", 'joinus4health') ?>");
                            $('.item-follow > svg').replaceWith(feather.icons['check'].toSvg());
                        } else {
                            $('.item-unfollow > div.text').html("<?= __("Follow", 'joinus4health') ?>");
                            $('.item-unfollow > svg').replaceWith(feather.icons['eye'].toSvg());
                        }
                        
                        $('#item-follows-' + elId).text(data.follows);
                        
                        if (elOperation == "follow") {
                            $("#modal-follow").modal();
                            $("#item-follow-" + elId).attr("class", "btn item-unfollow");
                        } else {
                            $("#item-follow-" + elId).attr("class", "btn item-follow");
                        }
                    }
                }
            });
        });
    });
</script><?php
    $output = ob_get_clean();
    return $output;
}

function get_js_script_contribute($url) {
    ob_start()
?>  
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', ".item-contribute", function() {
            elOperation = "contribute";
            elId = $(".item-contribute").attr("data-id");
            
            $.ajax({
                type: 'GET',
                url: "<?= $url ?>?operation=" + elOperation,
                dataType: 'json',
                success: function (data) {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        $("#modal-contribute").modal();
                        $('.item-contribute div.text').html("<?= __("Contributing", 'joinus4health') ?>");
                        $('.item-contribute svg').replaceWith(feather.icons['check'].toSvg());            
                        $('#item-contributes-' + elId).text(data.contributes);
                        $("#item-contribute-" + elId).attr("class", "black-btn item-uncontribute");
                    }
                }
            });
        });
        
        $(document).on('click', ".item-uncontribute", function() {
            $("#modal-uncontribute").modal();
        });
        
        $(document).on('click', "#uncontribute-yes", function() {
            elOperation = "uncontribute";
            elId = $(".item-uncontribute").attr("data-id");

            $.ajax({
                type: 'GET',
                url: "<?= $url ?>?operation=" + elOperation,
                dataType: 'json',
                success: function (data) {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        $('.item-uncontribute div.text').html("<?= __("Contribute", 'joinus4health') ?>");
                        $('.item-uncontribute svg').replaceWith(feather.icons['user-plus'].toSvg());
                        $('#item-contributes-' + elId).text(data.contributes);
                        $("#item-contribute-" + elId).attr("class", "black-btn item-contribute");
                    }
                }
            });
        });
    });
</script><?php
    $output = ob_get_clean();
    return $output;
}

function html_topic($post) {
    global $meta_topic_status;
    ob_start();
    $tags = wp_get_post_terms($post->ID, 'ju4htopictag');
    $m_status = get_post_meta($post->ID, 'm_status', true);
    $m_votes = get_post_meta($post->ID, "m_votes");
    $vote_class = (is_array($m_votes) && in_array(get_current_user_id(), $m_votes)) ? 'item-downvote' : 'item-upvote';
    $preferred_language = get_preferred_language();
    ?>        <div class="topic-item">
            <div class="voting-col">
                <div class="voting <?= $vote_class ?>" data-id="<?= $post->ID ?>" id="item-vote-<?= $post->ID ?>" data-url="<?= get_the_permalink($post->ID) ?>">
                    <div class="counter" id="item-votes-<?= $post->ID ?>"><?= count($m_votes) ?></div>
                    <i data-feather="thumbs-up"></i>
                </div>
            </div>
            <div class="content-col" onclick="load_href('<?= get_the_permalink($post->ID) ?>');">
                <h5><a href="<?= get_the_permalink($post->ID) ?>" id="item-url-<?= $post->ID ?>"><?= get_translated_title($post, 'm_title', $preferred_language) ?></a></h5>
                <?= isset($meta_topic_status[$m_status]) ? '<div class="tag">'.$meta_topic_status[$m_status].'</div>' : "" ?>
                <div class="date-time"><?= __('submitted by', 'joinus4health') ?> <?= get_the_author() ?> / <?= get_the_date('j F Y, H:i', $post) ?></div>
                <div class="content"><?= get_translated_field($post, 'm_intro', $preferred_language) ?></div>
                <?php if (count($tags) > 0): ?>
                <div class="tags">
                    <?php foreach ($tags as $tag): ?>
                    <a href="<?= get_home_url() ?>/ju4htopic/?topictag=<?= $tag->term_id ?>"><?= $tag->name ?></a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="image-col" onclick="load_href('<?= get_the_permalink($post->ID) ?>');">
                <?php $m_imageurl = get_post_meta($post->ID, 'm_topimage', true) ?>
                <?php if ($m_imageurl != null) { $m_imageurl = json_decode($m_imageurl); } else { $m_imageurl = null; } ?>
                <?php if ($m_imageurl != null) { $m_imageurl = ' style="background-image: url('.home_url().'/wp-content/'.$m_imageurl->file.');"'; } ?>
                <div class="image"<?= $m_imageurl ?>></div>
            </div>
        </div><?php
    $output = ob_get_clean();
    return $output;
}


function html_comment($comment, $offset_left, $enabled_reply = true) {
    ?>
            <div class="comment"<?php if ($offset_left > 0): ?> style="padding-left: <?= $offset_left ?>px;"<?php endif; ?>>
                <div class="avatar" style="background-image: url(<?= bp_core_fetch_avatar(array('item_id' => $comment->user_id, 'html' => false)) ?>);"></div>
                <div class="container">
                    <div class="author"><?= $comment->comment_author ?></div>
                    <div class="date"><?= get_comment_date('j F Y, H:i', $comment) ?></div>
                    <?php $comment_txt = $comment->comment_content ?>
                    <?php if (mb_strlen($comment_txt) > 250): ?>
                    <div class="txt">
                        <?= mb_substr($comment_txt, 0, 250) ?>... <a href="#" class="readmore">[Read more]</a>
                    </div>
                    <div class="txt txt-full" style="display: none;">
                        <?= nl2br($comment_txt) ?>
                    </div>
                    <?php else: ?>
                    <div class="txt txt-full">
                        <?= nl2br($comment_txt) ?>
                    </div>
                    <?php endif; ?>
                    <div class="urls">
                        <?php if ($enabled_reply && is_user_logged_in()): ?>
                        <a href="#reply-comment" class="comment-reply" id="comment-id-<?= $comment->comment_ID ?>">Reply</a>
                        <?php endif; ?>
                        <a href="" class="translate">Translate</a>
                    </div>
                    
                </div>
            </div>
    <?php
}

function html_task($post) {
    global $post, $meta_task_duration;
    $m_valid_thru = get_post_meta($post->ID, 'm_valid_thru', true);
    $m_valid_thru = is_numeric($m_valid_thru) ? $m_valid_thru : null;
    $preferred_language = get_preferred_language();
    ?>
            <div class="task-item">
                <div class="two-line-content">
                    <a href="<?= get_the_permalink($post->ID) ?>" class="title"><?= get_translated_title($post, 'm_title', $preferred_language) ?></a>
                    <?php if($m_valid_thru != null): ?><div class="days-left"><?= __('Valid thru', 'joinus4health').': '.wp_date('d F Y', $m_valid_thru) ?></div><?php endif; ?>
                    <div class="submit-by"><?= __('submitted by', 'joinus4health') ?> <?= get_the_author() ?> / <?= get_the_date('j F Y, H:i', $post) ?></div>
                </div>
                <?php $m_duration = get_post_meta($post->ID, 'm_duration', true) ?>
                <?php if (is_numeric($m_duration) && array_key_exists($m_duration, $meta_task_duration)): ?>
                <div class="tag"><?= $meta_task_duration[$m_duration] ?></div>
                <?php endif; ?>
            </div>
    <?php
}

function html_suggestion($post) {
    global $post, $meta_suggestion_duration;
    $m_votes = get_post_meta($post->ID, "m_votes");
    $vote_class = (is_array($m_votes) && in_array(get_current_user_id(), $m_votes)) ? 'item-downvote' : 'item-upvote';
    $preferred_language = get_preferred_language();
    ?>
            <div class="suggestion-item">
                <div class="voting <?= $vote_class ?>" data-id="<?= $post->ID ?>" id="item-vote-<?= $post->ID ?>" data-url="<?= get_the_permalink($post->ID) ?>">
                    <div class="counter" id="item-votes-<?= $post->ID ?>"><?= count($m_votes) ?></div>
                    <i data-feather="thumbs-up"></i>
                </div>
                <div class="two-line-content" onclick="load_href('<?= get_the_permalink($post->ID) ?>');">
                    <a href="<?= get_the_permalink($post->ID) ?>" id="item-url-<?= $post->ID ?>" class="title"><?= get_translated_title($post, 'm_title', $preferred_language) ?></a>
                    <div class="submit-by"><?= __('submitted by', 'joinus4health') ?> <?= get_the_author() ?> / <?= get_the_date('j F Y, H:i', $post) ?></div>
                </div>
                <?php $m_duration = get_post_meta($post->ID, 'm_duration', true) ?>
                <?php if (is_numeric($m_duration) && array_key_exists($m_duration, $meta_suggestion_duration)): ?>
                <div class="tag"><?= $meta_suggestion_duration[$m_duration] ?></div>
                <?php endif; ?>
            </div>
    <?php
}

function html_modal_share($permalink) {
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#do-action').click(function(){
                var copyText = document.getElementById("url-share");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
            });
        });
    </script>
    <div id="share" class="modal">
    <h4><?= __('Share this page', 'joinus4health') ?></h4>
    <div class="separator"></div>
    <div class="methods">
        <div class="method">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($permalink) ?>" class="fb"><i data-feather="facebook"></i></a>
            <span><?= __('Facebook', 'joinus4health') ?></span>
        </div>
        <div class="method">
            <a href="http://twitter.com/share?url=<?= $permalink ?>" class="twitter"><i data-feather="twitter"></i></a>
            <span><?= __('Twitter', 'joinus4health') ?></span>
        </div>
        <div class="method">
            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $permalink ?>" class="linkedin"><i data-feather="linkedin"></i></a>
            <span><?= __('Linkedin', 'joinus4health') ?></span>
        </div>
    </div>
    <div class="buttons">
        <input type="text" id="url-share" value="<?= $permalink ?>" />
        <div id="do-action">
            <i data-feather="copy"></i>
            <div class="text"><?= __('Copy', 'joinus4health') ?></div>
        </div>
    </div>
</div>
<?php
}

function js_add_or_reply_comment() {
    ?>
    <script type="text/javascript">
    $(document).ready(function(){        
        $('.comment > .container > .urls > a.comment-reply').click(function() {
            comment_reply_id = $(this).attr('id').split('-')[2];
            $('#comment_parent').val(comment_reply_id);
            comment_reply_to = $(this).parent().parent().find('.author').html();
            $('.add-comment .caption').html("<?= __('Reply to', 'joinus4health') ?> " + comment_reply_to + " <?= __('comment', 'joinus4health') ?>");
        });
    });
    </script>
    <?php
}

function html_modal_uncontribute() {
?>
<div id="modal-uncontribute" class="modal">
    <h4><?= __('Confirm action', 'joinus4health') ?></h4>
    <div class="text"><?= __('Do you want to cancel your contribution?', 'joinus4health') ?></div>
    <div class="buttons">
        <a href="#" rel="modal:close" id="uncontribute-yes" class="blackbtn"><?= __('Yes', 'joinus4health') ?></a>
        <a href="#" rel="modal:close"><?= __('No', 'joinus4health') ?></a>
    </div>
</div>
<?php
}

function html_modal_follow() {
?>
<div id="modal-follow" class="modal">
    <h4><?= __('Confirm action', 'joinus4health') ?></h4>
    <div class="text"><?= __('You will receive a message if important updates or activities occur.', 'joinus4health') ?></div>
    <div class="buttons">
        <a href="#" rel="modal:close"><?= __('Ok', 'joinus4health') ?></a>
    </div>
</div>
<?php
}

function html_modal_contribute() {
?>
<div id="modal-contribute" class="modal">
    <h4><?= __('Confirm action', 'joinus4health') ?></h4>
    <div class="text"><?= __('The facilitator will contact you with further information.', 'joinus4health') ?></div>
    <div class="buttons">
        <a href="#" rel="modal:close"><?= __('Ok', 'joinus4health') ?></a>
    </div>
</div>
<?php
}
