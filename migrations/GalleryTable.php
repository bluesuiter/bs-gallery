<?php

namespace BsGallery\Migrations;

class GalleryTable
{
    public $galleryTable = 'bsg_galleries';
    public $fileTable = 'bsg_gallery_files';

    public function exec()
    {
        $this->createGalleryTable();
    }

    private function createGalleryTable()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        /* Newsletter List Table */
        $table_name = $wpdb->base_prefix . $this->galleryTable;
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $sql[] = "CREATE TABLE `$table_name` (
                id bigint(11) NOT NULL AUTO_INCREMENT,
                gallery_name tinytext NOT NULL,
                thumbnail varchar(255) NOT NULL,
                template varchar(20) NOT NULL,
                settings json DEFAULT NULL,
                status tinyint DEFAULT 1 NOT NULL,
                type enum('image', 'docs') NOT NULL, 
                created_by bigint(11) NOT NULL,
                modified_by bigint(11) NULL,
                created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
                modified_at datetime DEFAULT NULL,
                PRIMARY KEY (id)
            ) $charset_collate;";
        }

        /* Image Table */
        $table_name = $wpdb->base_prefix . $this->fileTable;
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $sql[] = "CREATE TABLE `$table_name` (
                id bigint(11) NOT NULL,
                gallery_id bigint(11) NOT NULL,
                file_title varchar(200) NULL,
                file_url varchar(200) NULL,
                file_caption text NOT NULL,
                file_mime varchar(120) NULL,
                sort_order TINYINT DEFAULT 0,
                status tinyint DEFAULT 1 NOT NULL,
                created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
                modified_at datetime DEFAULT NULL,
                PRIMARY KEY (id, gallery_id),
                CONSTRAINT bsg_gallery 
                FOREIGN KEY (gallery_id) REFERENCES " . $wpdb->base_prefix . $this->galleryTable . "(id)
            ) $charset_collate;";
        }

        if (!empty($sql)) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }
}
