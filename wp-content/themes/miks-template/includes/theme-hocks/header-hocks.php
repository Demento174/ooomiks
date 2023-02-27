<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Блок информации о комапнии в шапке сайта
add_action( 'header_parts', 'miks_header_socials_new', 10 );
function miks_header_socials_new() {
	get_template_part( '/includes/template-custom/header/header-socials' );
}

// Логотип / поиск / карзина 
add_action( 'header_parts', 'header_logo_search_cart', 20 );
function header_logo_search_cart() {
	get_template_part( '/includes/template-custom/header/header-lsc' );
}

// Навигация в шапке сайта
add_action( 'header_parts', 'header_nav', 30 );
function header_nav() {
	get_template_part( '/includes/template-custom/header/header-nav' );
}