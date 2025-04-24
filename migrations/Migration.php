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
}
