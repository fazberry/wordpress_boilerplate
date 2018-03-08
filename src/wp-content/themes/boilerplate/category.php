<?php
    $site = new Site();

    $category = get_the_category();
    if($site->issueBased) {
        $articles = $site->issue->getArticles(array('category' => $category[0]->term_id)); 
    } else {
        $articles = $site->getArticles(array('category'=>$category[0]->term_id));
    }

    echo $twig->render('home.twig', array('site'=> $site, 'articles' => $articles));