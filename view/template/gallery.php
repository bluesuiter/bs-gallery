<?php print_r($galleryData) ?>

<div id="bs_gallery_<?php echo $galleryData->id; ?>" class="bs_gallery">
    <?php
    if (!empty($galleryData->media)) {
        foreach ($galleryData->media as $key => $row) {
    ?>
            <div class="bs_gallery_item" style="width:<?php echo (100 / $galleryData->grid_column - 0.75) ?>%;">
                <img src="<?php echo $row['file_url']; ?>" class="d-block w-100" alt="<?php echo $row['file_title']; ?>" />
                <div class="desc"><?php echo $row['file_title'] ?></div>
            </div>
    <?php
        }
    }
    ?>
</div>