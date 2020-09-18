<?php

namespace BsGallery\Controllers;

use BsGallery\Models\Gallery;
use BsGallery\Models\GalleryFile;
use BsGallery\Core\ControllerClass;

class GalleryController extends ControllerClass {

    public function addActions(){
        add_action('admin_post_bsg_saveGallery', [$this, 'save']);
    }

    public function adminMenu() {
        add_menu_page('BS-Gallery', 'BS-Gallery', 'edit_posts', 'bsg_gallery', [$this, 'index'], 'dashicons-format-gallery', 15);
        add_submenu_page('bsg_gallery', 'Create Gallery', 'Create Gallery', 'edit_posts', 'bsg_createGallery', [$this, 'create']);

    }

    /**
     * list of all galleries
     */
    public function index() {

        return bsg_loadView('gallery/index');
    }

    /**
     * @return view
     */
    public function create() {
        wp_enqueue_media();
        $count = (new Gallery())->galleryCount();
        return bsg_loadView('gallery/create', compact(' count'));
    }

    /**
     * save the gallery and gallery files
     */
    public function save() {
        $this->verifyNonce('bsg_gallery', 'create_gallery');

        $data = ['gallery_name' => getArrayValue($_POST, 'galleryName'),
                 'thumbnail' => getArrayValue($_POST, 'thumbnail'),
                'created_at' => current_time('mysql')];
        $galleryId = (new Gallery())->save($data);

        $files = getArrayValue($_POST, 'files');
        if(!empty($files)):
            foreach ($files as $file):
                $data = ['gallery_id' => $galleryId,
                        'file_id' => getArrayValue($file, 'file_id'),
                        'file_title' => getArrayValue($file, 'file_title'),
                        'file_caption' => getArrayValue($file, 'file_caption'),
                        'file_mime' => getArrayValue($file, 'file_mime'),
                        'status' => 1,
                        'created_at' => current_time('mysql')];
                (new GalleryFile())->save($data);
            endforeach;
        endif;

    }
}