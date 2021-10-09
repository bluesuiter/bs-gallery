<?php

namespace BsGallery\Controllers;

use BsGallery\Controllers\GalleryController;
use BsGallery\Models\GalleryFile;
use BsGallery\Core\ControllerClass;
use Exception;

class RestApiController extends ControllerClass
{

    public function registerApi()
    {
        add_action('rest_api_init', array($this, 'registerApiEndpoints'));
    }

    public function permissionCheck()
    {
        return true;
    }

    /**
     * REST API endpoints declaration
     */
    public function registerApiEndpoints()
    {
        try {
            $objGallery = new GalleryController();

            /* Navigation Menu */
            register_rest_route('bsgallery', '/(?P<id>\d+)', array(
                'methods' => 'GET', 'callback' => [$objGallery, 'fetchGallery'],
                'permission_callback' => [$this, 'permissionCheck']
            ));
        } catch (Exception $e) {
            write_log($e->getMessage());
        }
    }
}
