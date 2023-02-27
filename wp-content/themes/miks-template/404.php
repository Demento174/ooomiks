<?php get_header(); ?>

<div class="content__container">
	<div class="wrapper litle">
		<div class="page__header">
			<h1>Извините! Страница не нейдена!</h1>
		</div>

		<div class="page__warning">
			<p>Мы недавно обновили сайт, возможно это явилось причиной изменения старой ссылки!</p>
			<p>Пожалуйста, не расстаивайтесь! Вы можете найти интересющий товар в поиске, либо в каталоге товаров!</p>
			<a class="warning__catalog" href="/shop">Перейти в каталог товаров</a>

			<div class="warning__search">
				<?php get_search_form(); ?>
			</div>
		</div>



	</div>
</div>

<?php get_footer(); ?>