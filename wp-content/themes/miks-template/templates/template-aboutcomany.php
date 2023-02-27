<?php
/**
 * Template Name: О компании
 */
get_header();
?>
<div class="content__container">
	<div class="wrapper litle">
		<div class="page__header">
			<h1><?php the_title(); ?></h1>
			<h2>информация о компании</h2>
		</div>
		<?php
            $about_title = get_post_meta( get_the_ID(), '_about_title', true );
            $about_disc = get_post_meta( get_the_ID(), '_about_disc', true );
            $about_after_desc = get_post_meta( get_the_ID(), '_about_after_desc', true );
            $about_company = carbon_get_post_meta( get_the_ID(), 'about_company' );
            if ( $about_title && $about_disc ) :
                //echo '<pre>'; print_r($slider_work); exit;
            ?>
		<div class="aboutus__text">
			<?php echo apply_filters( 'the_content', carbon_get_the_post_meta( 'about_disc' ) ); ?>
		</div>
		<div class="aboutus__image">
			<?php foreach ($about_company as $about ) { ?>
			<div class="aboutus__image__content">
				<div class="aboutus__image__block">
					<?php echo wp_get_attachment_image( $about['photo_company'], 'medium_img' ); ?>
				</div>
				<div class="about__image__text">
					<?php echo $about['text_pod_photo']; ?>
				</div>
			</div>

			<?php  } endif; ?>
		</div>

		<div class="aboutus__text">
			<?php echo apply_filters( 'the_content', carbon_get_the_post_meta( 'about_after_desc' ) ); ?>
		</div>

		<?php 
            $miks_ur_adress = get_post_meta( get_the_ID(), '_miks_ur_adress', true );
            $miks_phone = get_post_meta( get_the_ID(), '_miks_phone', true );
            $miks_inn = get_post_meta( get_the_ID(), '_miks_inn', true );
            $miks_kpp = get_post_meta( get_the_ID(), '_miks_kpp', true );
            $miks_ogrul = get_post_meta( get_the_ID(), '_miks_ogrul', true );
            $miks_okpo = get_post_meta( get_the_ID(), '_miks_okpo', true );
            $miks_okato = get_post_meta( get_the_ID(), '_miks_okato', true );
            $miks_bank = get_post_meta( get_the_ID(), '_miks_bank', true );
            $miks_schet = get_post_meta( get_the_ID(), '_miks_schet', true );
            $miks_korschet = get_post_meta( get_the_ID(), '_miks_korschet', true );
            $miks_bik = get_post_meta( get_the_ID(), '_miks_bik', true );
            ?>
		<div class="aboutus__text">
			<h2>Реквизиты компании</h2>
		</div>
		<table class="about-table">
			<tr>
				<td>Юридический и почтовый адрес ООО «МИКСС»</td>
				<td><?php echo $miks_ur_adress ?></td>
			</tr>
			<tr>
				<td>Телефон, e-mail</td>
				<td><?php echo $miks_phone ?></td>
			</tr>
			<tr>
				<td>ИНН</td>
				<td><?php echo $miks_inn ?></td>
			</tr>
			<tr>
				<td>КПП</td>
				<td><?php echo $miks_kpp ?></td>
			</tr>
			<tr>
				<td>ОГРЮЛ</td>
				<td><?php echo $miks_ogrul ?></td>
			</tr>
			<tr>
				<td>ОКПО</td>
				<td><?php echo $miks_okpo ?></td>
			</tr>
			<tr>
				<td>ОКАТО</td>
				<td><?php echo $miks_okato ?></td>
			</tr>
			<tr>
				<td>Наименование банка</td>
				<td><?php echo $miks_bank ?></td>
			</tr>
			<tr>
				<td>Расчетный счет</td>
				<td><?php echo $miks_schet ?></td>
			</tr>
			<tr>
				<td>Корреспондирующий счет</td>
				<td><?php echo $miks_korschet ?></td>
			</tr>
			<tr>
				<td>БИК</td>
				<td><?php echo $miks_bik ?></td>
			</tr>
		</table>

		<div class="aboutus__download">
			<h3>Скачать реквизиты компании:</h3>
			<?php $weweq = carbon_get_the_post_meta( 'crb_price_list' ); ?>
			<a href="<?php echo wp_get_attachment_url( $weweq ); ?>">Наши реквизиты</a>
		</div>
		<?php /*
            <div class="contacts__sotr__wrapper">
                <?php $worker_titlt = get_post_meta( get_the_ID(), '_worker_titlt', true ); ?>
		<h2><?php echo $worker_titlt ?></h2>
		<div class="contacts__sotr__body">
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
	*/ ?>
</div>
</div>
</div>
<?php get_footer(); ?>