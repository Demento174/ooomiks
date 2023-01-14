<?php
/**
 * Template Name: Самодельный блог
 */
get_header();
?>

<div class="content__container">
	<div class="wrapper">
		<div class="page__header">
			<h2><?php the_title(); ?></h2>
		</div>
		<div class="content__container__body blog">
			<?php

            $current_page = (get_query_var('paged')) ? get_query_var('paged') : 1; // определяем текущую страницу блога
            $args = array(
                'posts_per_page' => get_option('posts_per_page'), // значение по умолчанию берётся из настроек, но вы можете использовать и собственное
                'paged'          => $current_page // текущая страница
            );
            query_posts( $args );
            
            $wp_query->is_archive = true;
            $wp_query->is_home = false;
            
            while(have_posts()): the_post();
                ?>

			<div class="blog__continer">
				<div class="blog__article__img">
					<?php the_post_thumbnail() ?>
				</div>
				<div class="blog__article__container">
					<div class="blog__article__title">
						<h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
					</div>
					<div class="blog__article__text">
						<?php the_excerpt() /* содержимое поста */ ?>
					</div>
					<div class="blog__article__footer">
						<div class="blog__article__date">
							<?php the_date(); /* дата */ ?>
						</div>
						<div class="blog__article__author">
							<?php the_author(); ?>
						</div>


					</div>
					<div class="blog__article__bot">
						<a class="button" href="<?php the_permalink() ?>">Читать далее</a>
					</div>
				</div>
			</div>

			<?php
                endwhile;
                if( function_exists('wp_pagenavi') ) wp_pagenavi(); // функция постраничной навигации
                ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>