<?php
/**
 * Plugin Name: Contact Form
 * Description: A simple contact form
 * Version: 1.0.0
 * Author: Jayson Lauza
 * Text Domain: contact-form
 */

require_once('security.php');

 class ContactForm {
    public function __construct() {
        add_action('init', array($this, 'create_custom_post_type'));
        add_action('wp_enqueue_scripts', array($this, 'load_assets'));
        add_shortcode('contact_form', array($this, 'render_contact_form'));
        add_action('rest_api_init', array($this, 'register_rest_api'));
    }

    public function create_custom_post_type() {
        $args = array(
            'public' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'labels'  => array(
                'name' => 'Contact Forms',
                'singular_name' => 'Contact Form',
                'add_new' => 'Add Contact Form',
                'add_new_item' => 'Add New Contact Form',
                'edit_item' => 'Edit Contact Form',
                'new_item' => 'New Contact Form',
                'view_item' => 'View Contact Form',
                'search_items' => 'Search Contact Forms',
                'not_found' => 'No Contact Forms Found',
                'not_found_in_trash' => 'No Contact Forms Found in Trash',
                'parent_item_colon' => 'Parent Contact Form'
            ),
            'menu_icon' => 'dashicons-email-alt',
            'supports' => array('title', 'editor', 'author'),
            'publicly_queryable' => false,
            'capability' => 'manage_options',
        );

        register_post_type('contact_form', $args);
    }

    public function load_assets() {
        wp_enqueue_script('jquery-custom', 'https://code.jquery.com/jquery-3.6.0.min.js', array('jquery'), '3.6.0', true);
        wp_enqueue_style('contact-form', plugin_dir_url(__FILE__) . 'css/contact-form.css', array(), '1.0.0', 'all');
        wp_enqueue_style('bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.css', array(), '5.3.2', 'all');
        wp_enqueue_script('contact-form', plugin_dir_url(__FILE__) . 'js/contact-form.js', array('jquery'), '3.6.0', true);
        wp_enqueue_script('bootstrap', plugin_dir_url(__FILE__) . 'js/bootstrap.bundle.js', array('jquery'), '5.3.2', true);
        wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js', array('jquery'), '2.10.2', true);
    }

    public function render_contact_form() {
        ob_start();
        include('templates/contact-form.php');
        return ob_get_clean();
    }

    public function register_rest_api() {
        register_rest_route('contact-form/v1', 'submit', array(
            'methods' => 'POST',
            'callback' => array($this, 'handle_submit_contact_form'),
            'permission_callback' => '__return_true'
        ));
    }

    public function handle_submit_contact_form($data) {
        // Get headers and params
        $headers = $data->get_headers();
        $params = $data->get_params();
        $nonce = $headers['x_wp_nonce'][0];
        
        // Verify nonce
        if(!wp_verify_nonce($nonce, 'wp_rest')) {
            return new WP_REST_Response(array('message' => 'Invalid nonce! Message not sent.'), 403);
        } else {
            return new WP_REST_Response(array('message' => 'Valid nonce'), 200);
        }

        // Sanitize data
        $name = sanitize_text_field($data['name']);
        $email = sanitize_email($data['email']);
        $message = sanitize_textarea_field($data['message']);

        // Insert data to database
        $post_id = wp_insert_post(array(
            'post_title' => 'Contact enquiry from ' . $name,
            'post_content' => $message,
            'post_status' => 'publish',
            'post_type' => 'contact_form'
        ));

        // Update post meta
        if ($post_id) {
            update_post_meta($post_id, 'email', $email);
            return new WP_REST_Response(array('message' => 'Contact form submitted successfully'), 200);
        } else {
            return new WP_REST_Response(array('message' => 'Failed to submit contact form'), 500);
        }
    }

 }

new ContactForm();
