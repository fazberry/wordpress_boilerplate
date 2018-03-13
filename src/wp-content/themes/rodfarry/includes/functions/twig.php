<?php

    require_once get_template_directory() . '/vendor/Twig/Autoloader.php';
    Twig_Autoloader::register();

    $loader = new Twig_Loader_Filesystem(get_template_directory() . '/templates');
    $twig = new Twig_Environment($loader, array(
        'cache' => get_template_directory() . '/templates/cache',
        'auto_reload' => DEBUG
    ));

    $twig->addGlobal('baseurl', get_bloginfo('url'));

    $twig->addFunction(new Twig_SimpleFunction('wp_head', 'wp_head'));

    $twig->addFunction(new Twig_SimpleFunction('wp_footer', 'wp_footer'));

    $wp_title = new Twig_SimpleFunction('wp_title', function() {
        wp_title('|', true, 'right'); 
        bloginfo('name');
    });
    $twig->addFunction($wp_title);

    $get_image = new Twig_SimpleFunction('getImage', function($id, $size) {
        $image = wp_get_attachment_image_src($id, $size);
        return $image[0];
    });
    $twig->addFunction($get_image);

    $body_class = new Twig_SimpleFunction('body_class', function() {
        $bodyClass = body_class();
    });
    $twig->addFunction($body_class);

    $do_shortcode = new Twig_SimpleFunction('do_shortcode', function($code) {
        return do_shortcode($code);
    });
    $twig->addFunction($do_shortcode);

    $pluralize = new Twig_SimpleFunction('pluralize', function($count, $one, $many, $none = null) {
        // Make sure $count is a numeric value
        if ( ! is_numeric( $count ) )
            throw new Exception( '$count must be numeric.' );
        // If the option for $none is null, use the option for $many
        if ( $none === null )
            $none = $many;
        // Handle 0
        switch( $count ) {
            case 0:
                $string = $none;
                break;
            case 1:
                $string = $one;
                break;
            default:
                $string = $many;
                break;
        }
        // Return the result
        return sprintf( $string, $count );
    });
    $twig->addFunction($pluralize);