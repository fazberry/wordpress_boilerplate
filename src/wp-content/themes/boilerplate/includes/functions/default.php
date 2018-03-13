<?php
    @ini_set( 'upload_max_size' , '64M' );
    @ini_set( 'post_max_size', '64M');
    @ini_set( 'max_execution_time', '300' );
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

    // Change permalink structure
    add_action('init', function() {
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure( '/%postname%/' );
    });

    // Default open comments on all post types
    function open_comments($status, $post_type, $comment_type) {
        return 'open';
    }
    add_filter('get_default_comment_status', 'open_comments', 10, 3);

     function my_login_logo() {
        $logo = get_field('logo', 'site');
        $logo = wp_get_attachment_image_src($logo, 'logo');
?>

        <style type="text/css">
            #login h1 a, .login h1 a {
                background-image: url(<?= $logo[0]; ?>);
            }
        </style>
<?php
    }
    add_action( 'login_enqueue_scripts', 'my_login_logo' );


             // TinyMCE styles
    add_filter('mce_buttons_2', 'fb_mce_editor_buttons');
    function fb_mce_editor_buttons($buttons) {
        array_unshift($buttons, 'styleselect');
        return $buttons;
    }

    add_filter( 'tiny_mce_before_init', 'fb_mce_before_init' );
    function fb_mce_before_init( $settings ) {  
        $style_formats = array(
            array(
                'title' => 'Boxout',
                'block' => 'div',
                'wrapper' => 1,
                'classes' => 'boxout'
            ),
            array(
                'title' => 'Left',
                'block' => 'div',
                'wrapper' => 1,
                'classes' => 'pullleft'
            ),
            array(
                'title' => 'Right',
                'block' => 'div',
                'wrapper' => 1,
                'classes' => 'pullright'
            )
        );

        $settings['style_formats'] = json_encode( $style_formats );

        return $settings;

    }
    add_editor_style('css/tinymce.css');


    add_filter('tiny_mce_before_init', 'tiny_mce_remove_unused_formats' );
    /*
     * Modify TinyMCE editor to remove H1.
     */
    function tiny_mce_remove_unused_formats($init) {
        // Add block format elements you want to show in dropdown
        $init['block_formats'] = 'Paragraph=p;Heading=h2;Sub Heading=h3';
        return $init;
    }

