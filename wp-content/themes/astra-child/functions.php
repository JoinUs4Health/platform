<?php

function my_custom_styles() {
    wp_deregister_style('astra-google-fonts');
    wp_register_style('astra-google-fonts', home_url().'/wp-content/themes/astra-child/css/google-fonts.css', array(), '1.0', 'all');
    
    wp_register_style('astra-theme-css', home_url().'/wp-content/themes/astra/assets/css/minified/main.min.css', array(), time(), 'all');
    // Load my custom stylesheet
    wp_enqueue_style('astra-theme-css');

    wp_register_style('astra-theme-css-2', home_url().'/wp-content/themes/astra-child/style.css', array(), time(), 'all');
    // Load my custom stylesheet
    wp_enqueue_style('astra-theme-css-2');
}
add_action('wp_enqueue_scripts', 'my_custom_styles', 12);

/**
 * Custom style login
 */
function ju4h_custom_style_login() { 
    ?>
    <style>
        body {
            background: #efe733;
        }

        .login h1 a {
            background-image: url(<?= home_url() ?>/wp-content/themes/astra-child/img/logo.png);
            width: 180px;
            height: 110px;
            background-size: 180px;
        }

        #wp-submit {
            background: #000000;
            border-color: #000000;
        }

        .dashicons {
            color: #000000;
        }

        a {
            color: #000000;
        }
    </style>
    <?php
}
add_action('login_head', 'ju4h_custom_style_login');