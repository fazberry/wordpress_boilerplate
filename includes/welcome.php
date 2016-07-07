            <div class="container-700 section-issue centered">
                <h1 class="section-header"><?= $currentIssue; ?></h1>
                <?php 
                    $posts = get_posts(array('post_type' => 'article', 'posts_per_page' => 1, 'issuem_issue' => $issue, 'issuem_issue_categories' => 'welcome')); 
                    foreach($posts as $post) : setup_postdata($post); 
                        $category = wp_get_post_terms($post->ID, 'issuem_issue_categories');
                        $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), array(170,200) );
                ?>
                    <div class="section-issue-welcome">
                        <!-- <div class="section-issue-welcome-image" style="background-image: url('<?php echo $thumbnail[0]; ?>');"></div> -->
                        <div class="section-issue-welcome-text">
                            <p><strong><?php the_title(); ?></strong><br /><?php the_content(); ?></p>
                        </div>
                        <div class="fade"></div>
                    </div> <!-- Welcome -->
                    <a href="#" class="button show-hide">EXPAND</a>
                <?php endforeach; ?>
            </div>