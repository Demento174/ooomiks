<?php
/**
 * Template Name: С сайтбаром
 */

get_header();
?>
<br><hr>
templates / template - sidebar-yes
<br><hr>
    <main id="primary" class="site-main">
        <?php
        while ( have_posts() ) :
            the_post();
            
            woocommerce_breadcrumb();

            get_template_part( 'template-parts/content', 'page' );

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;

        endwhile; // End of the loop.
        ?>
    </main><!-- #main -->

<?php

get_footer();