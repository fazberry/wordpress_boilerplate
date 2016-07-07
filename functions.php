<?php
/**
 * Nationwide functions page
 *
**/

    ///////////////////////////////////  TWIG  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    require_once get_theme_root() . '/magic_tim/vendor/Twig/Autoloader.php';
    Twig_Autoloader::register();

    $loader = new Twig_Loader_Filesystem(get_theme_root() . '/magic_tim/templates');
    $twig = new Twig_Environment($loader, array(
        'cache' => get_theme_root() . '/magic_tim/templates/cache',
        'auto_reload' => true
    ));


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

    add_action('admin_head', 'custom_admin_css');
    function custom_admin_css() {
        wp_enqueue_style('admin-custom-css', get_template_directory_uri() . '/css/admin.css');
    }


    function getIssue($id) {
        $children = get_pages('child_of='.$id);
        if(count($children)){
            return get_page($id);
        } else {
            $post = get_page($id); 
            return get_page($post->post_parent);
        }
    }


    function issueList() {
        $issues = issueListGetChildren(0, '');
        $issues = array_flatten($issues, array());
        //print_r($issues);
    }

    function issueListGetChildren($id, $prefix) {
        $roots = get_pages(array(   
            'parent' => $id
        ));

        $issues = array();
        foreach($roots AS $root) {
            $children = get_pages('child_of='.$root->ID);
            if (count($children) > 0) {
               array_push($issues, issueListGetChildren($root->ID, $prefix . ' ' . $root->post_title));
            }
        }

        if (count($issues)) {
            return $issues;
        } else {
            return array($prefix);
        }
    }

    function array_flatten($array,$return) {
    for($x = 0; $x <= count($array); $x++) {
        if(is_array($array[$x])) {
            $return = array_flatten($array[$x], $return);
        }
        else {
            if(isset($array[$x])) {
                $return[] = $array[$x];
            }
        }
    }
    return $return;
}



    if( function_exists('acf_add_options_page') ) {
        acf_add_options_page();
        acf_add_options_sub_page('Current Issue');        
    }


///////////////////////////////// customize ACF path ///////////////////////////////////


    add_filter('acf/settings/save_json', 'my_acf_json_save_point');
 
    function my_acf_json_save_point( $path ) {
        
        // update path
        $path = get_stylesheet_directory() . '/acf-json';
        
        // return
        return $path;
        
    }
