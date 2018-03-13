<?php
    include_once 'class.issue.php';
    include_once 'class.article.php';

    class Site {

        // Stores all public variables
        private $_site;

        // Build basic site object and load data
        function __construct() {
            $this->_site = (object) array();
            $this->_site->issueBased = (get_field('site_type', 'site') == 'issue-based');
            if ($this->_site->issueBased) {
                $issue = $this->getIssue();
                $this->_site->issue = new Issue($issue);
                $this->_site->issues = $this->getIssues();
            }

            $this->_site->development = (get_field('status', 'site') == 'dev');
            $this->_site->title = get_bloginfo('name');
            $this->_site->logo = get_field('logo', 'site');
            $this->_site->url = get_site_url();
            $this->_site->ga = get_field('google_analytics', 'site');
            
            $this->_site->nav = $this->getNav();

            // Check if user has access
            if ($this->_site->development && get_field('password', 'site')) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                
                // Have they entered the password?
                if (isset($_SESSION['password']) && $_SESSION['password'] == get_field('password', 'site')) {
                    //
                } else {
                    include(get_template_directory() . '/403.php');
                    die();
                }
            }


            wp_reset_postdata();
        }

        // Grant TWIG access to _site variables
        public function __get($name) {
            if (property_exists($this->_site, $name)) {
                return $this->_site->$name;
            }

            return null;
        }

        // Grant TWIG access to _site variables
        public function __isset($name) {
            return property_exists($this->_site, $name);
        }

        /*
         * Get the issue
         * - If not in issue, redirects to latest published issue
         */
        private function getIssue() {
            global $post;

            // If in an issue, work out what issue it is
            if (is_page() && $post->post_parent > 0) {

                $children = get_pages('child_of='.$post->ID);
                if(count($children)){
                    return get_page($post->ID);
                } else {
                    $post = get_page($post->ID); 
                    return get_page($post->post_parent);
                }

            } else {

                // Find the latest published issue with published articles
                $parents = get_pages(array(
                    'number'        => 1,
                    'post_type'     => 'page',
                    'sort_column'   => 'post_date',
                    'status'        => 'published',
                    'sort_order'    => 'desc',
                    'parent'        => 0
                ));

                $issues = get_pages(array(
                    'number'        => 1,
                    'post_type'     => 'page',
                    'sort_column'   => 'post_date',
                    'status'        => 'published',
                    'sort_order'    => 'desc',
                    'parent'        => $parents[0]->ID
                ));

                // If we are not on a special page redirect to current issue
                if (is_category()) {
                    return $issues[0];
                } else if (!count($issues)) {
                    echo "No issues available";
                    die();
                } else {
                    header('Location: ' . $issues[0]->guid);
                    die();
                }
            }
        
        }

        // Get list of all published issues
        private function getIssues() {
            $issues = array();

            $parents = get_pages(array(
                'post_type'     => 'page',
                'sort_column'   => 'post_date',
                'status'        => 'published',
                'sort_order'    => 'desc',
                'parent'        => 0
            ));

            foreach($parents AS $parent) {
                $tmpIssues = get_pages(array(
                    'post_type'     => 'page',
                    'sort_column'   => 'post_date',
                    'status'        => 'published',
                    'sort_order'    => 'desc',
                    'parent'        => $parent->ID
                ));

                foreach($tmpIssues AS $issue) {
                    array_push($issues, new Issue($issue));
                }
            }

            return $issues;
        }


        // Site type - News roll 
        public function getArticles($args = array()) {
            $defaults = array(
                'post_type'      => 'post',
                'posts_per_page' => -1,
                'sort_column' => 'menu_order'
            );

            $args = array_merge($defaults, $args);

            $posts = get_posts($args);
            $articles = array();
            
            foreach ($posts as $post) {
                array_push($articles, new Article($post->ID));
            }

            return $articles;
        }


        // Build article object for a given post ID
        public function getArticle($ID) {
            return new Article($ID);
        }

        // Generate sites nav, combining defaults and active issue categories
        public function getNav() {
            global $post;

            $catID = null;
            $postID = null;
            if (is_singular() && $post->ID) {
                $postID = $post->ID;

                // Is it a sub page?
                if ($post->post_parent) {
                    $ancestors = get_post_ancestors($post->ID);
                    $postID = $ancestors[count($ancestors)-1];                
                }

                $category = get_the_category();
                if (isset($category) && count($category)) {
                    $catID = $category[0]->term_id;
                }
            }
            if (is_category() && get_query_var('cat')) {
                $catID = get_query_var('cat');
            }

            $nav = array();

            // Home
            if($this->_site->issueBased) {
                $home = (object) array(
                    'title' => 'Home',
                    'link' => $this->_site->issue->link,
                    'active' => ($postID == $this->_site->issue->ID)
                );
            } else {
                $home = (object) array(
                    'title' => 'Home',
                    'link' => $this->_site->url,
                    'active' => is_home()
                );
            }
            array_push($nav, $home);

            if($this->_site->issueBased) {
                // Get issue categories
                $items = $this->_site->issue->getNavItems();
                if ($items) {
                    $nav = array_merge($nav, $items);
                }
            } else {
                $nav = array_merge($nav, $this->getNavCategories($catID));
                $nav = array_merge($nav, $this->getNavPages($postID));
            }

            return $nav;
        }

        private function getNavCategories($catID) {
            $items = array();

            $categories = get_categories();

            foreach ($categories as $category) {
                if($category->term_id == 1 ) {
                    continue;
                }
                $item = (object) array(
                    'title' => get_cat_name($category->term_id),
                    'link' => get_category_link($category->term_id),
                    'category' => $category->term_id,
                    'active' => ($catID == $category->term_id),
                    'children' => array()
                );

                if ($category->parent) {
                    array_push($items[$category->parent]->children, $item);
                } else {
                    $items[$category->term_id] = $item;
                }
            }

            return $items;
        }

        private function getNavPages($activeID, $parent = 0) {
            $items = array();

            // Get a list of pages that shouldn't been visible in the nav
            $args = array(
                'meta_key' => '_np_nav_status',
                'meta_value' => 'hide',
                'post_type' => array('page', 'np-redirect')
            );
            $exclude = array();
            $pages = get_posts($args); 
            foreach ($pages as $page) {
                array_push($exclude, $page->ID);
            }

            $args = array(
                'hierarchical' => 1,
                'order' => 'asc',
                'post_parent' => $parent,
                'sort_column' => 'menu_order',
                'post_type' => array('page', 'np-redirect'),
                'exclude' => $exclude
            );

            $pages = get_posts($args);

            foreach ($pages as $page) {
                $item = (object) array(
                    'title' => get_the_title($page->ID),
                    'link' => get_the_permalink($page->ID),
                    'id'    => $page->ID,
                    'active' => ($activeID == $page->ID)
                );

                if ($page->post_type == "np-redirect") {
                    $item->link = $page->post_content;
                    $item->external = true;
                }

                // Get children
                $children = $this->getNavPages($activeID, $page->ID);
                if ($children && count($children) > 0) {
                    $item->children = $children;
                }

                array_push($items, $item);
            }

            return $items;
        }

    }