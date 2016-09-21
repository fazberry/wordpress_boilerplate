<?php
    $site = new Site();
    $articles = $site->issue->getArticles(array('posts_per_page' => 6));

    echo $twig->render('home.html', array('site'=> $site, 'articles' => $articles));

