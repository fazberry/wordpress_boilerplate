<?php

    class Article {

        private $_article;

        public function __construct($ID) {
            global $post;
            $post = get_post($ID);
            setup_postdata($post);
            $this->post = $post;

            $this->_article = (object) array();

            $this->_article->ID = $ID;
            $this->_article->url = get_the_permalink();
            $this->_article->title = get_the_title();
            $this->_article->excerpt = get_field('excerpt') ? get_field('excerpt') : get_the_excerpt();

            // Setup masthead
            $masthead = get_field('masthead');

            if (count($masthead)) {
                $masthead = $masthead[0];
                $this->_article->masthead = new stdClass();
                $this->_article->masthead->type = $masthead['acf_fc_layout'];
                switch($this->_article->masthead->type) {
                    case 'image': $this->_article->masthead->image = $masthead['image']; break;
                    case 'video': $this->_article->masthead->url = $masthead['video']; break;
                    case 'html': $this->_article->masthead->html = $masthead['html']; break;
                }
            }

            $this->_article->thumbnail = get_field('thumbnail', $ID);
            if (!$this->_article->thumbnail && $this->_article->masthead->type == 'image') {
                $this->_article->thumbnail = $this->_article->masthead->image;
            }
        }

        private function get($name) {
            setup_postdata($this->post);
            if ($name == 'content') {
                return get_the_content();
            }
        }

        public function __get($name) {
            if (property_exists($this->_article, $name)) {
                return $this->_article->$name;
            } else {
                return $this->get($name);
            }

            return null;
        }

        public function __isset($name) {
            // return property_exists($this->_article, $name);
            return true;
        }
    }