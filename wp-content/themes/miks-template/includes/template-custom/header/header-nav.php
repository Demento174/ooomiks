<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="header__nav__background">

						<div class="header__menue__nav__body">
							<nav class="header__menus _container">

								<? 

// свой класс построения меню:
// свой класс построения меню:
class My_Walker_Nav_Menu extends Walker_Nav_Menu {

	// add classes to ul sub-menus 
  // добавить классы в подменю ul
	function start_lvl( &$output, $depth = 0, $args = NULL ) {
		// depth dependent classes
    // классы, зависящие от глубины
    $indent = ( $depth > 1  ? str_repeat( "\t", $depth ) : '<span class="menu__arrow icon-icon-arow-down arrow"></span>' ); // code indent / отступ кода
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0 /потому что он считает первое подменю равным 0
		$classes = array(

			( $display_depth % 2  ? 'sub-menu__list' : 'sub-sub-menu__list' ),
			( $display_depth >=2 ? '' : '' )
		);
   
		$class_names = implode( ' ', $classes );

		// build html
    // построить html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}

	// add main/sub classes to li's and links
  // добавляем основные/подклассы в линукс и ссылки
	function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		global $wp_query;

		// Restores the more descriptive, specific name for use within this method.
    // Восстанавливает более описательное, конкретное имя для использования в этом методе.
		$item = $data_object;

		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		// depth dependent classes
    // классы, зависящие от глубины
		$depth_classes = array(
			( $depth == 0 ? '' : '' ),
			( $depth >=2 ? '' : '' ),
			( $depth % 2 ? '' : '' )
		);
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );



		// passed classes
    // пройденные классы
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

		// build html
		$output .= $indent . '<li>';

		// link attributes
    // атрибуты ссылки
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ' class=" ' . ( $depth > 0 ? 'sub-menu__link' : 'menu__link' ) . '"';

		$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			$args->before,
			$attributes,
			$args->link_before,
			apply_filters( 'the_title', $item->title, $item->ID ),
			$args->link_after,
			$args->after
		);

		// build html
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

}
  
  wp_nav_menu( [
						'menu'              => '', // ID, имя или ярлык меню
            'container'         => 'nav', // тег контейнера или false, если контейнер не нужен
						'container_class'   => 'menu', // класс контейнера
						'menu_class'        => 'menu__list', // класс элемента <ul>
						'menu_id'           => '', // id элемента <ul>
						'container_id'      => '', // id контейнера
						'fallback_cb'       => 'wp_page_menu', // колбэк функция, если меню не существует
						'before'            => '', // текст (или HTML) перед <a
						'after'             => '', // текст после </a>
						'link_before'       => '', // текст перед текстом ссылки
						'link_after'        => '', // текст после текста ссылки
						'echo'              => true, // вывести или вернуть
						'depth'             => 0, // количество уровней вложенности
						'walker'            => new My_Walker_Nav_Menu(), // объект Walker
						'theme_location'    => 'header-menu',// область меню
						'items_wrap'        => '<ul class="%2$s">%3$s</ul>',
						'item_spacing'      => 'preserve',
						]  ); ?>

							</nav>
	</div>
</div>