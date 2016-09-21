<?php

    class Article {

        private $_article;

        public function __construct($ID) {
            $this->_article = (object) array();

            $this->_article->ID = $ID;
            $this->_article->url = get_the_permalink($ID);
            $this->_article->title = get_the_title($ID);
            $this->_article->excerpt = get_field('excerpt') ? get_field('excerpt') : get_the_excerpt($ID);

            $this->_article->thumbnail = get_field('thumbnail', $ID);
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