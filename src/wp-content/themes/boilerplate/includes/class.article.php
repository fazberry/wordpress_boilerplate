<?php

    class Article {

        private $_article;

        public function __construct($ID) {
            global $post;

            $this->post = $post;

            $this->_article = (object) array();

            $this->_article->ID = $ID;
            $this->_article->type = get_post_type($ID);
            $this->_article->url = get_the_permalink($ID);
            $this->_article->title = get_the_title($ID);
            $this->_article->excerpt = get_field('excerpt', $ID);

            // Categories
            $this->_article->category = get_the_category($ID);

            // Tags
            $this->_article->tags = get_the_category($ID);

            // Posted
            $this->_article->date = get_the_date(null, $ID);

            // If no custom excerpt generate one from the post content
            if (!$this->_article->excerpt) {
                $content = get_post_field('post_content', $ID);
                $content = strip_shortcodes($content);
                $content = preg_replace("/\r|\n/", " ", $content);
                $this->_article->excerpt = apply_filters('the_excerpt', $content);
            }
            $this->_article->excerpt = $this->trimWord($this->_article->excerpt, 20);

            $this->_article->layouts = get_field('layout_selector', $ID);

            // Setup hero
            $hero = get_field('hero', $ID);

            if (count($hero)) {
                $hero = $hero[0];
                $this->_article->hero = new stdClass();
                $this->_article->hero->type = $hero['acf_fc_layout'];
                switch($this->_article->hero->type) {
                    case 'image':
                        $this->_article->hero->image = $hero['image'];
                        break;
                    case 'video':
                        $this->_article->hero->video = wp_get_attachment_url($hero['video']);
                        $this->_article->hero->image = get_field('thumbnail', $ID);
                        break;
                    case 'html':
                        $this->_article->hero->html = $hero['html'];
                        break;
                }
            }

            $this->_article->thumbnail = get_field('thumbnail', $ID);
            if (!$this->_article->thumbnail && isset($this->_article->hero) && $this->_article->hero->type == 'image') {
                $this->_article->thumbnail = $this->_article->hero->image;
            }
        }

        private function get($name) {
            if ($name == 'content') {
                return apply_filters('the_content', get_post_field('post_content', $this->post->ID));
            } else if ($name == 'siblings') {
                return $this->getSiblings();
            } else {
                return get_field($name, $this->post->ID);
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
            return true;
        }

        public function getSiblings() {
            $siblings = array();

            if ($this->_article->type == 'page') {
                $pages = get_pages(array(
                    'child_of' => $this->post->post_parent,
                    'parent' => $this->post->post_parent,
                    'sort_column' => 'menu_order'
                ));
                foreach ($pages as $key=>$p) {
                    if ($this->post->ID == $p->ID) {
                        $ID = $key;
                    }
                }

                if (array_key_exists($ID - 1, $pages) && $pages[$ID-1]->ID) {
                    $siblings['before'] = new Article($pages[$ID-1]->ID);
                }
                if (array_key_exists($ID + 1, $pages) && $pages[$ID+1]->ID) {
                    $siblings['after'] = new Article($pages[$ID+1]->ID);
                }
            } else {
                $next = get_next_post(true);
                if ($next) {
                    $siblings['before'] = new Article($next->ID);
                }
                $previous = get_previous_post(true);
                if ($previous) {
                    $siblings['after'] = new Article($previous->ID);
                }
            }

            return $siblings;
        }

        private function trimWord($text, $wordCount) {
            if (str_word_count($text, 0) > $wordCount) {
                $words = str_word_count($text, 2);
                $pos = array_keys($words);
                $text = substr($text, 0, $pos[$wordCount]) . '...';
            }
            return $text;
        }
    }