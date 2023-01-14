<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bost-miks
 */

?>
<?php get_header(); ?>

<div class="content__container">
	<div class="wrapper blog__open">
		<div class="blog__news__wrapper">
			<div class="blog__news__container">
				<div class="blog__news__image__block">
					<?php
while (have_posts()) { 
	the_post();
	?>

					Вывод контента...
					<h1><?php the_title(); ?></h1>
					<div class="blog__article__roub">
						<?php the_category(); /* рубрика */ ?>
					</div>
					<div class="blog__article__author">
						Автор записи: <?php the_author(); ?>
					</div>
					<div class="blog__article__date">
						<?php the_date(); /* дата */ ?>
					</div>
					<div class="blog__article__roub">
						<?php the_category(); /* рубрика */ ?>
					</div>
					<div class="blog__article__text">
						<?php the_excerpt() /* содержимое поста */ ?>
					</div>
					<?php
}
?>
				</div>
			</div>
		</div>
	</div>

	<?php get_footer(); ?>