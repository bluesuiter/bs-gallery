<?php

namespace BsGallery\Models;

use Exception;

class GalleryFile
{
    private $table = 'bsg_gallery_files';
    public $images;

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
            $sqlQry = "SELECT * FROM $table WHERE gallery_id=%d ORDER BY sort_order ASC";

            return $wpdb->get_results($wpdb->prepare($sqlQry, [$galleryId]), ARRAY_A);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function removeFileFromGallery($galleryId, $files)
    {
        try {
            global $wpdb;
            $table = $wpdb->prefix . $this->table;
            $sqlQry = "DELETE FROM $table WHERE gallery_id=$galleryId AND id IN (" . implode(',', $files) . ")";
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

            $sqlQry = "SELECT id FROM $table WHERE gallery_id= %d AND id= %d  ORDER BY sort_order ASC";
            $id = $wpdb->get_var($wpdb->prepare($sqlQry, [$data['gallery_id'], $data['id']]));

            if ($id) {
                $data['modified_at'] = current_time('mysql');
                return $wpdb->update($table, $data, ['gallery_id' => $data['gallery_id'], 'id' => $data['id']]);
            }

            return $this->save($data);
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
