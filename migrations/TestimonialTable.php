<?php

namespace BsGallery\Migrations;


class TestimonialTable {
    
    private $table = 'bsg_testimonials';

    public function exec(){
        $this->createTable();
    }

    private function createTable() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        /* Newsletter List Table */
        $table_name = $wpdb->base_prefix . $this->table;
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $sql = "CREATE TABLE `$table_name` (
                id int(9) NOT NULL AUTO_INCREMENT,
                author varchar(105) NOT NULL,
                content longtext NOT NULL,
                avatar varchar(255) NULL,
                designation varchar(255) NULL,
                status tinyint DEFAULT 1 NOT NULL,
                created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                modified_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                PRIMARY KEY  (id)
            ) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }
}