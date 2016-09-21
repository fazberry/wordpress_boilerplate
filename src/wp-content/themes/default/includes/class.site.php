<?php

    include_once 'class.issue.php';
    include_once 'class.article.php';

    class Site {

        private $_site;

        function __construct() {
            $this->_site = (object) array();

            $issue = $this->getIssue();
            $this->_site->issue = new Issue($issue);
            $this->_site->nav = $this->getNav();

            wp_reset_postdata();
        }

        public function __get($name) {
            if (property_exists($this->_site, $name)) {
                return $this->_site->$name;
            }

            return null;
        }

        public function __isset($name) {
            return property_exists($this->_site, $name);
        }

        private function getIssue() {
            global $post;

            if(is_page() && $post->post_parent > 0) {

                $children = get_pages('child_of='.$post->ID);
                if(count($children)){
                    return get_page($post->ID);
                } else {
                    $post = get_page($post->ID); 
                    return get_page($post->post_parent);
                }

            } else {

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

                if (is_category()) {
                    return $issues[0];
                } else {
                    header('Location: ' . $issues[0]->guid);
                    die();
                }

            }

        }

        public function getArticle($ID) {
            return new Article($ID);
        }

        public function getNav() {
            $nav = array();

            // Home
            $home = (object) array(
                'title' => 'Home',
                'link' => '/'
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