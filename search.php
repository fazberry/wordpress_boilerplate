<?php
/*
Template Name: Search Page
*/
?>
<?php 
	define('PAGE_CLASS', 'searchpage');
	define('CONTAINER_CLASS', 'search-results');
	define('WP_USE_THEMES', false); 

	get_header();
	if(isset($_GET['issue'])) {
		$issue = str_replace('/', '', $_GET['issue']); 
		$currentIssue = checkIssue($issue);	
	}
	if(!$currentIssue){
		$currentIssue = getLatestIssue();
		$issue = $currentIssue[0]->slug;
		$currentIssue = $currentIssue[0]->name;
	} 
	the_post();

?>
			<div class="masthead" style="background-image: url('/wp-content/themes/magic_bumblebee/images/placeholder/masthead.jpg');">
				<img class="kfi-logo" src="/wp-content/themes/magic_bumblebee/images/icons/kfi-logo.png" />
			</div>
			<?php include 'nav.php';?>
			<div class="centered search-rollup container-960">
				<div class="spacing">
					<h1>SEARCH RESULTS</h1>
				</div>
				<?php
					global $wp_query;
					
					query_posts(array_merge( array( 'tax_query' => array(
																        array(
																            'taxonomy' => 'issuem_issue_categories',
																            'terms' => array('16','19'),      
																            'field' => 'id',
																            'operator' => 'NOT IN'
																        ),
													    			) ) ,  $wp_query->query));
						$total_results = $wp_query->found_posts;

						echo '<div class="spacing"><div class="search-count"><span>' . $total_results  . '</span> results found for "<span>' . $_GET['s'] . '</span>"</div></div>';
							
			            if ( have_posts() ) : while ( have_posts() ) : the_post(); 
			                $do_not_duplicate = $post->ID;
	            		$category = wp_get_post_terms($post->ID, 'issuem_issue_categories');
	            		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), array(200,200) );
	            		$title = the_title(null, null, false);
						$title = preg_replace('/\[(.*)\]/', '${1}', $title);
	            	?>
	            	<div class="spacing">
						<a href="<?php the_permalink() ?>" title="<?php echo $title; ?>" class="searchresult article-rollup category-<? echo $category[0]->slug; ?>">
							<div class="article-rollup-image" style="background-image: url('<?php echo $thumbnail[0]; ?>')"></div>
							<div class="article-rollup-text">
								<h3><?php echo $title; ?></h3>
								<p><?php the_excerpt(); ?></p>
							</div>
						</a>
					</div>
				<?php endwhile; endif; ?>	
				
			</div>
			<div class="clearfix"></div>
			<?php include 'section-archive.php';?>
			<div class="top"></div>
			<?php get_footer()?>
			<?php wp_footer(); ?>