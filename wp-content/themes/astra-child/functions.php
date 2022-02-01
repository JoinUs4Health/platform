<?php


function my_custom_styles() {
  // Register my custom stylesheet

  wp_register_style('astra-theme-css', 'http://zryjto.linuxpl.info/platforma_dev/wp-content/themes/astra/assets/css/minified/main.min.css', array(), time(), 'all');
  // Load my custom stylesheet
  wp_enqueue_style('astra-theme-css');

  wp_register_style('astra-theme-css-2', 'http://zryjto.linuxpl.info/platforma_dev/wp-content/themes/astra-child/style.css', array(), time(), 'all');
  // Load my custom stylesheet
  wp_enqueue_style('astra-theme-css-2');

  
}
add_action('wp_enqueue_scripts', 'my_custom_styles', 1);

