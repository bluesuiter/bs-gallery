<?php

/* Include the autoloader so we can dynamically include the rest of the classes. */
require_once trailingslashit(dirname(__FILE__)) . 'inc/autoloader.php';
require_once trailingslashit(dirname(__FILE__)) . 'helper/helper-functions.php';

add_action('init', 'ls_framework_init');

if (!defined('ls_framework_path')) {
    define('ls_framework_path', trailingslashit(dirname(__FILE__)));
}

if (!defined('ls_framework_uri')) {
    define('ls_framework_uri', (plugin_dir_url(__FILE__).'assets'));
}

if (!defined('ls_framework_view')) {
    define('ls_framework_view', trailingslashit(dirname(__FILE__)) . "view/");
}

/**
 * Starts the plugin by initializing the meta box, its display, and then
 * sets the plugin in motion.
 */
function ls_framework_init() {
    $meta_box = new BsGallery\Controllers\BsGalleryController();
}