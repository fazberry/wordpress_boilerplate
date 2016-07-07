<?php 

    // Get all articles in current issue for navigation
    //echo 'rod' . $issue->ID;
    $posts = get_pages(array(   
        'child_of'      => $issue->ID
    )); 

    $categories = array();
    foreach($posts as $post) {
    	setup_postdata($post);
    	$cat = get_the_category();
        $category = $cat[0]->slug;
    	if(!array_key_exists($category, $categories)){
    		$categories[$category] = new stdClass();
    		$categories[$category]->navTitle = $cat[0]->name;
    		$categories[$category]->navItems = array();
    	}
    	$navItems = new stdClass();
    	$navItems->title= get_the_title(); 
    	$navItems->link= get_the_permalink();
    	array_push($categories[$category]->navItems, $navItems);
    }

    echo $twig->render('nav.html', array('categories'=>$categories));

    wp_reset_postdata();

    // Get Archived issues

    issueList();

?>