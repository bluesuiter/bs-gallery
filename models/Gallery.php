<?php

namespace BsGallery\Models;

use Exception;

class Gallery
{
    private $table = 'bsg_galleries';
    private $fileTable = 'bsg_gallery_files';

    public function find($id)
    {
        try {
            global $wpdb;
            $table = $wpdb->prefix . $this->table;
            $sqlQry = "SELECT * FROM $table gl WHERE id = $id";
            return $wpdb->get_row($sqlQry);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function get()
    {
        try {
            global $wpdb;
            $table = $wpdb->prefix . $this->table;
            $sqlQry = "SELECT * FROM $table gl";
            return $wpdb->get_results($sqlQry, 'ARRAY_A');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function save($data = array())
    {
        try {
            global $wpdb;
            $table = $wpdb->prefix . $this->table;
            $wpdb->insert($table, $data);
            return $wpdb->insert_id;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function update($id, $data = array())
    {
        try {
            global $wpdb;
            $table = $wpdb->prefix . $this->table;
            $wpdb->update($table, $data, ['id' => $id]);
            return $wpdb->insert_id;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function nextId()
    {
        try {
            global $wpdb;
            $table = $wpdb->prefix . $this->table;
            return $wpdb->get_var("SELECT max(id) FROM $table");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * fetch and return gallery along with files
     * @param int $id gallery id
     */
    public function getGallery($id)
    {
        try {
            global $wpdb;
            /** gallery */
            $table = $wpdb->prefix . $this->table;
            $sqlQry = "SELECT id, gallery_name, thumbnail, type 
                        FROM $table gl WHERE id=$id";
            $result = $wpdb->get_row($sqlQry, 'ARRAY_A');

            /** files */
            $table = $wpdb->prefix . $this->fileTable;
            $sqlQry = "SELECT id as gfid, file_id, file_title, file_caption, file_mime, file_url, status  
                        FROM $table ft WHERE gallery_id=$id";
            $result['files'] = $wpdb->get_results($sqlQry, 'ARRAY_A');
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
