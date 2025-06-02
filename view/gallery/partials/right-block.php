<div id="postbox-container-1" class="postbox-container bsg_gallery">
    <div id="submitdiv" class="postbox">
        <h2 class="hndle ui-sortable-handle">Publish</h2>

        <div class="inside">
            <div class="submitbox" id="submitpost">
                <div id="minor-publishing">
                    <div class="misc-pub-section">Short Code
                        <span><input readonly type="text" class="w-100 py-1" name="shortCode" value="[bsgallery id=<?php echo $gallery['id'] ?? $nextId ?>]" /></span>
                    </div>

                    <div class="misc-pub-section">
                        Gallery Type
                        <span class="d-block my-1">
                            <input type="radio" name="gallery_type" <?php echo !empty($gallery) && getArrayValue($gallery, 'type') === 'image' ? 'checked' : ''; ?> value="image" checked /> Image
                            <input type="radio" name="gallery_type" <?php echo !empty($gallery) && getArrayValue($gallery, 'type') === 'docs' ? 'checked' : ''; ?> value="docs" /> Documents
                        </span>
                    </div>

                    <div class="misc-pub-section">
                        Template
                        <span class="d-block my-1">
                            <select class="w-100 py-1" required id="bs_gallery_template" name="gallery_template">
                                <option value="">Select Template</option>
                                <option value="slider01">Bootstrap 5 Slider</option>
                                <option value="slider">Bootstrap 4 Slider</option>
                                <option value="gallery">Grid Gallery</option>
                                <option value="default">No Template</option>
                            </select>
                        </span>
                    </div>

                    <div class="misc-pub-section">
                        <h3>Settings</h3>
                        <label><strong>Grid Columns</strong></label>
                        <span class="d-block my-1">
                            <input type="number" class="w-100 py-1" min="1" max="8" name="settings[grid_column]" value="3" />
                        </span>

                        <label><strong>Show Title</strong></label>
                        <span class="d-block my-1">
                            True <input type="radio" name="settings[show_title]" value="true" />
                            False <input type="radio" name="settings[show_title]" value="false" checked />
                        </span>
                    </div>
                    <div class="clear"></div>

                    <div id="major-publishing-actions">
                        <button type="button" class="py-1 button button-primary multiple" onclick="bsGallery.upload(this)" name="upload_file"><i class="dashicons dashicons-upload"></i> Upload</button>
                        <button type="submit" class="py-1 button button-primary multiple" name="save_gallery"><i class="dashicons dashicons-saved"></i> Save Gallery</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        jQuery('select[name="gallery_template"]').change(function() {
            if ($(this).val() === 'gallery') {

            }
        });
    });
</script>