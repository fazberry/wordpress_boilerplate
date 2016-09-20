<?php

    // define( 'WP_MEMORY_LIMIT', '250M' );

    function disable_mytheme_action() {
        define('DISALLOW_FILE_EDIT', TRUE);
    }
    add_action('init','disable_mytheme_action');

    // Hide admin bar for all users
    show_admin_bar(false);

    // Remove wordpress meta tag
    remove_action('wp_head', 'wp_generator');

    // Remove emojii support
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');

    // Remove blog editor support
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');


    add_filter('page_attributes_dropdown_pages_args', 'my_attributes_dropdown_pages_args', 1, 1);

    function my_attributes_dropdown_pages_args($dropdown_args) {

        $dropdown_args['post_status'] = array('publish','draft');

       return $dropdown_args;
    }
