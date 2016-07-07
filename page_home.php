<?php
/*Template Name: Homepage*/
/*Show selected image*/
/*Return value = URL*/

    define('CONTAINER_CLASS', 'home');
    define('WP_USE_THEMES', false); 

    include 'includes/header.php';

    $featured = get_field('featured');

    include 'includes/masthead.php';
    include 'includes/nav.php';
    // include 'includes/welcome.php';

// Get Article Rollup

    $latestStories = array();

    $posts = get_pages(array(   
        'child_of'      => $id,
        'meta_key'      => 'featured',
        'meta_value'    => 0
    )); 

    foreach ($posts as $post){
        setup_postdata($post);
        $rollup = new stdClass();
        $rollup->home = true;
        $rollup->title = get_the_title();
        $rollup->link = get_the_permalink();
        $category = get_the_category();
        $rollup->category = $category[0]->slug;
        $rollup->rating = round($post_ratings_data['ratings_average'][0]);     
        $media = get_field('media', $post->ID);
        $thumbnail = $media[0]['image'];
        $thumbnail = wp_get_attachment_image_src($thumbnail, 'medium');
        $rollup->thumbnail = $thumbnail[0];
        array_push($latestStories, $rollup);
    }

    echo $twig->render('section-rollup.html', array('items'=>$latestStories));

    echo $twig->render('ad.html', array('items'=>$latestStories)); 
    
    // include 'includes/section-archive.php';

    echo '<div class="top"></div>';

    include 'includes/footer.php';
    wp_footer(); 

?>