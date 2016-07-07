<?php

    //wp_reset_postdata();

    $isHomepage = get_children(array('post_parent'=>$post->ID, 'post_type'   => 'page'));
    $masthead = new stdClass();

    if(count($isHomepage)) {      
        $posts = get_pages(array(   
            'child_of'      => $post->ID,
            'meta_key'      => 'featured',
            'meta_value'    => 1
        )); 
        $masthead->home = true;
        $post = $posts[0];
        $masthead->title = get_the_title();
        $masthead->excerpt = get_field('excerpt');
        $masthead->link = get_the_permalink();
    }
    $media = get_field('media', $post->ID);
    $image = $media[0]['image'];
    $image = wp_get_attachment_image_src($image, 'large');
    $masthead->image = $image[0];
    $masthead->video = $media[0]['video'];
    $masthead->hype = $media[0]['hype'];

    echo $twig->render('masthead.html', array('masthead'=>$masthead));

    wp_reset_postdata();

?>