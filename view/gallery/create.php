<div class="wrap">

    <h1 class="row">Add New Gallery</h1>
    <div id="poststuff">
        <form method="post" action="<?php echo admin_url('admin-post.php') ?>" name="create_gallery">

            <div id="post-body" class="metabox-holder columns-2">

                <div id="post-body-content">
                    <div id="titlediv">
                        <div id="titlewrap">
                            <label class="" id="title-prompt-text" for="title">Add gallery title</label>
                            <input type="text" name="galleryName" size="30" value="" id="title" spellcheck="true" autocomplete="off">
                        </div>
                        <div class="inside">
                            <div id="edit-slug-box" class="hide-if-no-js">
                            </div>
                        </div>
                        <input type="hidden" id="samplepermalinknonce" name="samplepermalinknonce" value="2ddc17e810">
                    </div>

                    <!-- gallery-body -->
                    <div id="glryBody" class="w-100"></div>
                </div>


                <div id="postbox-container-1" class="postbox-container">
                    <div id="submitdiv" class="postbox">
                        <h2 class="hndle ui-sortable-handle">Publish</h2>

                        <div class="inside">
                            <div class="submitbox" id="submitpost">
                                <div id="minor-publishing">
                                    <div class="misc-pub-section">
                                        Short Code
                                        <span><input readonly type="text" name="shortCode" value="[bsgallery id=<?php echo $nextId ?>]" /></span>
                                    </div>

                                    <div class="misc-pub-section">
                                        Gallery Type
                                        <span class="d-block my-1">
                                            <input type="radio" name="galleryType" value="image" checked /> Image
                                            <input type="radio" name="galleryType" value="docs" /> Documents
                                        </span>
                                    </div>
                                    <div class="clear"></div>

                                    <div id="major-publishing-actions">
                                        <?php wp_nonce_field('bsg_gallery', 'create_gallery') ?>
                                        <input type="hidden" name="action" value="bsg_saveGallery" />
                                        <button type="button" class="py-1 button button-primary multiple" onclick="bsGallery.upload(this)" name="upload_file"><i class="dashicons dashicons-upload"></i> Upload</button>
                                        <button type="submit" class="py-1 button button-primary multiple" name="save_gallery"><i class="dashicons dashicons-saved"></i> Save Gallery</button>
                                    </div>
                                    <hr class="w-100" />
                                </div>
                            </div>
                        </div>


                    </div>
                </div>




        </form>
    </div>
</div>