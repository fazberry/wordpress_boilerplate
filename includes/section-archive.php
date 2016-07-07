			<div class="container-960 centered section-archive article-archive">
				<div class="container-900 centered">
					<h1 class="section-header">CHOICE CUTS FROM THE ARCHIVE</h1>
					<!-- <a href="#" class="arrow left-arrow"></a>
					<a href="#" class="arrow right-arrow"></a> -->
					<div class="container-850 centered section-archive-carousel">
						<?php 
							$posts = get_posts(
										array(
											'post_type' => 'article', 
											'posts_per_page' => 8,
											'orderby' => 'rand', 
											'tax_query' => array(
										        array(
										            'taxonomy' => 'issuem_issue_categories',
										            'terms' => array('16','19'),      
										            'field' => 'id',
										            'operator' => 'NOT IN'
										        ), array(
										            'taxonomy' => 'issuem_issue',
										            'terms' => $issue,      
										            'field' => 'slug',
										            'operator' => 'NOT IN'
										        )
							    			)
										)
									); 
			            	foreach($posts as $post) : setup_postdata($post); 
			            		$category = wp_get_post_terms($post->ID, 'issuem_issue_categories');
			            		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), array(300,300) );
			            		$title = the_title(null, null, false);
								$title = preg_replace('/\[(.*)\]/', '${1}', $title);
			            ?>
				            <div>
								<a href="<?php the_permalink() ?>" title="<?php echo $title; ?>" class="article-rollup category-<? echo $category[0]->slug; ?>">
									<div class="spacing">
										<div class="article-rollup-image" style="background-image: url('<?php echo $thumbnail[0]; ?>')">
											<div class="article-rollup-rollover">
												<div class="read-text"><span>READ</span></div>
											</div>
										</div>
										<div class="article-rollup-title">
											<h3><?php echo $title; ?></h3>
										</div>
									</div>
								</a>
							</div>
						<?php endforeach; ?>
					</div>
					<!--<a href="#" class="button archive-link">OPEN ARCHIVE</a>-->
				</div>
				<div class="clearfix"></div>
			</div> <!-- Archive section container -->