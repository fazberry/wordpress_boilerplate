<?php

    include_once 'class.article.php';

    class Issue {

        private $_issue;

        public function __construct($issue) {
            $this->_issue = (object) array();

            $this->_issue->ID = $issue->ID;
            $this->_issue->link = get_the_permalink($issue->ID);
            $this->_issue->title = get_the_title($issue->ID) . ' | ' . get_the_title($issue->post_parent);
        }

        public function __get($name) {
            if (property_exists($this->_issue, $name)) {
                return $this->_issue->$name;
            }

            return null;
        }

        public function __isset($name) {
            return property_exists($this->_issue, $name);
        }

        public function getArticles($args = array()) {
            $defaults = array(
                'post_type'      => 'page',
                'post_parent'    => $this->_issue->ID,
                'posts_per_page' => -1
            );

            $args = array_merge($defaults, $args);

            $posts = get_posts($args);
            $articles = array();
            
            foreach ($posts as $post) {
                array_push($articles, new Article($post->ID));
            }

            return $articles;
        }

        public function getNavItems() {
            $categories = array();
            $articles = $this->getArticles();

            foreach($articles AS $article) {
                $tmpCategories = get_the_category($article->ID);

                foreach($tmpCategories AS $category) {
                    if ($category->term_id == 1 || array_key_exists($category->term_id, $categories)) {
                        continue;
                    }

                    $categories[$category->term_id] = (object) array(
                        'title' => $category->name,
                        'link' => get_category_link($category->term_id)
                    );
                }
            }

            usort($categories, array($this, "sortNavItems"));

            return $categories;
        }

        private function sortNavItems($a, $b) {
            return strcmp($a->title, $b->title);
        }

    }