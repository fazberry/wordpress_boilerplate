<?php
    // Show Google analytics warning if site is live without GA code
    function google_analytics_notice() {
        $class = 'notice notice-warning';
        $message = 'Site is live without a Google Analytics code, <a href="./admin.php?page=acf-options-site-settings">go to settings</a>.';

        if (!DEVELOPMENT && !get_field('google_analytics', 'site')) {
            printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
        }
    }
    add_action('admin_notices', 'google_analytics_notice');


    // Stop users editing admin
    add_action('pre_user_query','manager_user_query');
    function manager_user_query($user_search) {
        $user = wp_get_current_user();

        if (!current_user_can('sequel_super_admin')) {
            global $wpdb;

            $user_search->query_where = 
                str_replace('WHERE 1=1', 
                "WHERE 1=1 AND {$wpdb->users}.ID IN (
                     SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta 
                        WHERE {$wpdb->usermeta}.meta_key = '{$wpdb->prefix}capabilities'
                        AND {$wpdb->usermeta}.meta_value NOT LIKE '%administrator%')", 
                $user_search->query_where
            );
        }
    }

    // Limit the roles a manager can set for a user
    function manager_editable_roles( $roles ) {
        if (!current_user_can('sequel_super_admin')) {
            unset($roles['administrator']);
        }

        return $roles;
    }
    add_filter('editable_roles', 'manager_editable_roles');