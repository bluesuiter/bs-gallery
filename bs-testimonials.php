<?php
/*
Plugin Name: BS-Testimonials
Plugin URI: https://scriptrecipes.blogspot.in/
Description: .
Version: 0.9.17
Author: BlueSuiter's
Author URI: 
License: GPLv3 or later
Text Domain: bs-testimonials
*/


require_once(plugin_dir_path(__FILE__) . DIRECTORY_SEPARATOR . 'testimonial-meta.php');
require_once(plugin_dir_path(__FILE__) . DIRECTORY_SEPARATOR . 'custom-post-type.php');
require_once(plugin_dir_path(__FILE__) . DIRECTORY_SEPARATOR . 'testimonials-template.php');


function bsTestimonailScripts()
{ 
    global $wp_scripts;
    wp_enqueue_style('bstestimonials', plugin_dir_url(__FILE__) . 'css/style.css', false, '0.9.17', 'all');
    wp_enqueue_style('bxslider-css', plugin_dir_url(__FILE__) . 'bxslider/jquery.bxslider.min.css', false, '4.2.12', 'all');
    wp_enqueue_script('bxslider-js', plugin_dir_url(__FILE__) . 'bxslider/jquery.bxslider.min.js', array('jquery'), '4.2.12', false);
}
add_filter('wp_enqueue_scripts', 'bsTestimonailScripts');