<?php 

namespace BsGallery\Controllers;

use BsGallery\Core\ControllerClass;

class TestimonialController extends ControllerClass{
    
    public function addActions(){
        add_action('admin_post_bsg_saveTestimonial', [$this, 'save']);
    }

    public function adminMenu(){
        add_menu_page('Testimonials', 'Testimonials', 'edit_posts', 'bsg_testimonials', [$this, 'index'], 'dashicons-format-quote', 15);
        add_submenu_page('', 'Manage Testimonials', 'Manage Testimonials', 'edit_posts', 'bsg_manageTestimonials', [$this, 'create']);
    }

    public function index(){
        return bsg_loadView('testimonial/index', '');
    }

    public function create(){
        return bsg_loadView('testimonial/create');
    }

    public function save(){
        pr($_POST);
    }

    public function edit(){
        pr($_GET);
    }

    public function update(){
        pr($_POST);
    }

    public function delete(){
        pr($_POST);
    }
}