<?php
    require_once get_stylesheet_directory() . '/vendor/class-tgm-plugin-activation.php';

    add_action('tgmpa_register',  'addPlugins'); 
    function addPlugins () {
        $plugins = array(

            array(
                'name'      => 'Nested Pages',
                'slug'      => 'wp-nested-pages',
                'required'  => true,
                'force_activation'   => true
            ),

            array(
                'name'      => 'WPFront User Role Editor',
                'slug'      => 'wpfront-user-role-editor',
                'required'  => false,
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

            array(
                'name'      => 'Mail logger',
                'slug'      => 'wp-mail-logging',
                'required'  => true,
                'force_activation'   => true
            ),

        );

        $config = array(
            'is_automatic' => true
        );

        tgmpa( $plugins, $config );
    }

    // Include local vendor plugins
    add_action('after_switch_theme', 'install_local_plugins');
    function install_local_plugins() {
        $plugins = array(
            'mega' => 'mega',
            'video-encoder' => 'video-encoder',
            'sequel-survey' => 'sequel-survey',
            'advanced-custom-fields-pro' => 'acf'
        );

        $local_plugins = get_stylesheet_directory() . '/vendor/plugins/';
        $plugin_dir = WP_PLUGIN_DIR . '/';

        foreach($plugins AS $plugin => $file) {
            if (!is_plugin_active($plugin.'/'.$file.'.php')) {
                $src = $local_plugins . $plugin;

                shell_exec("cp -r $src $plugin_dir");

                activate_plugin($plugin.'/'.$file.'.php');
            }
        }
    }