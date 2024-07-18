<div id="carouselExample" class="carousel slide">
    <div class="carousel-inner">
        <?php
        if (!empty($galleryData->media)) {
            foreach ($galleryData->media as $key => $row) {
        ?>
                <div class="carousel-item <?php echo ($key === 0 ? 'active' : ''); ?>">
                    <img style="height: 550px;" src="<?php echo $row['file_url']; ?>" class="d-block w-100" alt="<?php echo $row['file_title']; ?>" />
                </div>
        <?php
            }
        }
        ?>

    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>