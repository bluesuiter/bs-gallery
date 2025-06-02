<?php

/*
 Plugin Name: BS-Gallery
 Plugin URI: https://github.com/bluesuiter/bs-gallery
 Description: BS-Gallery
 Version: 1.12
 Author: BlueSuiter's
 Author URI: https://amitchauhan.net
 */

require_once(plugin_dir_path(__FILE__) . 'bootstrap.php');

$swiperCss = "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css";
$swiperJs = "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js";

register_activation_hook(__FILE__, function () {
    (new \BsGallery\Migrations\Migration())->loadMigrations();
});
