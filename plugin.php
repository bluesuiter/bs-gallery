<?php

/*
 Plugin Name: BS-Gallery
 Plugin URI: 
 Description: BS-Gallery
 Version: 0.9.20
 Author: BlueSuiter's
 Author URI: 
 */

require_once plugin_dir_path(__FILE__) . 'bootstrap.php';

register_activation_hook(__FILE__, function(){
    (new \BsGallery\Migrations\Migration())->loadMigrations();
});