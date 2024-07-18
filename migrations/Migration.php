<?php

namespace BsGallery\Migrations;

use BsGallery\Migrations\GalleryTable as Gallery;

class Migration
{

    private $bsgBbVersion = 1.0;

    public function loadMigrations()
    {
        (new Gallery())->exec();
        add_option("bsg_db_version", $this->bsgBbVersion);
    }

    public function upgrade()
    {

        $wpdb->query('ALTER TABLE `hls_bsg_gallery_files` CHANGE `created_at` `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
    }
}
