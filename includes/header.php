<?php
    global $post;

    $issue = getIssue($post->ID);

    if(!$issue->ID){
        $issue =  get_field('current_issue', 'options');
        header('Location: '.get_permalink($issue->ID));
        die();
    }

    // Add specific CSS class by filter
    add_filter( 'body_class', 'my_class_names' );
    function my_class_names( $classes ) {
        // add 'class-name' to the $classes array
        $classes[] = PAGE_CLASS;
        // return the $classes array
        return $classes;
    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
    <title><?php wp_title(); ?></title> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.4.1/slick.css"/>
    <!--[if lte IE 8]>
		<link rel="stylesheet" type="text/css" href="/wp-content/themes/magic_tim/ie.css" />
	<![endif]-->
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.4.1/slick.min.js"></script>
    <link rel="stylesheet" href="/magic/wp-content/themes/magic_tim/mobile.css" />
    <link rel="icon" type="image/png" href="img/favicon.png">
    <?php wp_head(); ?>
</head>	
	<body <?php body_class(); ?>>
		<div class="outer-container <?php echo CONTAINER_CLASS; ?>">
