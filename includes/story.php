<?php

    $story->title = get_the_title();
    $story->standfirst = get_field('standfirst');
    $story->content = apply_filters('the_content', get_the_content());

    $prev_post = get_previous_post();
    $next_post = get_next_post();
    $story->prevLink = get_permalink($prev_post->ID);
    $story->prevTitle= get_the_title($prev_post->ID);
    $story->nextLink = get_permalink($next_post->ID);
    $story->nextTitle= get_the_title($next_post->ID);

    echo $twig->render('story.html', array('story'=>$story));

    wp_reset_postdata();


?>