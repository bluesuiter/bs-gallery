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
        add_submenu_page('edit_bsg_gallery', 'Edit Gallery', 'Edit Gallery', 'edit_posts', 'bsg_editGallery', [$this, 'edit']);
    }

    public function defineShortcode()
    {
        /** add short-code */
        add_shortcode('bsgallery', [$this, 'handleGalleryShortcode']);
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
            'template' => sanitize_text_field(getArrayValue($_POST, 'gallery_template')),
            'type' => sanitize_text_field(getArrayValue($_POST, 'gallery_type')),
            'settings' => json_encode(getArrayValue($_POST, 'settings')),
            'created_by' => get_current_user_id(),
            'created_at' => current_time('mysql'),
            'modified_at' => current_time('mysql')
        ];
        $galleryId = (new Gallery())->save($data);

        $files = getArrayValue($_POST, 'files');
        if (!empty($files)) :
            foreach ($files as $key => $file) :
                $data = [
                    'id' => getArrayValue($file, 'file_id'),
                    'gallery_id' => $galleryId,
                    'file_title' => sanitize_text_field(getArrayValue($file, 'file_title')),
                    'file_caption' => sanitize_text_field(getArrayValue($file, 'file_caption')),
                    'file_mime' => getArrayValue($file, 'file_mime'),
                    'file_url' => getArrayValue($file, 'file_url'),
                    'status' => 1,
                    'sort_order' => $key
                ];

                (new GalleryFile())->save($data);

            endforeach;
        endif;

        return wp_redirect(admin_url('admin.php?page=bsg_gallery'));
    }

    /**
     * edit gallery
     * @method get
     */
    public function edit()
    {
        try {
            wp_enqueue_media();
            $id = getArrayValue($_GET, 'id');
            $pageData = ['pageTitle' => 'Edit gallery', 'id' => $id];

            if (!empty($id)) {
                $gallery = (new Gallery)->getGallery($id);
                return bsg_loadView('gallery/edit', compact('gallery', 'pageData'));
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * update gallery entrydata
     */
    public function update()
    {
        $this->verifyNonce('bsg_gallery', 'update_gallery');
        $galleryId = getArrayValue($_POST, 'id');
        $data = [
            'gallery_name' => sanitize_text_field(getArrayValue($_POST, 'galleryName')),
            'thumbnail' => sanitize_text_field(getArrayValue($_POST, 'thumbnail')),
            'template' => sanitize_text_field(getArrayValue($_POST, 'gallery_template')),
            'type' => sanitize_text_field(getArrayValue($_POST, 'gallery_type')),
            'settings' => json_encode(getArrayValue($_POST, 'settings')),
            'modified_by' => get_current_user_id(),
            'modified_at' => current_time('mysql')
        ];

        $objGallery = new Gallery();
        $objGallery->update($galleryId, $data);

        /** get list of existing files */
        $objGalleryFile = new GalleryFile();
        $galleryFiles = $objGalleryFile->getFileByGalleryId($galleryId);

        /** get list of remove files */
        $uploadedFiles = getArrayValue($_POST, 'files');

        /** update files for gallery */
        if (!empty($uploadedFiles)) :
            $comingFileIds = array_column($uploadedFiles, 'file_id');

            $toRemove = [];
            foreach ($galleryFiles as $row) {
                if (!in_array($row['id'], $comingFileIds)) {
                    $toRemove[] = $row['id'];
                }
            }

            /** check removed files */
            if (!empty($toRemove)) {
                $objGalleryFile->removeFileFromGallery($galleryId, $toRemove);
            }

            foreach ($uploadedFiles as $key => $file) :
                $data = [
                    'id' => getArrayValue($file, 'file_id'),
                    'gallery_id' => $galleryId,
                    'file_title' => sanitize_text_field(getArrayValue($file, 'file_title')),
                    'file_caption' => sanitize_text_field(getArrayValue($file, 'file_caption')),
                    'file_mime' => getArrayValue($file, 'file_mime'),
                    'file_url' => getArrayValue($file, 'file_url'),
                    'status' => 1,
                    'sort_order' => $key
                ];

                $objGalleryFile->updateOrCreate($data);
            endforeach;
        endif;

        return wp_redirect(admin_url('admin.php?page=bsg_gallery'));
    }

    /**
     * return gallery data by id
     * @param int $galleryId
     * @return object
     */
    public function show($galleryId)
    {
        $objGallery = new Gallery();
        $galleryData = $objGallery->find($galleryId);

        /** get list of existing files */
        $objGalleryFile = new GalleryFile();
        $galleryData->media = $objGalleryFile->getFileByGalleryId($galleryId);

        return $galleryData;
    }

    /**
     * return response for the gallery template
     */
    public function handleGalleryShortcode($args)
    {
        if (!empty($args['id'])) {
            $galleryData = $this->show($args['id']);
            $template = '';

            switch ($galleryData->template) {
                case 'slider':
                    $template = 'bootstrap-carousel';
                    break;

                case 'slider01':
                    $template = 'bootstrap5-carousel';
                    break;

                case 'gallery':
                    $template = 'gallery';
                    break;
            }

            return bsg_loadView("template/$template", compact('galleryData'));
        }
    }

    public function fetchGallery(\WP_REST_Request $request)
    {
        $id = $request->get_param('id');
        $gallery = $this->show($id);
        return wp_send_json($gallery);
        exit;
    }
}
