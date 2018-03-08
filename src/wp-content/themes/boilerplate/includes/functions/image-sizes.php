<?php 
    /*  
        If false (default), images will be scaled, not cropped.
        If true, images will be cropped to the specified dimensions using center positions. 
    */
    add_image_size('logo', 400, 70, false);

    add_image_size('thumbnail-preview', 150, 100, true);
    add_image_size('thumbnail-lazy', 3, 2, true);
    add_image_size('thumbnail', 300, 200, true);

    add_image_size('carousel-lazy', 3, 2, true);
    add_image_size('carousel', 300, 200, true);

    add_image_size('hero', 2000, 600, true);
    add_image_size('hero-mobile', 500, 300, true);
    add_image_size('hero-lazy', 20, 6, true);
    add_image_size('hero-preview', 200, 60, true);