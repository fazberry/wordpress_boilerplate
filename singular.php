<?php
/*
Single Post Template: Post Page
*/

	// Get correct default page template for pages
    $children = get_pages('child_of='.$post->ID);
    // if is parent
    if(count($children) != 0 ) { 
        include '/home/devservr/public_html/magic/wp-content/themes/magic_tim/page_home.php';
        die();
    }

    define('CONTAINER_CLASS', 'story');
    define('WP_USE_THEMES', false); 
    
    include 'includes/header.php';
    include 'includes/issue-bar.php';
	include 'includes/nav.php'; 
	include 'includes/masthead.php';

	$story = new stdClass();
	$story->likeClass = isliked($post->ID, false);
    $story->dataPid = $post->ID;
    $story->likeCount = get_like_count($post->ID);

	echo $twig->render('social.html', array('story'=>$story));
	include 'includes/story.php';

	echo '<div class="top"></div>';

	include 'includes/similar.php';

	include 'includes/footer.php';
 	wp_footer(); 
?>