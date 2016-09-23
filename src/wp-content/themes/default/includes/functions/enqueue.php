<?php

    // Custom CSS for wp-admin
    add_action('admin_head', 'custom_admin_css');
    function custom_admin_css() {
        wp_enqueue_style('admin-custom-css', get_template_directory_uri() . '/css/admin.css');
    }

    // Site CSS
    add_action('wp_enqueue_scripts', 'custom_css');
    function custom_css() {
        wp_enqueue_style( 'wp-mediaelement' );
        wp_enqueue_style('normalize-css', get_template_directory_uri() . '/vendor/normalize.min.css');
        wp_enqueue_style('skeleton-css', get_template_directory_uri() . '/vendor/skeleton.css');
        wp_enqueue_style('main-css', get_template_directory_uri() . '/css/main.css');
    }

    //Making jQuery Google API
    function modify_jquery() {
        if (!is_admin()) {
           wp_deregister_script('jquery');
           wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js', false, '1.8.1');
           wp_enqueue_script('jquery');
        }
    }
    add_action('init', 'modify_jquery');

    // Site JS
    add_action('wp_head', 'custom_js');
    function custom_js() {
        wp_enqueue_script('wp-mediaelement');
        wp_enqueue_script('modernizr-js', get_template_directory_uri() . '/vendor/modernizr.min.js', array(), '0.1', false);
        wp_enqueue_script('main-js', get_template_directory_uri() . '/js/main.js', array(), '0.1', true);
    }