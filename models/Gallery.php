<?php

namespace BsGallery\Models;

class Gallery {
    private $table = 'bsg_galleries';

    public function index(){
        try{
            global $wpdb;
            $table = $wpdb->prefix.$this->table;
            $wpdb->get_results("SELECT * FROM $table");
            return $wpdb->insert_id;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

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

    public function galleryCount() {
        try{
            global $wpdb;
            $table = $wpdb->prefix.$this->table;
            return $wpdb->get_var("SELECT count(id) FROM $table");
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function saveFiles($data = array()) {

    }
}