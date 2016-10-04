<?php
    $site = new Site();

    if($site->issueBased) {
        $articles = $site->issue->getArticles(array('posts_per_page' => 6));
    } else {
        $articles = $site-> getArticles();
    }

    echo $twig->render('home.html', array('site'=> $site, 'articles' => $articles));

