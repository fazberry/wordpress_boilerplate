<?php 
    /*  
        If false (default), images will be scaled, not cropped.
        If true, images will be cropped to the specified dimensions using center positions. 
    */

    add_image_size('thumbnail_lazy', 3, 2, true);
    add_image_size('thumbnail', 300, 200, true);
    add_image_size('masthead', 2000, 600, true);
    add_image_size('masthead_lazy', 20, 6, true);