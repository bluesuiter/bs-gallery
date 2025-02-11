<?php

namespace BsGallery\Migrations;

use BsGallery\Migrations\GalleryTable as Gallery;

class Migration
{

    private $bsgBbVersion = 1.1;

    public function loadMigrations()
    {
        (new Gallery())->exec();

        // Save the current version in the database
        update_option("bsg_db_version", $this->bsgBbVersion);
    }

    public function upgrade()
    {
        global $wpdb;

        // bsg_galleries_files table
        $table = $wpdb->base_prefix . 'bsg_galleries_files';
        $wpdb->query("ALTER TABLE $table CHANGE `created_at` `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");


        // bsg_galleries table
        $table = $wpdb->base_prefix . 'bsg_galleries';
        $wpdb->query("ALTER TABLE $table ADD settings JSON NULL DEFAULT NULL AFTER `type`");
    }
}
