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
                <!-- right-block -->
                <?php require(__DIR__ . '/partials/right-block.php') ?>

                <?php wp_nonce_field('bsg_gallery', 'update_gallery') ?>
                <input type="hidden" name="id" value="<?php echo $pageData['id'] ?? '' ?>" />
                <input type="hidden" name="action" value="bsg_updateGallery" />
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
                caption: row['file_caption'].replace(/^(.+?)\/*?$/, "$1")
            }

            data.url = (data.mime).includes('application') ? '' : row['file_url'];
            $('#glryBody').append(bsGallery.galleryRowTemplate(data));
        }
    });
</script>