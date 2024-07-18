<div class="wrap">
    <h1 class="row"><?php echo $pageData['pageTitle'] ?></h1>
    <div id="poststuff">
        <form method="post" action="<?php echo admin_url('admin-post.php') ?>" name="create_gallery">
            <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content">
                    <div id="titlediv" class="mb-3">
                        <div id="titlewrap">
                            <input type="text" name="galleryName" size="30" placeholder="Add gallery title" value="<?php echo $gallery['gallery_name'] ?? '' ?>" id="title" spellcheck="true" autocomplete="off">
                        </div>
                    </div>

                    <!-- gallery-body -->
                    <div class="w-100" style="border: 1px #eee solid;display: block;">
                        <div class="wp-list-table widefat fixed striped table-view-list pages">
                            <div id="glryBody"></div>
                        </div>
                    </div>
                </div>

                <div id="postbox-container-1" class="postbox-container bsg_gallery">
                    <div id="submitdiv" class="postbox">
                        <h2 class="hndle ui-sortable-handle">Publish</h2>

                        <div class="inside">
                            <div class="submitbox" id="submitpost">
                                <div id="minor-publishing">
                                    <div class="misc-pub-section">
                                        Short Code
                                        <span><input readonly type="text" class="w-100 p-1" name="shortCode" value="[bsgallery id=<?php echo $gallery['id'] ?>]" /></span>
                                    </div>

                                    <div class="misc-pub-section">
                                        Gallery Type
                                        <span class="d-block my-1">
                                            <input type="radio" name="galleryType" <?php echo $gallery['type'] === 'image' ? 'checked' : ''; ?> value="image" checked /> Image
                                            <input type="radio" name="galleryType" <?php echo $gallery['type'] === 'docs' ? 'checked' : ''; ?> value="docs" /> Documents
                                        </span>
                                    </div>

                                    <div class="misc-pub-section">
                                        Template
                                        <span class="d-block my-1">
                                            <select class="w-100 p-1" required id="bs_gallery_template" name="gallery_template">
                                                <option value="">Select Template</option>
                                                <option value="slider">Bootstrap Slider</option>
                                                <option value="gallery">Grid Gallery</option>
                                                <option value="default">No Template</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="clear"></div>

                                    <div id="major-publishing-actions">
                                        <?php wp_nonce_field('bsg_gallery', 'update_gallery') ?>
                                        <input type="hidden" name="id" value="<?php echo $pageData['id'] ?? '' ?>" />
                                        <input type="hidden" name="action" value="bsg_updateGallery" />
                                        <button type="button" class="py-1 button button-primary multiple" onclick="bsGallery.upload(this)" name="upload_file"><i class="dashicons dashicons-upload"></i> Upload</button>
                                        <button type="submit" class="py-1 button button-primary multiple" name="save_gallery"><i class="dashicons dashicons-saved"></i> Save Gallery</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo bs_gallery_uri ?>/admin/js/edit-gallery.js"></script>
<script defer>
    const galleryJson = <?= json_encode($gallery) ?>;

    setGalleryTemplate(galleryJson.template ?? '');

    jQuery(function() {
        let row, data;

        const files = galleryJson.files ?? {};

        for (row of files) {
            data = {
                id: row['gfid'],
                mime: row['file_mime'],
                title: row['file_title'],
                caption: row['file_caption']
            }

            data.url = (data.mime).includes('application') ? '' : row['file_url'];
            $('#glryBody').append(bsGallery.galleryRowTemplate(data));
        }
    });
</script>