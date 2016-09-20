<?php

    require_once get_template_directory() . '/vendor/Twig/Autoloader.php';
    Twig_Autoloader::register();

    $loader = new Twig_Loader_Filesystem(get_template_directory() . '/templates');
    $twig = new Twig_Environment($loader, array(
        'cache' => get_template_directory() . '/templates/cache',
        'auto_reload' => $debug
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