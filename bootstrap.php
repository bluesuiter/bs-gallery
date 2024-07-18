<?php

/* Include the autoloader so we can dynamically include the rest of the classes. */
require_once trailingslashit(dirname(__FILE__)) . 'inc/autoloader.php';
require_once trailingslashit(dirname(__FILE__)) . 'helper/helper-functions.php';

add_action('init', 'bsGalleryInit');

if (!defined('bs_gallery_path')) {
    define('bs_gallery_path', trailingslashit(dirname(__FILE__)));
}

if (!defined('bs_gallery_uri')) {
    define('bs_gallery_uri', (plugin_dir_url(__FILE__) . 'assets'));
}

if (!defined('bs_gallery_view')) {
    define('bs_gallery_view', trailingslashit(dirname(__FILE__)) . "view/");
}

/**
 * Starts the plugin by initializing the meta box, its display, and then
 * sets the plugin in motion.
 */
function bsGalleryInit()
{
    return new \BsGallery\Controllers\BsGalleryController();
}
