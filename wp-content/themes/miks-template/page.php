<?php get_header(); ?>
<?php
		while ( have_posts() ) :
			the_post();
			
			//woocommerce_breadcrumb();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

<!-- #main -->
<?php //get_sedebar(); ?>
<?php get_footer(); ?>