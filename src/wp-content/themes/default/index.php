<?php
    $site = new Site();
    $articles = $site->issue->getArticles();

    echo $twig->render('home.html', array('site'=> $site, 'articles' => $articles));

