<div id="bs_carousel_<?php echo $galleryData->id; ?>" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <?php
        if (!empty($galleryData->media)) {
            foreach ($galleryData->media as $key => $row) {
        ?>
                <div class="carousel-item <?php echo ($key === 0 ? 'active' : ''); ?>">
                    <img src="<?php echo $row['file_url']; ?>" class="d-block w-100" alt="<?php echo $row['file_title']; ?>" />
                </div>
        <?php
            }
        }
        ?>
    </div>
    <button class="carousel-control-prev" type="button" data-target="#bs_carousel_<?php echo $galleryData->id; ?>" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-target="#bs_carousel_<?php echo $galleryData->id; ?>" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
</div>