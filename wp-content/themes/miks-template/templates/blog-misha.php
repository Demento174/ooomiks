<?php
/*
 * Template name: Блог-MISHA
 * Template Post type: Post
 */
get_header();
?>

<div class="content__container">
	<?php
			while (have_posts()) { 
			the_post();
			?>


	<div class="blog__open__comntainer">

		<div class="blog__open__img">
			<?php the_post_thumbnail() ?>

		</div>
		<div class="blog__open__contain">
			<div class="blog__open__title">
				<h2><?php the_title() ?></h2>

				<div class="blog__open__footer">
					<div class="blog__open__date">
						<?php the_date(); /* дата */ ?>
					</div>
					<div class="blog__open__author">
						<?php the_author(); ?>
					</div>
					<div class="blog__open__roub">
						<?php the_category(); /* рубрика */ ?></b>
					</div>
				</div>
			</div>
			<div class="blog__open__block">
				<div class="blog__open__text">
					<?php the_content() /* содержимое поста */ ?>
				</div>

			</div>
		</div>
		<?php if ( is_active_sidebar( 'sidebar_blog' ) ) : ?>

		<div class="sidebar__blog">

			<?php dynamic_sidebar( 'sidebar_blog' ); ?>

		</div>
	</div>
	<?php endif; ?>

	<?php } ?>

	<?php get_footer() ?>