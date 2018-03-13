<?php

    class Search {

        public $results;
        public $term;

        public function __construct() {
            // Get results
            $this->getResults();

            // relevanssi_didyoumean(get_search_query(), "<p>Did you mean: ", "</p>", 5);
        }

        private function getResults() {
            global $wp_query;
            global $post;

            $this->resultCount = $wp_query->found_posts;

            $this->results = array();
            if (have_posts()): 
                while (have_posts()): the_post();
                    // print_r($post);
                    $article = new Article($post->ID);
                    array_push($this->results, $article);
                endwhile;
            endif;
        }

    }