<?php

namespace BsGallery\Migrations;

use BsGallery\Migrations\GalleryTable as Gallery;

class Migration
{

    private $bsg_db_version = 1.0;

    public function loadMigrations()
    {
        (new Gallery())->exec();

        add_option("bsg_db_version", $this->bsg_db_version);
    }

}
?>