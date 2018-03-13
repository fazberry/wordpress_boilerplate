<?php
    include_once 'includes/class.search.php';

    $site = new Site();
    $search = new Search();

    $form = get_search_form(false);

    echo $twig->render('search.twig', array('site'=> $site, 'form' => $form, 'search' => $search));