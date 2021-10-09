<?php

namespace BsGallery\Models;

use Exception;

class GalleryFile
{
    private $table = 'bsg_gallery_files';
    private $db;

    private function getTable()
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->table = $wpdb->prefix . $this->table;
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

    public function getFileByGalleryId($galleryId)
    {
        try {
            global $wpdb;
            $table = $wpdb->prefix . $this->table;
            $sqlQry = "SELECT * FROM $table WHERE gallery_id=$galleryId";
            return $wpdb->get_results($sqlQry, ARRAY_A);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function removeFileFromGallery($galleryId, $files)
    {
        try {
            global $wpdb;
            $table = $wpdb->prefix . $this->table;
            $sqlQry = "DELETE FROM $table WHERE gallery_id=$galleryId AND file_id IN (" . implode(',', $files) . ")";
            $wpdb->query($sqlQry);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function updateOrCreate($data = array())
    {
        try {
            global $wpdb;
            $table = $wpdb->prefix . $this->table;

            $sqlQry = "SELECT id FROM $table 
                        WHERE gallery_id=" . $data['gallery_id'] . " AND file_id=" . $data['file_id'];
            $id = $wpdb->get_var($sqlQry);
            if ($id) {
                return $wpdb->update($table, $data, ['gallery_id' => $data['gallery_id'], 'file_id' => $data['file_id']]);
            }
            return $this->save($data);
            exit;
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
            return;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
