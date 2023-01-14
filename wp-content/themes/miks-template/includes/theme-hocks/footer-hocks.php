<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'footer_parts', 'footer', 70 );
function footer() {
	get_template_part( '/includes/template-custom/footer/footer' );
}

add_action( 'miks_newsletter_subscribes', 'miks_newsletter_subscribe', 10 );
function miks_newsletter_subscribe() {
	get_template_part( '/includes/template-custom/footer/newsletter-subscribe' );
}

?>