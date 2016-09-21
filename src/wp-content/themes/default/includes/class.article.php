<?php

    class Article {

        private $_article;

        public function __construct($ID) {
            $this->_article = (object) array();

            $this->_article->ID = $ID;
            $this->_article->url = get_the_permalink($ID);
            $this->_article->title = get_the_title($ID);
            $this->_article->excerpt = get_field('excerpt', $ID) ? get_field('excerpt', $ID) : get_the_excerpt($ID);

            // Setup masthead
            $masthead = get_field('masthead', $ID);

            if (count($masthead)) {
                $masthead = $masthead[0];
                $this->_article->masthead = new stdClass();
                $this->_article->masthead->type = $masthead['acf_fc_layout'];
                switch($this->_article->masthead->type) {
                    case 'image': $this->_article->masthead->url = $masthead['image']; break;
                    case 'video': $this->_article->masthead->url = $masthead['video']; break;
                    case 'html': $this->_article->masthead->html = $masthead['html']; break;
                }
            }

            $this->_article->thumbnail = get_field('thumbnail', $ID);
            if (!$this->_article->thumbnail && $this->_article->masthead->type == 'image') {
                $this->_article->thumbnail = $this->_article->masthead->url;
            }
        }

        public function __get($name) {
            if (property_exists($this->_article, $name)) {
                return $this->_article->$name;
            }

            return null;
        }

        public function __isset($name) {
            return property_exists($this->_article, $name);
        }
    }