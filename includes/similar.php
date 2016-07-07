				<?php 
					$posts = get_posts(
										array(
											'post_type' => 'article', 
											'posts_per_page' => 2,
											'post__not_in' => array($post->ID),
											'tax_query' => array(
												array(
													'taxonomy' => 'issuem_issue_tags',
													'field' => 'id',
													'terms' => $tags
												)
						    				)
										)
									); 
					if(count($posts)) {
				?>	
				<div class="container-600 centered similar-articles">
					<div class="spacing">
						<h1 class="section-header">YOU MAY ALSO LIKE...</h1>
						<?php
			            	foreach($posts as $post) : setup_postdata($post); 
			            		$category = wp_get_post_terms($post->ID, 'issuem_issue_categories');
			            		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), array(300,300) );
			            		$title = the_title(null, null, false);
								$title = preg_replace('/\[(.*)\]/', '${1}', $title);
			            ?>
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
						<?php endforeach; ?>
					</div>
					<div class="clearfix"></div>
				</div>
				<?php } ?>