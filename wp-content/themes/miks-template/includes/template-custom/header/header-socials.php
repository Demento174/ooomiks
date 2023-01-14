<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="header__contactst">
	<div class="header__contacts__body _container">
		<div class="hrader__contacts__phone">
			<a href="tel: +88002000156">8(800)-200-01-56</a> <br><span>звонок бесплатный</span>
		</div>
		<div class="header__contacts__adress">
			Челябинск, Краснознаменная, 28.
		</div>
		<div class="header__contacts__times">
			ПН-ПТ с 8:30 - 18:00
		</div>
		<div class="header__contacrts__social">
			<?php
		// Get all entered urls from the database
		$social_links = carbon_get_theme_option( 'crb_social_urls' );
		foreach ( $social_links as $link ) {
			echo '<a href="' . esc_url( $link['url'] ) . '" target="_blank" class="header__href">' . wp_get_attachment_image( $link['image'] ) . '</a>';
		}
		?>
		</div>
	</div>
</div>