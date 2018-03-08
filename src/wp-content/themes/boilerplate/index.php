<?php
	$front_page = get_option('page_on_front');
	$front_page_url = _get_page_link($front_page);

    header('Location: ' .$front_page_url);