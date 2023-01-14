<?php
/**
 * Template Name: Доставка
 */

get_header();

?>
<div class="content__container">
	<div class="wrapper litle">
		<div class="page__header">
			<?php $delivery_dop = get_post_meta( get_the_ID(), '_delivery_dop', true ); ?>
			<h1><?php the_title(); ?></h12>
			<h2><?php echo $delivery_dop ?></h2>
		</div>
		<section class="flex__wrapper__center">
			<?php
            $delivery_complex = carbon_get_post_meta( get_the_ID(), 'delivery_complex' );
            if ( $delivery_dop ) :
                //echo '<pre>'; print_r($slider_work); exit;
            ?>
			<?php foreach ($delivery_complex as $delivery ) { ?>
			<div class="flex__wrapper__center">
				<div class="delivery-left">
					<h2><?php echo $delivery['delivery_title']; ?></h2>
					<p><?php echo $delivery['delivery_text']; ?></p>
				</div>
				<div class="delivery-right">
					<p><?php echo $delivery['delivery_price']; ?></p>
				</div>
			</div>
			<?php  } endif; ?>
		</section>
	</div>
</div>

<?php get_footer(); ?>