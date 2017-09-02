<?php

/************************************************************************/
function bsTestimonialMetaBox()
{
    $screens = array('testimonial');
    foreach ($screens as $screen)
    {
        add_meta_box('myplugin_order_id', __('Meta Box', 'myplugin_order_id'), 'bsTestimonialMetaBox_callback', $screen);
    }
}

add_action('add_meta_boxes', 'bsTestimonialMetaBox');

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function bsTestimonialMetaBox_callback($post)
{
    // Add a nonce field so we can check for it later.
    wp_nonce_field('bsTestimonialMetaBox', 'bsTestimonialMetaBox_nonce');
    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $item_Name = get_post_meta($post->ID, '_authour_name_', true);
    $service_Name = get_post_meta($post->ID, '_service_name_', true);
?>
        <p class="order_id">
            <span>
                <label>Authour::</label> 
                <input type="text" name="_authour_name_" size="50" value="<?= $item_Name ?>" placeholder="Author Name">
            </span><br/>
            <span>
                <label>Service::</label> 
                <input type="text" name="_service_name_" size="50" value="<?= $service_Name ?>" placeholder="Service Name">
            </span>
        </p>
<?php
}

/**
 * When the post is saved, saves our custom data.
 * @param int $post_id The ID of the post being saved.
 */
function bsTestimonialMetaBox_data($post_id)
{
    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */
    // Check if our nonce is set.
    if (!isset($_POST['bsTestimonialMetaBox_nonce']))
    {
        return;
    }
    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['bsTestimonialMetaBox_nonce'], 'bsTestimonialMetaBox'))
    {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    {
        return;
    }

    // Check the user's permissions.
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type'])
    {
        if (!current_user_can('edit_page', $post_id))
        {
            return;
        }
    } else
    {
        if (!current_user_can('edit_post', $post_id))
        {
            return;
        }
    }
 

    $authour_name = isset($_POST[ '_authour_name_' ] ) ? $_POST[ '_authour_name_' ]  : '';
    $service_name = isset($_POST[ '_service_name_' ] ) ? $_POST[ '_service_name_' ]  : '';
    
    // Update the meta field in the database.
    update_post_meta($post_id, '_authour_name_', $authour_name);
    update_post_meta($post_id, '_service_name_', $service_name);
}

add_action('save_post', 'bsTestimonialMetaBox_data');