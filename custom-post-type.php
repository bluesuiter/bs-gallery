<?php

function bsCustomPostType($lname, $supports='', $icon='dashicons-admin-post', $public=true, $publicly_queryable=true, $rewrite=true, $search=false) {
    $name = ucfirst($lname);
    $labels = array(
        'name' => $name,
        'singular_name' => $name,
        'add_new' => 'Add New',
        'add_new_item' => 'Add New ' . $name,
        'edit_item' => 'Edit ' . $name,
        'new_item' => 'New ' . $name,
        'view_item' => 'View ' . $name,
        'search_items' => 'Search ' . $name,
        'not_found' => 'No ' . $name . ' found',
        'not_found_in_trash' => 'No ' . $name . ' in Trash',
        'parent_item_colon' => '',
    );
    if(!$supports)
    {
        $supports = array(
            'title',
            'editor',
            'author',
            'thumbnail',
            'comments',
            'post-formats',
            'custom-fields',
            'excerpt'
        );
    }
    
    if($rewrite)
    {
        $rewrite = array('slug' => lcfirst($name));
    }

    $args = array(
        'labels' => $labels,
        'public' => $public,
        'publicly_queryable' => $publicly_queryable,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => $icon,
        'query_var' => true,
        'rewrite' => $rewrite,
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => 5,
        'exclude_from_search' => $search,
        'taxonomies' => array("$lname-category"),
        'supports' => $supports
    );
    register_post_type($name, $args);
}

/* * **************************************************************************** */

// create taxonomy, portfolio category for the post type "portfolio"
function bsCustomTaxonomies($lname, $sname = 'Category', $psname = 'Categories', $taxonomy = false, $hierarchical=true) {
    // Add new taxonomy, make it hierarchical (like categories)
    $name = ucfirst($lname);
    $labels = array(
        'name' => _x($name . ' ' . $sname, 'taxonomy general name'),
        'singular_name' => _x($name . ' ' . $sname, 'taxonomy singular name'),
        'search_items' => __('Search ' . $name . ' ' . $psname),
        'all_items' => __('All ' . $name . ' ' . $psname),
        'parent_item' => __('Parent ' . $name . ' ' . $sname),
        'parent_item_colon' => __('Parent ' . $name . ' ' . $sname . ': '),
        'edit_item' => __('Edit ' . $name . ' ' . $sname),
        'update_item' => __('Update ' . $name . ' ' . $sname),
        'add_new_item' => __('Add New ' . $name . ' ' . $sname),
        'new_item_name' => __('New ' . $name . ' ' . $sname . ' Name'),
        'menu_name' => __($name . ' ' . $sname),
    );

    $args = array(
        'hierarchical' => $hierarchical,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => $lname . '_cat'),
    );

    if(!$taxonomy)
    {
        $taxonomy = $lname . '-category';
    }

    register_taxonomy($taxonomy, array($lname), $args);
}

/* * ************************ News Post Type End *************************** */

/* * ************************ News Post Type End *************************** */

function bsCustomPostTypeInit()
{
    $supports = array('title','editor','thumbnail','custom-fields');
    bsCustomPostType('testimonial', $supports, 'dashicons-format-quote', false, false, false, true);
    bsCustomTaxonomies('testimonial');
}

add_action('init', 'bsCustomPostTypeInit'); 
