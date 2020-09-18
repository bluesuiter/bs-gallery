<div class="wrap">
        <h1 class="wp-heading-inline">Add Testimonials</h1>
        <form method="post" action="<?php echo admin_url() ?>admin-post.php">
            <div class="row p-3">
                <div class="col-4">
                    <label>
                        <img class="" src="#">
                        <input type="file" name="bsg_avatar" id="bsg_avatar">
                    </label>
                </div>
                <div class="col-8">
                    <label class="d-flex mb-3">
                        <input type="text" class="w-100" name="bsg_author" id="bsg_author" placeholder="Author">
                    </label>
                    <label class="col-12 mb-3">
                        <input type="text" class="w-100" name="bsg_designation" id="bsg_designation" placeholder="Designation">
                    </label>
                    <label class="col-12 mb-3">
                        <?php
                            wp_editor('', 'meta_content_editor', array(
                                    'wpautop'       =>  true,
                                    'media_buttons' =>  false,
                                    'textarea_name' =>  'bsg_content',
                                    'textarea_rows' =>  5,
                                    'teeny'         =>  true,
                            ));
                        ?>
                    </label>
                    <input type="hidden" name="action" value="bsg_saveTestimonial">
                    <?php wp_nonce_field('_bsg_testimonial_form_nonce', 'bsg_testimonial_form'); ?>
                    <button type="submit" class="button button-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
