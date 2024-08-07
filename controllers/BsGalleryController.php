<?php

namespace BsGallery\Controllers;

use BsGallery\Controllers\GalleryController;
use BsGallery\Controllers\RestApiController;

class BsGalleryController
{

    public function __construct()
    {
        $this->addActions();
        add_action('admin_menu', [$this, 'adminPanel']);
        add_action('admin_enqueue_scripts', [$this, 'addAdminCss']);
    }

    public function addActions()
    {
        $objGallery = new GalleryController();
        $objGallery->addActions();
        $objGallery->defineShortcode();

        $objRestApi = new RestApiController();
        $objRestApi->registerApi();
    }

    public function adminPanel()
    {
        $objGallery = new GalleryController();
        $objGallery->adminMenu();
    }

    public function addAdminCss()
    {
        if (strrpos(getArrayValue($_GET, 'page'), 'bsg_', 0) == 0) {
            wp_register_script('_admin_bsg_Js', bs_gallery_uri . '/admin/js/script.js', array('jquery'), '2.7', true);
            wp_register_style('_admin_bsg_Css', bs_gallery_uri . '/admin/css/style.css', false, '1.6.25');
            wp_enqueue_script('_admin_bsg_Js');
            wp_enqueue_style('_admin_bsg_Css');
        }
    }
}
