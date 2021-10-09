<?php

namespace BsGallery\Controllers;

use BsGallery\Models\Gallery;
use BsGallery\Models\GalleryFile;
use BsGallery\Core\ControllerClass;
use Exception;

class GalleryController extends ControllerClass
{

    public function addActions()
    {
        add_action('admin_post_bsg_saveGallery', [$this, 'save']);
        add_action('admin_post_bsg_updateGallery', [$this, 'update']);
    }

    public function adminMenu()
    {
        add_menu_page('BS-Gallery', 'BS-Gallery', 'edit_posts', 'bsg_gallery', [$this, 'index'], 'dashicons-format-gallery', 15);
        add_submenu_page('bsg_gallery', 'Create Gallery', 'Create Gallery', 'edit_posts', 'bsg_createGallery', [$this, 'create']);
        add_submenu_page('', 'Edit Gallery', 'Edit Gallery', 'edit_posts', 'bsg_editGallery', [$this, 'edit']);
    }

    /**
     * list of all galleries
     */
    public function index()
    {
        $gallery = (new Gallery)->get();
        return bsg_loadView('gallery/index', compact('gallery'));
    }

    /**
     * @return view
     */
    public function create()
    {
        wp_enqueue_media();
        $nextId = (new Gallery())->nextId() + 1;
        return bsg_loadView('gallery/create', compact('nextId'));
    }

    /**
     * save the gallery and gallery files
     */
    public function save()
    {
        $this->verifyNonce('bsg_gallery', 'create_gallery');
        $data = [
            'gallery_name' => sanitize_text_field(getArrayValue($_POST, 'galleryName')),
            'thumbnail' => sanitize_text_field(getArrayValue($_POST, 'thumbnail')),
            'type' => sanitize_text_field(getArrayValue($_POST, 'galleryType')),
            'created_by' => get_current_user_id(),
            'created_at' => current_time('mysql')
        ];
        $galleryId = (new Gallery())->save($data);

        $files = getArrayValue($_POST, 'files');
        if (!empty($files)) :
            foreach ($files as $file) :
                $data = [
                    'gallery_id' => $galleryId,
                    'file_id' => getArrayValue($file, 'file_id'),
                    'file_title' => sanitize_text_field(getArrayValue($file, 'file_title')),
                    'file_caption' => sanitize_text_field(getArrayValue($file, 'file_caption')),
                    'file_mime' => getArrayValue($file, 'file_mime'),
                    'file_url' => getArrayValue($file, 'file_url'),
                    'status' => 1,
                    'created_at' => current_time('mysql')
                ];
                (new GalleryFile())->save($data);
            endforeach;
        endif;
        return wp_redirect(admin_url('admin.php?page=bsg_gallery'));
    }

    public function edit()
    {
        try {
            wp_enqueue_media();
            $id = getArrayValue($_GET, 'id');
            if (!empty($id)) {
                $gallery = (new Gallery)->getGallery($id);
                return bsg_loadView('gallery/edit', compact('gallery'));
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function update()
    {
        $this->verifyNonce('bsg_gallery', 'update_gallery');
        $galleryId = getArrayValue($_POST, 'id');
        $data = [
            'gallery_name' => sanitize_text_field(getArrayValue($_POST, 'galleryName')),
            'thumbnail' => sanitize_text_field(getArrayValue($_POST, 'thumbnail')),
            'type' => sanitize_text_field(getArrayValue($_POST, 'galleryType')),
            'modified_by' => get_current_user_id(),
            'modified_at' => current_time('mysql')
        ];
        $objGallery = new Gallery();
        $objGallery->update($galleryId, $data);

        /** get list of existing files */
        $objGalleryFile = new GalleryFile();
        $galleryFiles = $objGalleryFile->getFileByGalleryId($galleryId);
        $galleryFiles = array_column($galleryFiles, 'file_id');

        /** get list of remove files */
        $files = getArrayValue($_POST, 'files');
        $newFiles = array_column($files, 'file_id');
        $removedFiles = array_diff($galleryFiles, $newFiles);

        /** check removed files */
        if (!empty($removedFiles)) {
            $objGalleryFile->removeFileFromGallery($galleryId, $removedFiles);
        }

        /** update files for gallery */
        if (!empty($files)) :
            foreach ($files as $file) :
                $data = [
                    'gallery_id' => $galleryId,
                    'file_id' => getArrayValue($file, 'file_id'),
                    'file_title' => sanitize_text_field(getArrayValue($file, 'file_title')),
                    'file_caption' => sanitize_text_field(getArrayValue($file, 'file_caption')),
                    'file_mime' => getArrayValue($file, 'file_mime'),
                    'file_url' => getArrayValue($file, 'file_url'),
                    'status' => 1,
                    'modified_at' => current_time('mysql')
                ];
                $objGalleryFile->updateOrCreate($data);
            endforeach;
        endif;
        return wp_redirect(admin_url('admin.php?page=bsg_gallery'));
    }

    public function show($galleryId)
    {
        $objGallery = new Gallery($galleryId);

        /** get list of existing files */
        $objGalleryFile = new GalleryFile();
        $objGallery->images = $objGalleryFile->getFileByGalleryId($galleryId);

        return $objGallery;
    }

    public function fetchGallery(\WP_REST_Request $request)
    {
        $id = $request->get_param('id');
        $gallery = $this->show($id);
        return wp_send_json($gallery);
        exit;
    }
}
