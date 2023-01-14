<div class="wrapper">
	<div class="footer__container">
		<div class="footer__block">
			<div class="fooner__block__prod">
				<? wp_nav_menu( [
				'menu'              => '', // ID, имя или ярлык меню
				'menu_class'        => '', // класс элемента <ul>
				'menu_id'           => '', // id элемента <ul>
				'container'         => 'false', // тег контейнера или false, если контейнер не нужен
				'container_class'   => '', // класс контейнера
				'container_id'      => '', // id контейнера
				'fallback_cb'       => 'wp_page_menu', // колбэк функция, если меню не существует
				'before'            => '', // текст (или HTML) перед <a
				'after'             => '', // текст после </a>
				'link_before'       => '', // текст перед текстом ссылки
				'link_after'        => '', // текст после текста ссылки
				'echo'              => true, // вывести или вернуть
				'depth'             => 0, // количество уровней вложенности
				'walker'            => '', // объект Walker
				'theme_location'    => 'footer-menu-prod', // область меню
				'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'item_spacing'      => 'preserve',
				]  ); ?>
			</div>

			<div class="fooner__block__prod__dop">
				<? wp_nav_menu( [
				'menu'              => '', // ID, имя или ярлык меню
				'menu_class'        => '', // класс элемента <ul>
				'menu_id'           => '', // id элемента <ul>
				'container'         => 'false', // тег контейнера или false, если контейнер не нужен
				'container_class'   => '', // класс контейнера
				'container_id'      => '', // id контейнера
				'fallback_cb'       => 'wp_page_menu', // колбэк функция, если меню не существует
				'before'            => '', // текст (или HTML) перед <a
				'after'             => '', // текст после </a>
				'link_before'       => '', // текст перед текстом ссылки
				'link_after'        => '', // текст после текста ссылки
				'echo'              => true, // вывести или вернуть
				'depth'             => 0, // количество уровней вложенности
				'walker'            => '', // объект Walker
				'theme_location'    => 'footer-menu-prod2', // область меню
				'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'item_spacing'      => 'preserve',
				]  ); ?>
			</div>
		</div>
		<div class="footer__block__subscribe">
			<div class="footer__mail">
				<?php do_action('miks_newsletter_subscribes'); ?>
			</div>
			<div class="footer__socials">
				<?php
				// Get all entered urls from the database
				$social_links = carbon_get_theme_option( 'crb_social_urls' );
				foreach ( $social_links as $link ) {
					echo '<a class="footer__socials__link" href="' . esc_url( $link['url'] ) . '" target="_blank">' . wp_get_attachment_image( $link['image'] ) . '</a>';
				}
				?>
			</div>
		</div>
	</div>
	<div class="footer__container">
		<div class="footer__nav__map">
			<? wp_nav_menu(array('menu' => 'footer-menu-prod3', 'menu_class' => 'footer-menue')); ?>
		</div>
	</div>
	<div class="footer__container footer__button">
		<div class="footer__copy">
			<?php
			// График работы и телефон
			$crb_copyright_footer = carbon_get_theme_option( 'crb_copyright_footer' );

			echo $crb_copyright_footer;
			?>
		</div>
		<div class="footer__paymethod">
			<?php
			// Get all entered urls from the database
			$footer_pay = carbon_get_theme_option( 'footer-pay' );
			foreach ( $footer_pay as $fpay ) {
				echo '<div class="footer__pay__image"><a href="' . esc_url( $fpay['url_pay'] ) . '" target="_blank">' . wp_get_attachment_image( $fpay['image_pay'] ) . '</a></div>';
			}
			?>
		</div>

	</div>
</div>