<div id="bs_carousel_<?php echo $galleryData->id; ?>" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        if (!empty($galleryData->media)) {
            foreach ($galleryData->media as $key => $row) {
                $fileData = wp_check_filetype($row['file_url']);
        ?>
                <div class="carousel-item <?php echo ($key === 0 ? 'active' : ''); ?>">
                    <?php
                    $fileType = explode('/', $fileData['type']);
                    switch ($fileType[0]) {
                        case 'image': ?>
                            <img src="<?php echo $row['file_url']; ?>" class="d-block w-100" alt="<?php echo $row['file_title']; ?>" />
                        <?php break;
                        case 'video': ?>
                            <video class="d-block w-100" autoplay loop muted>
                                <source src="<?php echo $row['file_url'] ?>" type="<?php echo $fileData['type'] ?>">
                                <img src="<?php echo $row['file_url']; ?>" class="d-block w-100" alt="<?php echo $row['file_title']; ?>" />
                            </video>
                    <?php break;
                    } ?>
                </div>
        <?php
            }
        }
        ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#bs_carousel_<?php echo $galleryData->id; ?>" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#bs_carousel_<?php echo $galleryData->id; ?>" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
</div>