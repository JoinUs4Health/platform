<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

function js_load_href() {
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

function js_script_voting($url = null) {
    ob_start()
?>  
<script type="text/javascript">
    $(document).ready(function() {
        $(".item-upvote,.item-downvote").click(function() {
            elOperation = $(this).attr("class").split("-")[1];
            elId = $(this).attr("id").split("-")[2];
            elUrl = $("#item-url-" + elId).attr("href");
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

function js_script_follow($url) {
    ob_start()
?>  
<script type="text/javascript">
    $(document).ready(function() {
        $(".item-follow,.item-unfollow").click(function() {
            elOperation = $(this).attr("class").split("-")[1];
            elId = $(this).attr("id").split("-")[2];
            $.ajax({
                type: 'GET',
                url: "<?= $url ?>?operation=" + elOperation,
                dataType: 'json',
                success: function (data) {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        $('#item-follows-' + elId).text(data.follows);
                        if (elOperation == "follow") {
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

function html_topic($post) {
    ob_start();
    $meta = get_post_meta($post->ID);
    $tags = wp_get_post_terms($post->ID, 'ju4htopictag');
    
    $m_votes = get_post_meta($post->ID, "m_votes");
    $vote_class = (is_array($m_votes) && in_array(get_current_user_id(), $m_votes)) ? 'item-downvote' : 'item-upvote';
    ?>        <div class="topic-item">
            <div class="voting-col">
                <div class="voting <?= $vote_class ?>" id="item-vote-<?= $post->ID ?>">
                    <div class="counter" id="item-votes-<?= $post->ID ?>"><?= count($m_votes) ?></div>
                    <span></span>
                </div>
            </div>
            <div class="content-col" onclick="load_href('<?= get_the_permalink($post->ID) ?>');">
                <h5><a href="<?= get_the_permalink($post->ID) ?>" id="item-url-<?= $post->ID ?>"><?= $post->post_title ?></a></h5>
                <div class="tag">co-creation</div>
                <div class="date-time">submitted by <?= get_the_author() ?></div>
                <div class="content"><?= get_post_meta(get_the_ID(), 'm_description', true) ?></div>
                <?php if (count($tags) > 0): ?>
                <div class="tags">
                    <?php foreach ($tags as $tag): ?>
                    <a href="<?= get_home_url() ?>/ju4htopics/?topictag=<?= $tag->term_id ?>"><?= $tag->name ?></a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="image-col" onclick="load_href('<?= get_the_permalink($post->ID) ?>');">
                <div class="image"></div>
            </div>
        </div><?php
    $output = ob_get_clean();
    return $output;
}