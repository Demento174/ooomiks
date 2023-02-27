<?php
/**
 * Template Name: Оплата
 */
get_header();
?>

<?php  $pay_title = get_post_meta( get_the_ID(), '_pay_title', true ); ?>
<div class="content__container">
	<div class="wrapper litle">
		<div class="page__header">
			<h2><?php the_title(); ?></h2>
			<h3><?php echo $pay_title; ?></h3>
		</div>

		<?php
        $pay_text = get_post_meta( get_the_ID(), '_pay_text', true );

        $pay_complex = carbon_get_post_meta( get_the_ID(), 'pay_complex' );
        if ( $pay_title ) :
            //echo '<pre>'; print_r($slider_work); exit;
        ?>
		<div class="flex__wrapper__column pay">
			<?php foreach ($pay_complex as $pays ) { ?>
			<h2><?php echo $pays['pay_complex_title']; ?></h2>
			<p><?php echo $pays['pay_complex_text']; ?></p>
			<?php  } endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>