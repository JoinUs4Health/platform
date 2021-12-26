<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}


/*
register_activation_hook(__FILE__, 'my_activation');
 
function my_activation() {
    if (! wp_next_scheduled ( 'my_hourly_event' )) {
        wp_schedule_event(time(), 'hourly', 'my_hourly_event');
    }
}
 
add_action('my_hourly_event', 'do_this_hourly');
 
function do_this_hourly() {
    $query = new WP_Query(array('post_type' => 'topic', 'posts_per_page' => -1));
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $post = $query->post;
            $meta = get_post_meta($post->ID);
            $meta_votes_times = $meta['m_votes_time'];
            
            foreach ($meta_votes_times as $index => $m_vote_time) {
                if (explode(':', $m_vote_time)[1] < (time() - 24*3600)) {
                    delete_post_meta(get_the_ID(), 'm_votes_time', $m_vote_time);
                }
            }
            
            $meta = get_post_meta($post->ID);
            update_post_meta($post->ID, 'm_trending_votes', count($meta['m_votes_time']));
        }
    }
}
 */