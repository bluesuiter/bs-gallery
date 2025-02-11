<div class="wrap">
    <h1 class="row">Add New Gallery</h1>
    <div id="poststuff">
        <form method="post" action="<?php echo admin_url('admin-post.php') ?>" name="create_gallery">
            <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content">
                    <div id="titlediv">
                        <div id="titlewrap">
                            <input type="text" name="galleryName" size="30" placeholder="Add gallery title" value="" id="title" spellcheck="true" autocomplete="off">
                        </div>
                        <div class="inside">
                            <div id="edit-slug-box" class="hide-if-no-js">
                            </div>
                        </div>
                        <?php echo wp_nonce_field() ?>
                    </div>
                    <!-- gallery-body -->
                    <div id="glryBody" class="w-100"></div>

                    <?php wp_nonce_field('bsg_gallery', 'create_gallery') ?>
                    <input type="hidden" name="action" value="bsg_saveGallery" />
                </div>

                <!-- right-block -->
                <?php require(__DIR__ . '/partials/right-block.php') ?>
            </div>
        </form>
    </div>
</div>