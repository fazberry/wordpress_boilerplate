<?php

    $debug = true;

    if ($debug) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    include 'includes/functions/plugins.php';
    include 'includes/functions/default.php';
    include 'includes/functions/enqueue.php';
    include 'includes/functions/twig.php';
    include 'includes/functions/custom-fields.php';
    include 'includes/functions/image-sizes.php';