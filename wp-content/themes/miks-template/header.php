<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
    <script src="//code.jivo.ru/widget/HDYfzmGjND" async></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
	<div class="wrappers">
		<header class="header">
			<?php
				/*
				* header_parts hook.
				* @hooked miks_header_socials_new', 10
				* @hooked header_logo_search_cart', 20
				* @hooked header_nav', 30 
				*/
			do_action('header_parts');
		?>
		</header>

		<div class="breadcrubm">
			<div class="m-container _container">
				<?php woocommerce_breadcrumb(); ?>
			</div>
		</div>

        <style>
            #dgwt-wcas-search-input-1{
                border:1px solid black;
            }
        </style>