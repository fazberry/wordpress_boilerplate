<?php
    $site = new Site();

    $children = get_pages('child_of='.$post->ID);
    if(count($children) != 0 ) { 

        include('home.php');

    } else {

        $article = $site->getArticle($post->ID);

        echo $twig->render('article.html', array('site'=> $site, 'article' => $article));

    }

