<?php
    include_once 'class.issue.php';
    include_once 'class.article.php';

    class Site {

        // Stores all public variables
        private $_site;

        // Build basic site object and load data
        function __construct() {
            $this->_site = (object) array();

            $issue = $this->getIssue();
            $this->_site->development = (get_field('status', 'site') == 'dev');
            $this->_site->logo = get_field('logo', 'site');
            $this->_site->url = get_site_url();
            $this->_site->ga = get_field('google_analytics', 'site');
            $this->_site->issue = new Issue($issue);
            $this->_site->nav = $this->getNav();


            // Check if user has access
            if ($this->_site->development && get_field('password', 'site')) {
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
            if(is_page() && $post->post_parent > 0) {

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
                    'numberposts'   => 1,
                    'post_type'     => 'page',
                    'sort_column'   => 'post_date',
                    'status'        => 'published',
                    'sort_order'    => 'desc',
                    'parent'        => 0
                ));

                $issues = get_pages(array(
                    'numberposts'   => 1,
                    'post_type'     => 'page',
                    'sort_column'   => 'post_date',
                    'status'        => 'published',
                    'sort_order'    => 'desc',
                    'parent'        => $parents[0]->ID
                ));

                // If we are not on a special page redirect to current issue
                if (is_category()) {
                    return $issues[0];
                } else {
                    header('Location: ' . $issues[0]->guid);
                    die();
                }

            }

        }

        // Build article object for a given post ID
        public function getArticle($ID) {
            return new Article($ID);
        }

        // Generate sites nav, combining defaults and active issue categories
        public function getNav() {
            $nav = array();

            // Home
            $home = (object) array(
                'title' => 'Home',
                'link' => $this->_site->issue->link
            );
            array_push($nav, $home);

            // Get issue categories
            $items = $this->_site->issue->getNavItems();
            if ($items) {
                $nav = array_merge($nav, $items);
            }

            // Archive
            $archive = (object) array(
                'title' => 'Archive',
                'link' => '/archive'
            );
            array_push($nav, $archive);

            return $nav;
        }

    }