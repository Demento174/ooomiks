<?php
/**
 * Template Name: Главная страница
 */
get_header();
?>
<div class="slider__background">
	<div class="__container">
		<?php
        $slider_work = carbon_get_post_meta( get_the_ID(), 'slider_work' );
        if ( $slider_work ) :
            //echo '<pre>'; print_r($slider_work); exit;
        ?>

		<div class="slider">
			<div class="slider__wrapper">
				<div class="slider__items">
					<?php foreach ($slider_work as $slide ) { ?>
					<div class="slider__item">
						<div class="slider_title">
							<h2><?php echo $slide['photo_title']; ?></h2>
						</div>
						<div class="slider_text">
							<p><?php echo $slide['photo_disc']; ?></p>
						</div>

						<div class="image-div">
							<?php echo wp_get_attachment_image( $slide['photo_slide'], 'medium_img' ); ?>
						</div>
					</div>
					<?php  } endif; ?>
				</div>
			</div>
			<a class="slider__control slider__control_prev" href="#" role="button" data-slide="prev"></a>
			<a class="slider__control slider__control_next" href="#" role="button" data-slide="next"></a>
		</div>
	</div>
</div>
<?php
	$front_plus_photo = get_post_meta( get_the_ID(), '_front_plus_photo', true );
	$front_plus_title = get_post_meta( get_the_ID(), '_ront_plus_title', true );
	$front_plus = carbon_get_post_meta( get_the_ID(), 'front_plus' );
	if ( $front_plus ) :
	//echo '<pre>'; print_r($slider_work); exit;
?>
<div class="index__page__short__about">
	<div class="plus__container">
		<?php foreach ($front_plus as $plus ) { ?>
		<div class="plus__block">
			<div class="plus__block__image">
				<?php echo wp_get_attachment_image( $plus['front_plus_photo'], 'nazvanie-moego_razmera effect_shake' ); ?>
			</div>
			<div class="plus__block__right">
				<div class="plus__block__title">
					<?php echo $plus['front_plus_title']; ?>
				</div>
				<div class="plus__block__text">
					<?php echo $plus['front_plus_text']; ?>
				</div>
			</div>
		</div>
		<?php  } endif; ?>
	</div>
</div>


<?php
	$front_block_photo = get_post_meta( get_the_ID(), '_front_block_photo', true );
	$front_block_title = get_post_meta( get_the_ID(), '_front_block_title', true );
	$front_block_url = get_post_meta( get_the_ID(), '_front_block_url', true );
	
	$front_block = carbon_get_post_meta( get_the_ID(), 'front_block' );
	if ( $front_block ) :
	//echo '<pre>'; print_r($front_block); exit;
?>

<div class="block__categories _container">
	<?php foreach ($front_block as $block ) { ?>
	<div class="block__categories__img">
		<?php echo wp_get_attachment_image( $block['front_block_photo'], 'thumbnail_imag image__scale' ); ?>
		<div class="block__categories__text">
			<a href="<?php echo $block['front_block_url']; ?>" target="_blank" class="block__categories__link"><?php echo $block['front_block_title']; ?></a>
		</div>
	</div>
	<?php  } endif; ?>
</div>

<div class="content__container">
	<div class="content__index__page">
		<div class="wrapper">
			<?php
			the_content();
			?>
		</div>
	</div>
</div>

<?php
get_footer();