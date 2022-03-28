<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$meta_languages = array(
    "NL" => __("Dutch", 'joinus4health'),
    "EN" => __("English", 'joinus4health'),
    "DE" => __("German", 'joinus4health'),
    "PL" => __("Polish", 'joinus4health'),
);

$meta_countries = array(
    "DE" => __("Germany", 'joinus4health'),
    "NL" => __("the Netherlands", 'joinus4health'),
    "PL" => __("Poland", 'joinus4health'),
    "_" => __("other", 'joinus4health'),
);

$meta_stakeholder_group = array(
    1 => __("citizens / citizens' organization", 'joinus4health'), 
    2 => __("scientists", 'joinus4health'),
    3 => __("policy makers", 'joinus4health'),
    4 => __("business / industry", 'joinus4health'),
    5 => __("pupils / students", 'joinus4health'),
    6 => __("other group", 'joinus4health'),
);

$meta_suggestion_types = array(
    1 => __("topic of interest", 'joinus4health'),
    2 => __("research question", 'joinus4health'),
    3 => __("information need", 'joinus4health'),
    4 => __("training need", 'joinus4health'),
    5 => __("offer", 'joinus4health'),
    6 => __("suggestion", 'joinus4health'), 
    7 => __("example", 'joinus4health'),
);

$meta_topic_types = array(
    1 => __("co-creation", 'joinus4health'),
    2 => __("construction", 'joinus4health'),
    3 => __("promotion", 'joinus4health'),
    4 => __("dissemination", 'joinus4health'),
    5 => __("reflection", 'joinus4health'),
);

$meta_task_types = array(
    1 => __("review posts", 'joinus4health'),
    2 => __("translation", 'joinus4health'),
    3 => __("facilitation", 'joinus4health'),
    4 => __("review contents", 'joinus4health'),
    5 => __("other", 'joinus4health'),
);

$meta_task_duration = array(
    5 => __("5 min", 'joinus4health'),
    10 => __("10 min", 'joinus4health'),
    20 => __("20 min", 'joinus4health'),
    30 => __("30 min", 'joinus4health'),
    60 => __("1 hour", 'joinus4health'),
    90 => __("1h 30 min", 'joinus4health'), 
    120 => __("2 hours", 'joinus4health'),
    180 => __("3 hours", 'joinus4health'),
    240 => __("4 hours", 'joinus4health'),
    300 => __("5 hours", 'joinus4health'),
    360 => __("6 hours", 'joinus4health'),
    420 => __("7 hours", 'joinus4health'),
    480 => __("8 hours", 'joinus4health'),
    540 => __("9 hours", 'joinus4health'),
    600 => __("10 hours", 'joinus4health'),
    60*24 => __("24 hours", 'joinus4health'),
);

$meta_suggestion_duration = array(
    5 => __("5 min", 'joinus4health'),
    10 => __("10 min", 'joinus4health'),
    20 => __("20 min", 'joinus4health'),
    30 => __("30 min", 'joinus4health'),
    60 => __("1 hour", 'joinus4health'),
    90 => __("1h 30 min", 'joinus4health'), 
    120 => __("2 hours", 'joinus4health'),
    180 => __("3 hours", 'joinus4health'),
    240 => __("4 hours", 'joinus4health'),
    300 => __("5 hours", 'joinus4health'),
    360 => __("6 hours", 'joinus4health'),
    420 => __("7 hours", 'joinus4health'),
    480 => __("8 hours", 'joinus4health'),
    540 => __("9 hours", 'joinus4health'),
    600 => __("10 hours", 'joinus4health'),
    60*24 => __("24 hours", 'joinus4health'),
);

$meta_task_level = array(
    1 => __("individual", 'joinus4health'), 
    2 => __("group", 'joinus4health'), 
);

$meta_suggestion_source = array(
    1 => __("platform user", 'joinus4health'), 
    2 => __("working team", 'joinus4health'), 
    3 => __("external source", 'joinus4health')
);

$meta_topic_source = array(
    1 => __("suggestion", 'joinus4health'), 
    2 => __("administrator", 'joinus4health'), 
    3 => __("external source", 'joinus4health')
);

$meta_task_source = array(
    1 => __("platform user", 'joinus4health'), 
    2 => __("administrator", 'joinus4health'), 
    3 => __("external source", 'joinus4health')
);

$meta_topic_status = array(
    1 => __("active", 'joinus4health'), 
    2 => __("continuous", 'joinus4health'), 
    3 => __("closed", 'joinus4health'),
);

/**
 * Sort by
 */
$meta_topic_sortby = array(
    '' => __('Date of publication', 'joinus4health'),
    'votes' => __('Votes', 'joinus4health'),
);

$meta_task_sortby = array(
    '' => __('Date of publication', 'joinus4health'),
    'contribution'  => __('Time of contribution', 'joinus4health'),
);

$meta_suggestion_sortby = array(
    '' => __('Date of publication', 'joinus4health'),
    'votes' => __('Votes', 'joinus4health'),
);

/**
 * Common
 */
$meta_process = array(
    '1' => __('brainstorming', 'joinus4health'),
    '2' => __('planing', 'joinus4health'),
    '3' => __('design', 'joinus4health'),
    '4' => __('collection', 'joinus4health'),
    '5' => __('analysis', 'joinus4health'),
    '6' => __('interpretation', 'joinus4health'),
    '7' => __('communication', 'joinus4health'),
    '8' => __('dissemination', 'joinus4health'),
    '9' => __('engagement', 'joinus4health'),
    '10' => __('community building', 'joinus4health'),
    '11' => __('monitoring/evaluation', 'joinus4health'),
);

$meta_methods = array(
    '1' => __('collaboration', 'joinus4health'),
    '2' => __('co-creation', 'joinus4health'),
    '3' => __('crowdsourcing', 'joinus4health'),
    '4' => __('epidemiology', 'joinus4health'),
    '5' => __('participation', 'joinus4health'),
    '6' => __('Responsible Research and Innovation', 'joinus4health'),
    '7' => __('systems thinking', 'joinus4health'),
    '8' => __('transdisciplinarity', 'joinus4health'),);

$meta_contents = array(
    '1' => __('awarness raising', 'joinus4health'),
    '2' => __('prevention', 'joinus4health'),
    '3' => __('diagnosis', 'joinus4health'),
    '4' => __('surveillance', 'joinus4health'),
    '5' => __('therapy', 'joinus4health'),
    '6' => __('working together', 'joinus4health'),
);
