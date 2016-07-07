<?php
/*
Single Post Template: Post Page
*/
?>
<?php 
	$category = wp_get_post_terms($post->ID, 'issuem_issue_categories');

	if($category[0] -> slug == 'lead-article') {
		$categorySlug = $category[1] -> slug;
	} else {
		$categorySlug = $category[0] -> slug;
	}

	define('PAGE_CLASS', 'article-page');
	define('CONTAINER_CLASS', $categorySlug);
	define('WP_USE_THEMES', false); 
	get_header(); 

	the_post();

	// gets articles in the same issue
	$tempIssue = wp_get_post_terms($post->ID, 'issuem_issue');
	$issue = $tempIssue[0]->slug;
	$issueName = $tempIssue[0]->name;

	$title = the_title(null, null, false);
	$title = preg_replace('/\[(.*)\]/', '<span>${1}</span>', $title);

	$emailTitle = the_title(null, null, false);
	$emailTitle = preg_replace('/\[(.*)\]/', '${1}', $emailTitle);
	$emailTitle = preg_replace('/<br ?\/?>/', ' ', $emailTitle);
	$emailTitle = str_replace('  ', ' ', $emailTitle);
	$emailTitle = strtolower($emailTitle);
	$emailTitle = ucfirst($emailTitle);

	if(get_adjacent_post(true,array('16','19'),true, 'issuem_issue')) {
		$previousArticle = get_permalink(get_adjacent_post(true,array('16','19'),true, 'issuem_issue'));
	}
	if(get_adjacent_post(true,array('16','19'),false, 'issuem_issue')) {
		$nextArticle = get_permalink(get_adjacent_post(true,array('16','19'),false, 'issuem_issue'));
	}

	$masthead = get_field('masthead');
	if($masthead) {
		$file_parts = pathinfo($masthead);
		$extension = strtolower($file_parts['extension']);
		if($extension == 'jpg' || $extension == 'png' || $extension == 'jpeg' || $extension == 'gif') {
			$mastheadType = 'image';
		} else if ($extension == 'mp4') {
			$mastheadType = 'video';
		} 
	}

	if(!$mastheadType) {
		$masthead = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ));
		$mastheadType = 'image';
	}

	$tagTerms = wp_get_post_terms($post->ID, 'issuem_issue_tags');
	
	$tags = array();

	foreach($tagTerms as $tag) {
		array_push($tags, $tag -> term_id);
	}
?>
			<?php include 'issue-bar.php'; ?>
			<?php include 'nav.php'; ?>
			<div class="clearfix"></div>
			<div class="masthead masthead-article masthead-article-page" <?php if($mastheadType == 'image') { ?> style="background-image: url('<?php echo $masthead ?>');"<?php } else { ?> style="background-image: url('<?php the_field('image'); ?>');" <?php  } ?>>
				<?php if($mastheadType == 'video') { ?>
					<video autobuffer autoplay loop controls="controls" poster="<?php the_field('image'); ?>">
						<source src="<?php echo $masthead ?>">
					</video>
					<!-- Video Controls -->
					<div class="video-controls">
						<a href="#" id="mute" class="muted"></a>
						<a href="#" id="full-screen"></a>
					</div>
				<?php } ?>
			</div>
			<div class="social social-sticky">
				<ul>
					<li><a href="#" class="like <?php isliked($post->ID); ?>" data-pid="<?php echo $post->ID; ?>"></a></li>
					<li>
						<div class="share-button">
							<a href="" class="share"></a>
							<div class="share-options">
								<a class="share-mail" href=""></a>
							</div>
						</div>
					</li>
					<li><a href="#" class="rate"><?php if(function_exists('the_ratings')) {the_ratings();} ?></a></li>
				</ul>
			</div>
			<div class="container-960 centered article-container">
				<?php if($previousArticle): ?><a href="<?= $previousArticle ?>" class="arrow left-arrow previous-article"></a><?php endif; ?>
				<?php if($nextArticle): ?><a href="<?= $nextArticle ?>" class="arrow right-arrow next-article"></a><?php endif; ?>
				<div class="container-850 centered article-content">
					<div class="spacing">
						<h1 class="title"><?php echo $title; ?></h1>
						<h2 class="sub-title"><?php the_field('sub_title'); ?></h2>
						<h3 class="standfirst"><?php the_field('standfirst'); ?></h3>
						<div class="article-body">
							<?php the_content(); ?>

						</div>
						<hr class="social-break" />	
						<div class="social">
							<a href="#" class="like <?php isliked($post->ID); ?>" data-pid="<?php echo $post->ID; ?>">
								LIKE
								<div class="like-count">
									<?php echo get_like_count($post->ID); ?>
								</div>
							</a>
							<div class="share-button">
								<a href="" class="share">SHARE THIS</a>
								<div class="share-options">
									<a class="share-mail" href=""></a>
								</div>
							</div>
							<a href="#" class="rate">RATE THIS<?php if(function_exists('the_ratings')) {the_ratings();} ?></a>
							<a href="#" class="clearfix"></a>
						</div>
					</div>
				</div>
				<div class="top"></div>
				<?php include 'similar.php' ?>
			</div>
		<?php get_footer()?>
		<?php wp_footer(); ?>