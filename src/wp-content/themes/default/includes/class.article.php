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
                    case 'image':
                        $this->_article->masthead->image = $masthead['image'];
                        break;
                    case 'video':
                        $this->_article->masthead->video = wp_get_attachment_url($masthead['video']);
                        $this->_article->masthead->image = get_field('thumbnail', $ID);
                        break;
                    case 'html':
                        $this->_article->masthead->html = $masthead['html'];
                        break;
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

        public function getSiblings($issueBased) {

            if($issueBased) {
                $siblings = get_pages(array(
                    'child_of' => $this->post->post_parent,
                    'parent' => $this->post->post_parent,
                    'sort_column' => 'menu_order'
                ));
                foreach ($siblings as $key=>$sibling) {
                    if ($this->post->ID == $sibling->ID) {
                        $ID = $key;
                    }
                }

                $return = array();
                if (array_key_exists($ID - 1, $siblings) && $siblings[$ID-1]->ID) {
                    $return['before'] = new Article($siblings[$ID-1]->ID);
                }
                if (array_key_exists($ID + 1, $siblings) && $siblings[$ID+1]->ID) {
                    $return['after'] = new Article($siblings[$ID+1]->ID);
                }

                return $return;
            }
        }
    }