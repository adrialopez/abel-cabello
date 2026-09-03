<?php
get_header();
while ( have_posts() ) : the_post();
    echo '<div class="container legal" style="padding-top:160px;">';
    the_title( '<h1>', '</h1>' );
    the_content();
    echo '</div>';
endwhile;
get_footer();
