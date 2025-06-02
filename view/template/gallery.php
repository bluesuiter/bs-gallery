<div id="bs_gallery_<?php echo $galleryData->id; ?>" class="bs_gallery">
    <?php
    $settings = json_decode($galleryData->settings);
    if (!empty($galleryData->media)) {
        foreach ($galleryData->media as $key => $row) {
    ?>
            <div class="bs_gallery_item" style="display:inline-block;margin:0px 0.12%;width:<?php echo (100 / $settings->grid_column - 1) ?>%;">
                <img src="<?php echo $row['file_url']; ?>" class="img-fluid" alt="<?php echo $row['file_title']; ?>" />
                <h6 class="title"><?php echo $row['file_title'] ?></h6>
                <p class="desc"><?php echo $row['file_caption'] ?></p>
            </div>
    <?php
        }
    }
    ?>
    <div style="clear:both;width:100%;"></div>
</div>