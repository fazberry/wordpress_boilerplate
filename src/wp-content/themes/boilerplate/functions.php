<?php

    $debugKey = 'asdf';

    $development = true;
    if(function_exists('get_field')) {
        $development = (get_field('status', 'site') == 'dev');
    }
    define('DEVELOPMENT', $development);

    $debug = true;
    if(function_exists('get_field')) {
        $debug = ($development || (isset($_GET['debug']) && $_GET['debug'] == $debugKey));
    }
    define('DEBUG', $debug);
    if ($debug) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    include 'includes/functions/setup.php';
    if(is_admin()) {
        include 'includes/functions/admin.php';
    }
    include 'includes/functions/plugins.php';
    include 'includes/functions/default.php';
    include 'includes/functions/enqueue.php';
    include 'includes/functions/twig.php';
    include 'includes/functions/custom-fields.php';
    include 'includes/functions/image-sizes.php';

    include 'includes/class.site.php';