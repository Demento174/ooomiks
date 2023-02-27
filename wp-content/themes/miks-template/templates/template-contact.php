<?php
/**
 * Template Name: Контакты
 */
get_header();
?>
<div class="content__container">
	<div class="wrapper litle">
		<div class="page__header">
			<?php $contacts_dop = get_post_meta( get_the_ID(), '_contacts_dop', true ); ?>
			<h1><?php the_title(); ?></h1>
			<h2><?php echo $contacts_dop ?></h2>
		</div>
		<div class="content__container__body contacts">
			<?php
		$contacts_magazine_title = carbon_get_post_meta( get_the_ID(), 'contacts_magazine_title' );
		$contacts_magazine = carbon_get_post_meta( get_the_ID(), 'contacts_magazine' );
		$contacts_title = get_post_meta( get_the_ID(), '_contacts_title', true );
		?>
			<section class="contacts__adress">
				<h2><?php echo $contacts_title ?></h2>
				<?php foreach ($contacts_magazine as $contacts ) { ?>
				<div class="contacts__adress_wrapper">
					<div class="contacts__adress__image">
						<?php echo wp_get_attachment_image( $contacts['contacts_magazine_photo'], 'medium_img' ); ?>
					</div>
					<div class="contacts__adress__text">
						<h3><?php echo $contacts['contacts_magazine_title']; ?></h3>
						<p><?php echo $contacts['contacts_magazine_text']; ?></p>
					</div>
				</div>
				<?php } ?>
			</section>

			<div class="contacts__map">
				<iframe
					src="https://yandex.ru/map-widget/v1/?um=constructor%3A65af00476f2d2ca90359db53cadd559f1b80b10d22bfc518de4509b7c441f8a2&amp;source=constructor"
					width="100%" height="420" frameborder="0"></iframe>
			</div>



			<?php 
		$contacts_letter = get_post_meta( get_the_ID(), '_contacts_letter', true );
		$contacts_letter_text = get_post_meta( get_the_ID(), '_contacts_letter_text', true );
		?>
			<section class="contacts__forms">
				<h2><?php echo $contacts_letter ?></h2>
				<p><?php echo $contacts_letter_text ?></p>
				<form name="form" class="contacts__sviaz__form" action="" method="post" id="form_message">
					<input class="input-pol" name="name" type="text" placeholder="Ваше имя...*" />
					<input class="input-pol" name="phone" type="text" placeholder="Ваш телефон...*" />
					<input class="input-cel" name="email" type="text" placeholder="e-mail...*" />
					<textarea class="input-cel" name="message" cols="22" rows="5"
						placeholder="Текст обращения...*"></textarea>
					<input id="submit" class="button-swaz for-center-element" value="Отправить" type="submit" />
				</form>

				<!-- Начался блок PHP -->

				<?php
              # Если кнопка нажата
              if( isset( $_POST['submit'] ) )
              {
                  // Получаем значения переменных из пришедших данных
          $name = $_POST['name'];
          $phone = $_POST['phone'];
          $email = $_POST['email'];
          $message = $_POST['message'];

          $adminemail = 'wemadeit22@yandex.ru';
          // Формируем сообщение для отправки, в нём мы соберём всё, что ввели в форме
          $mes = "Имя: $name \nE-mail: $email \nТема: $header \nТекст: $message";
          // Пытаемся отправить письмо по заданному адресу
          // Если нужно, чтобы письма всё время уходили на ваш адрес — замените первую переменную $email на свой адрес электронной почты
          $send = mail($adminemail, $name, $phone, $email, $message, "Content-type:text/plain; charset = UTF-8\r\nFrom:$email");
          // Если отправка прошла успешно — так и пишем
          if ($send == 'true') {echo "Сообщение отправлено";}
          // Если письмо не ушло — выводим сообщение об ошибке
          else {echo "Ой, что-то пошло не так";}
                  echo 'Кнопка нажата!';
              }
          ?>
			</section>
		</div>
	</div>
	<?php get_footer(); ?>