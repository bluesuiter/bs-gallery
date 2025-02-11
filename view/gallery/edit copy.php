<div class="wrap">
    <div class="col-12 bsg_gallery">
        <h1 class="row">Add Gallery
            <a href="<?php echo admin_url('admin.php?page=bsg_gallery') ?>" class="ml-auto button button-primary">Galleries</a>
        </h1>
        <form method="post" action="<?php echo admin_url('admin-post.php') ?>" name="create_gallery">
            <div class="row p-3">
                <div class="col-3">
                    <label>Gallery Name</label>
                    <input type="text" name="galleryName" class="" value="<?= $gallery['gallery_name'] ?>"/>
                </div>

                <div class="col-3">
                    <label>Short Code</label>
                    <span><input readonly type="text" name="shortCode" value="[bsgallery id=<?= $gallery['id'] ?>]" /></span>
                </div>

                <div class="col-3">
                    <label>Gallery Type</label>
                    <span>
                        <input type="radio" name="gallery_type" value="image" <?= $gallery['type'] == 'image' ? 'checked' : ''; ?> /> Image
                        <input type="radio" name="gallery_type" value="docs" <?= $gallery['type'] == 'docs' ? 'checked' : ''; ?> /> Documents
                    </span>
                </div>

                <div class="col-3">
                    <?php wp_nonce_field('bsg_gallery', 'update_gallery') ?>
                    <input type="hidden" name="action" value="bsg_updateGallery"/>
                    <input type="hidden" name="id" value="<?= $gallery['id'] ?>"/>
                    <button type="button" class="py-1 button button-primary multiple" onclick="bsGallery.upload(this)" name="upload_file"><i class="dashicons dashicons-upload"></i> Upload</button>
                    <button type="submit" class="py-1 button button-primary multiple" name="save_gallery"><i class="dashicons dashicons-saved"></i> Save Gallery</button>
                </div>
                <hr class="w-100"/>
                <div id="glryBody" class="w-100"></div>
        </form>
    </div>
</div>

<script>
    jQuery(function(){
        var records = <?= json_encode($gallery['files']) ?>,
            row, data;

        for(row of records){
            data = {
                id: row['file_id'],
                mime: row['file_mime'],
                title: row['file_title'],
                caption: row['file_caption']
            }
            data.url = (data.mime).includes('application') ? '' : row['file_url'];
            $('#glryBody').append(bsGallery.galleryRowTemplate(data));
        }
    });
</script>