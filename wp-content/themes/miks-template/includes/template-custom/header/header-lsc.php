<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>
<div class="header__content _container">
	<div class="header__name__site">
		<?php $logo_id = carbon_get_theme_option('miks_header_logo');
      $logo = $logo_id ? wp_get_attachment_image_src($logo_id , 'full') : '';
      $site_name = carbon_get_theme_option('miks_header_site_name') ? carbon_get_theme_option('miks_header_site_name') : get_bloginfo('name');
      $site_decs = carbon_get_theme_option('miks_header_site_desc') ? carbon_get_theme_option('miks_header_site_desc') : get_bloginfo('description');
      ?>

		<?php if (is_front_page() && is_home()) :
        if ($logo_id) : ?>
		<a href="<?php echo home_url('/');?>"> <img src="<?php echo $logo[0];?>" width="<?php echo $logo[1];?>"
				height="<?php echo $logo[2];?>" alt="">
		</a>
		<?php else: ?>
		<a href="<?php echo home_url('/');?>">
			<?php echo $site_name; ?><span>
				<?php echo $site_decs; ?>
			</span>
		</a>
		<?php endif;?>
		<?php else:
        if ($logo_id) : ?>
		<a href="/">
			<img src="<?php echo $logo[0];?>" width="<?php echo $logo[1];?>" height="<?php echo $logo[2];?>" alt="">
		</a>
		<div class="header__sitename__seo">
			<h1><?php echo $site_name; ?></h1>
			<h2><?php echo $site_decs; ?></h2>
		</div>

		<?php else: ?>
		<a href="/">
			<?php echo $site_name; ?>
		</a>
		<span>
			<?php echo $site_decs; ?>
		</span>
		<?php endif;?>
		<?php endif;?>
	</div>
	<div class="search_form">
		<?php /* get_search_form(); */?>
		<?php echo do_shortcode('[fibosearch]'); ?>
	</div>
	<div class="header__components">
		<div class="search__adaptive">
			<i class="icon-icon-search-light" aria-hidden="true"></i>
		</div>

		<?php my_account_loginout_link(); ?>
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>">
			<div class="header__cart"><span class="
				cart__name__after">Корзина</span>

				<?php bost_miks_woocommerce_header_cart(); ?>
		</a>
	</div>
	<div class="header__burgers">
		<span></span>
	</div>
</div>
</div>