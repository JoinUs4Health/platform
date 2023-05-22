<?php
require_once('../../../wp-load.php');

$api_key = JU4H_DEEPL_TOKEN;
$post_options = array('PL', 'DE', 'NL', 'EN');

if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME']) === FALSE) {
    exit();
}

if (isset($_POST['target_lang']) && in_array($_POST['target_lang'], $post_options) && isset($_POST['text'])) {
    $ch = curl_init("https://api-free.deepl.com/v2/translate");

    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('target_lang' => $_POST['target_lang'], 'text' => $_POST['text'])));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: DeepL-Auth-Key $api_key"));

    $output = curl_exec($ch);

    if(curl_error($ch)) {
        curl_close($ch);
        exit();
    }

    curl_close($ch);
    
    $json = json_decode($output);
    
    if (isset($json->translations) && is_array($json->translations) && count($json->translations) > 0 && isset($json->translations[0]->text)) {
        echo $json->translations[0]->text;
    }
}