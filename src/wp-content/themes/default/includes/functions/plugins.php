<?php

    require_once get_stylesheet_directory() . '/vendor/class-tgm-plugin-activation.php';

    add_action( 'tgmpa_register',  'addPlugins' ); 

    function addPlugins () {
        $plugins = array(

            // This is an example of how to include a plugin bundled with a theme.
            array(
                'name'               => 'Advanced Custom Fields Pro', // The plugin name.
                'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
                'source'             => get_stylesheet_directory() . '/vendor/plugins/advanced-custom-fields-pro.zip', // The plugin source.
                'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                'force_activation'   => true // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            ),

            // This is an example of how to include a plugin from the WordPress Plugin Repository.
            array(
                'name'      => 'Nested Pages',
                'slug'      => 'wp-nested-pages',
                'required'  => true,
                'force_activation'   => true
            ),

            array(
                'name'      => 'WPFront User Role Editor',
                'slug'      => 'wpfront-user-role-editor',
                'required'  => true,
                'force_activation'   => false
            ),

            array(
                'name'      => 'Admin Menu Editor',
                'slug'      => 'admin-menu-editor',
                'required'  => true,
                'force_activation'   => true
            ),

            array(
                'name'      => 'WP Super Cache',
                'slug'      => 'wp-super-cache',
                'required'  => true,
                'force_activation'   => false
            ),

            array(
                'name'      => 'Post Tags and Categories for Pages',
                'slug'      => 'post-tags-and-categories-for-pages',
                'required'  => true,
                'force_activation'   => true
            ),

            array(
                'name'      => 'Allow Numeric Slugs',
                'slug'      => 'allow-numeric-stubs',
                'required'  => true,
                'force_activation'   => true
            ),

        );

        $config = array(
            'is_automatic' => true
        );

        tgmpa( $plugins, $config );
    }

