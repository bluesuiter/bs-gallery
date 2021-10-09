<div class="wrap">
    <div class="col-12 bsg_gallery">
        <h1 class="row">Add Gallery
            <a href="<?php echo admin_url('admin.php?page=bsg_gallery') ?>" class="ml-auto button button-primary">Galleries</a>
        </h1>
        <hr class="w-100"/>
        <form method="post" action="<?php echo admin_url('admin-post.php') ?>" name="create_gallery">
            <div class="row px-3">
                <div class="col-3">
                    <label>Gallery Name</label>
                    <input type="text" name="galleryName" required class="" value="Gallery <?php echo $nextId ?>"/>
                </div>

                <div class="col-3">
                    <label>Short Code</label>
                    <span><input readonly type="text" name="shortCode" value="[bsgallery id=<?php echo $nextId ?>]" /></span>
                </div>

                <div class="col-3">
                    <label>Gallery Type</label>
                    <span class="d-block my-1">
                        <input type="radio" name="galleryType" value="image" checked /> Image
                        <input type="radio" name="galleryType" value="docs" /> Documents
                    </span>
                </div>

                <div class="col-3 pt-2">
                    <?php wp_nonce_field('bsg_gallery', 'create_gallery') ?>
                    <input type="hidden" name="action" value="bsg_saveGallery"/>
                    <button type="button" class="py-1 button button-primary multiple" onclick="bsGallery.upload(this)" name="upload_file"><i class="dashicons dashicons-upload"></i> Upload</button>
                    <button type="submit" class="py-1 button button-primary multiple" name="save_gallery"><i class="dashicons dashicons-saved"></i> Save Gallery</button>
                </div>
                <hr class="w-100"/>
                <div id="glryBody" class="w-100"></div>
        </form>
    </div>
</div>