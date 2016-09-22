<?php
    function google_analytics_notice() {
        $class = 'notice notice-warning';
        $message = 'Site is live without a Google Analytics code, <a href="./admin.php?page=acf-options-site-settings">go to settings</a>.';

        if (get_field('status', 'site') != 'dev' && !get_field('google_analytics', 'site')) {
            printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
        }
    }
    add_action('admin_notices', 'google_analytics_notice');