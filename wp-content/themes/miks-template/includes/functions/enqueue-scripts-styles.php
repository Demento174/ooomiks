<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

add_action( 'wp_enqueue_scripts', 'add_scripts_and_styles' );


function add_scripts_and_styles() {
	/* Откл вуком стилей */
	wp_dequeue_style( 'woocommerce-general' );
	wp_dequeue_style( 'woocommerce-layout' );
	wp_dequeue_style( 'font-awesome' );

// Стили для сайта
	wp_enqueue_style( 'reset-style', get_template_directory_uri() . '/assets/css/reset.css', false, '1.8',
	'all' );
	wp_enqueue_style( 'main', get_stylesheet_uri(), array('reset-style'), '1.8',
	'all' );
	wp_enqueue_style( 'miks-icons', get_template_directory_uri() . '/assets/css/miks-icons.css', array( 'main' ), '1.8', 'all' );
	wp_enqueue_style( 'miks-style', get_template_directory_uri() . '/assets/css/miks-style.css', array( 'miks-icons' ), '1.8',
	'all' );
	wp_enqueue_style( 'menue-style', get_template_directory_uri() . '/assets/css/menue-style.css', array( 'miks-icons' ), '1.8',
	'all' );
	wp_enqueue_style( 'miks-pages', get_template_directory_uri() . '/assets/css/miks-pages.css', array( 'miks-style' ), '1.8',
	'all' );
		wp_enqueue_style( 'miks-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce-miks.css', array( 'miks-style' ), '1.8',
	'all' );

// Главная страница
if( is_front_page() ){
	wp_enqueue_style( 'simple-adaptive-slider', get_template_directory_uri() . '/assets/css/simple-adaptive-slider.min.css', array( 'miks-icons'
	), '1.8', 'all' );
	 wp_enqueue_script( 'slider-script', get_template_directory_uri() . '/assets/js/slider-scripts.js', array( 'jquery'), '1.8',
	'footer');
	wp_enqueue_script( 'simple-adaptive-slider', get_template_directory_uri() . '/assets/js/simple-adaptive-slider.dev.js',
	array( 'slider-script'), '1.8', 'footer');
}
// Корзина
if ( is_page('cart') ){
	wp_enqueue_script( 'checkout-fields', get_template_directory_uri() . '/assets/js/checkout-fields.js', array(
	'burger-nav'), '1.8', 'footer');
}
if ( is_page('checkout') ){
	wp_enqueue_script( 'checkout-fields', get_template_directory_uri() . '/assets/js/checkout-fields.js', array(
	'burger-nav'), '1.8', 'footer');
}

// Мой аккаунт
if ( is_page('my-account') ){
		wp_enqueue_style( 'miks-lk-style', get_template_directory_uri() . '/assets/css/miks-lk-style.css', array( 'miks-pages'
	), '1.8', 'all' );
}
	//wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery-burger', get_template_directory_uri() . '/assets/js/jquery-burger.js', false, '1.8', 'footer', true );
	//wp_register_script( 'jquery-mini-1', get_template_directory_uri() . '/assets/js/jquery.min.js', false, '1.8','footer', true );
	wp_enqueue_script( 'jquery-burger' );
	//wp_enqueue_script( 'jquery-mini-1' );
	wp_enqueue_script( 'burger-nav', get_template_directory_uri() . '/assets/js/burger-nav.js', array( 'jquery'), '1.8',
	'footer');
	wp_enqueue_script( 'drop-menue', get_template_directory_uri() . '/assets/js/drop-menue.js', array( 'jquery'), '1.8',
	'footer');

	// Адаптивные стили
	wp_enqueue_style( 'pc-style', get_template_directory_uri() . '/assets/css/pc-style.css', array( 'miks-pages' ), '1.8',
	'(max-width: 1295px)' );
	wp_enqueue_style( 'pads-style', get_template_directory_uri() . '/assets/css/pads-style.css', array( 'miks-pages' ), '1.8',
	'(max-width: 767.98px)' );
	wp_enqueue_style( 'phone-style', get_template_directory_uri() . '/assets/css/phone-style.css', array( 'miks-pages' ), '1.8',
	'(max-width: 479.98px)' );

/*
	wp_localize_script('ajax-search', 'search_form', array(
		'url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('search-nonce')
	));
*/
}
?>