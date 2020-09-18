<?php

namespace BsGallery\Models;

class GalleryFile {
    private $table = 'bsg_gallery_files';

    public function save($data = array()){
        try{
            global $wpdb;
            $table = $wpdb->prefix.$this->table;
            $wpdb->insert($table, $data);
            return $wpdb->insert_id;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }


}