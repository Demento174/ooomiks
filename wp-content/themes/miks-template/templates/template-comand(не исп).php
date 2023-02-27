<?php
/**
 * Template Name: Наша команда
 */

get_header();
woocommerce_breadcrumb();
?>

<br>
<hr>
templates / template - command(не исп)
<br>
<hr>

<h2><?php the_title(); ?></h2>

<div class="form-obr-swaz">
	<h1>НАПИСАТЬ ПИСЬМО ДИРЕКТОРУ</h1>
	<form name="form" class="obr-sviaz" action="#" method="post" id="form_message">
		<input class="input-pol" name="name" type="text" placeholder="Ваше имя...*" />
		<input class="input-pol" name="email" type="text" placeholder="Ваш телефон...*" />
		<input class="input-cel" name="subjects" type="text" placeholder="e-mail...*" />
		<textarea class="input-cel" name="message" cols="22" rows="5" placeholder="Текст обращения...*" /></textarea>
		<input id="submit" class="button-swaz for-center-element" value="Отправить" type="submit" />
	</form>
</div>

<div class="contacts-wrapper-opp">
	<div class="contacts-wrapper">

		<?php 
      $worker_cont_one = carbon_get_post_meta( get_the_ID(), 'worker_cont_one' );
         //echo '<pre>'; print_r($worker_cont_one);
        if ( $worker_cont_one ) :
    ?>

		<?php foreach ( $worker_cont_one as $work ) { ?>
		<div class="contacts-block-sotr">
			<div class="contacts-block-photo">
				<?php echo wp_get_attachment_image( $work['worker_photo'], 'medium_img' ); ?>
			</div>

			<div class="contacts-block-fio">
				<?php echo $work['worker_fio']; ?>
			</div>

			<div class="contacts-block-parent">
				<?php echo $work['worker_parent']; ?>
			</div>

			<div class="contacts-block-parent-content">
				<?php foreach ( $work['worker_dop'] as $weeer ) { ?>
				<div class="contacts-block-parent-label">
					<b><?php echo $weeer['worker_tel_em']; ?></b>
					<?php echo $weeer['worker_tel_numb']; ?>
				</div>

				<?php } ?>
			</div>
		</div>
		<?php } endif; ?>
	</div>
</div>
<?php get_footer(); ?>