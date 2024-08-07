<?php

/*
 Plugin Name: BS-Gallery
 Plugin URI: 
 Description: BS-Gallery
 Version: 0.9.27
 Author: BlueSuiter's
 Author URI: 
 */

require_once(plugin_dir_path(__FILE__) . 'bootstrap.php');

$swiperCss = "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css";
$swiperJs = "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js";

register_activation_hook(__FILE__, function () {
    (new \BsGallery\Migrations\Migration())->loadMigrations();
});

add_action('upgrader_process_complete', (new \BsGallery\Migrations\Migration()), 'upgrade');
