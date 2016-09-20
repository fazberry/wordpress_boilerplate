<?php

    include('class.issue.php');

    class Site {

        private $_site;

        function __construct() {
            $this->_site = (object) array();

            $issue = $this->getIssue();
            $this->_site->issue = new Issue($issue);
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

                // return $issues[0];
                header('Location: ' . $issues[0]->guid);

                die();

            }

        }

    }