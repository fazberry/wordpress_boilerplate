<?php
    $site = new Site();

    $category = get_the_category();
    $articles = $site->issue->getArticles(array('category' => $category[0]->term_id));

    echo $twig->render('home.html', array('site'=> $site, 'articles' => $articles));