<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bost-miks
 */

?>
<div class="content__container">
	<div class="wrapper">
		<div class="page__header">
			<h1>
				<?php the_title(); ?>
			</h1>
		</div>
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bost-miks' ),
				'after'  => '</div>',
			)
		);
		?>
		<!-- .entry-content -->

		<?php if ( get_edit_post_link() ) : ?>
		<?php endif; ?>
		<!-- #post-<?php the_ID(); ?> -->
	</div>