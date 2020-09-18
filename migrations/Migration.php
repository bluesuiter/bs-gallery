<?php

namespace BsGallery\Migrations;

use BsGallery\Migrations\GalleryTable as Gallery;
use BsGallery\Migrations\TestimonialTable as Testimonial;

class Migration {

    private $bsg_db_version = 1.0;

    public function loadMigrations(){
        (new Gallery())->exec();
        (new Testimonial())->exec();

        add_option("bsg_db_version", $this->bsg_db_version);
    }

}