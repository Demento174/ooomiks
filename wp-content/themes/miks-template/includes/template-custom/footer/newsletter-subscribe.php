<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="newsletter-container">

	<div class="newsletter-container-content">
		<h2>Подпишитесь на рассылку новостей!</h2>
		<p>Оставайтесь всегда в курсе новостей нашего интернет магазина!</p>
	</div>

	<div class="newsletter-container-content">
      <?=do_shortcode('[contact-form-7 id="227793" title="Подписаться на новости"]') ?>
	</div>
</div>