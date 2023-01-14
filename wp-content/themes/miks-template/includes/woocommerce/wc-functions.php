<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* Добавить сайтбар shop_filter ко всем страницам woocommerce */
add_action('woocommerce_before_main_content', 'my_theme_top_sidebar', 2);
function my_theme_top_sidebar() {
     if ( is_active_sidebar( 'shop_filter' ) ) { ?>
<aside id="sidebar-top" class="sidebar__shop">
	<?php dynamic_sidebar( 'shop_filter' ); ?>
</aside>
<?php } ?>
<?php
}

add_filter( 'is_active_sidebar', 'theme_remove_sidebar', 10, 2 );

/* Скрыть кол-во товаров в категории */
add_filter( 'woocommerce_subcategory_count_html', 'jk_hide_category_count' );
function jk_hide_category_count() {
}
/* Кнопка вернуться в магазинт в корзине */
/*
function checkout_more_buttons() {
 echo '<div class="checkout-rewers-to-magazine"><a href="/shop/">Продолжить покупки <i class="_icon-icon-arow-right"></i></a></div>';
 }
 add_action ('woocommerce_review_order_before_submit', 'checkout_more_buttons', 5);
*/
/* НСТРОЙКА SINGLE PRODUCT */
add_action('woocommerce_before_main_content', 'miks_woocommerce_before_shop_loop_start', 1);
function miks_woocommerce_before_shop_loop_start(){
	?>
<div class="miks__before__shop__loop _container">
	<?php
}
add_action('woocommerce_after_shop_loop', 'miks_woocommerce_before_shop_loop_end', 15);
function miks_woocommerce_before_shop_loop_end(){
	?>
</div>
<?php
}

/* Кнопка фильтров товаров */
add_action('woocommerce_before_main_content', 'miks_filter_button', 15);
function miks_filter_button(){
	?>
<button class="miks__filter__button">
	<span class="show__filter__text">Открыть фильтры</span>
	<span class="hide__filter__text">Скрыть фильтры</span>
</button>
<?php
}

/* НСТРОЙКА CONTENT SINGLE PRODUCT */
/* рамка изображения и описания товара */
add_action('woocommerce_before_single_product_summary', 'miks_woocommerce_before_single_product_summary_start', 5);
function miks_woocommerce_before_single_product_summary_start(){
	?>
<div class="miks__sale__image__about__wrapper">
	<?php
}
/* рамка изображения и описания товара (конец) */
add_action('woocommerce_single_product_summary', 'miks_woocommerce_single_product_summary_end', 70);
function miks_woocommerce_single_product_summary_end(){
	?>
</div>
<?php
}

/* Картинка на категорию товаров */
add_action('woocommerce_archive_description', 'miks_woocommerce_archive_description_start', 20);
function miks_woocommerce_archive_description_start(){
	?>
<div class="category__photo">
	<?php
		$category = get_queried_object()->term_id;
		if( $category_photo = carbon_get_term_meta( $category, 'crb_thumb' ) ) {
			echo wp_get_attachment_image( $category_photo, 'single' ); 
		}
	?>
</div>
<?php
}

/* Сообщение на странице чекаута о доставке */
add_action('woocommerce_before_checkout_form', 'miks_woocommerce_before_checkout_form_message', 7);
function miks_woocommerce_before_checkout_form_message(){
	?>
<div class="checkout_delivery">
	<div class="checkout_delivery_wrapper">
		<div class="checkout_delivery_magazine">
			<div class="block_wrap">
				<div class="block">
					<h3>Адрес магазина:</h3>
					<?php echo $crb_adres_header = carbon_get_theme_option( 'crb_adres_header' ); ?>
				</div>
				<div class="block">
					<h3>Время работы:</h3>
					<?php echo $crb_graphrab_header = carbon_get_theme_option( 'crb_graphrab_header' ); ?>
				</div>
			</div>
		</div>
		<div class="checkout_delivery_pay">
			<?php echo $crb_whe = wpautop( carbon_get_theme_option( 'crb_where_delivery') );?>
		</div>
	</div>
</div>
</div>
<?php
}

/* рамка изображения товара */
add_action('woocommerce_before_single_product_summary', 'miks_woocommerce_before_single_product_summary_image_start', 7);
function miks_woocommerce_before_single_product_summary_image_start(){
	?>
<div class="miks__sale__image">
	<?php
}
/* рамка изображения товара (конец) */
add_action('woocommerce_before_single_product_summary', 'miks_woocommerce_before_single_product_summary_image_end', 25);
function miks_woocommerce_before_single_product_summary_image_end(){
	?>
</div>
<?php
}

/* рамка табов/отзывов/рейтинга старт */
add_action('woocommerce_after_single_product_summary', 'miks_woocommerce_after_single_product_summary_start', 5);
function miks_woocommerce_after_single_product_summary_start(){
	?>
<div class="miks__tabs__rewiews__wrapper">
	<?php
}
/* рамка табов/отзывов/рейтинга конец */
add_action('woocommerce_after_single_product_summary', 'woocommerce_after_single_product_summary_end', 25);
function woocommerce_after_single_product_summary_end(){
	?>
</div>
<?php
}

/* Обрамление страницы КОРЗИНА */
add_action('woocommerce_before_cart', 'miks_woocommerce_before_cart_start', 5);
function miks_woocommerce_before_cart_start(){
	?>
<div class="cart__wrapper">
	<?php
}
add_action('woocommerce_after_cart', 'miks_woocommerce_before_cart_end', 5);
function miks_woocommerce_before_cart_end(){
	?>
</div>
<?php
}

add_action('woocommerce_before_checkout_form', 'miks_woocommerce_before_checkout_form_starts', 5);
function miks_woocommerce_before_checkout_form_starts(){
	?>
<div class="checkout__wrapper">
	<?php
}

add_action('woocommerce_checkout_before_customer_details', 'miks_woocommerce_checkout_before_customer_details_starty', 1);
function miks_woocommerce_checkout_before_customer_details_starty(){
	?>
	<div class="checkout__wrapper__colums">
		<?php
}
/* Обрамление страницы ОФОРМЛЕНИЕ заказа */

add_action('woocommerce_checkout_before_customer_details', 'miks_woocommerce_checkout_before_customer_details_start', 5);
function miks_woocommerce_checkout_before_customer_details_start(){
	?>
		<div class="checkout__left">
			<?php
}
add_action('woocommerce_checkout_before_order_review_heading', 'miks_woocommerce_checkout_before_order_review_heading_end', 5);
function miks_woocommerce_checkout_before_order_review_heading_end(){
	?>
		</div>
		<?php
}


add_action('woocommerce_checkout_before_order_review_heading', 'miks_woocommerce_before_checkout_form_start', 5);
function miks_woocommerce_before_checkout_form_start(){
	?>
		<div class="checkout__right">
			<?php
}
add_action('woocommerce_checkout_after_order_review', 'miks_woocommerce_before_checkout_form_end', 5);
function miks_woocommerce_before_checkout_form_end(){
	?>
		</div>
		<?php
}

add_action('woocommerce_checkout_after_order_review', 'miks_woocommerce_before_checkout_form_ends', 8);
function miks_woocommerce_before_checkout_form_ends(){
	?>
	</div>
	<?php
}

/* Детали профиля - обрамление личных данных пользоваткеля */
add_action('woocommerce_before_edit_account_form', 'miks_woocommerce_before_edit_account_form_wrap', 2);
function miks_woocommerce_before_edit_account_form_wrap(){
	?>
	<div class="detalsprof__wrapper">
		<?php
}
add_action('woocommerce_after_edit_account_form', 'miks_woocommerce_before_edit_account_form_wrap_end', 55);
function miks_woocommerce_before_edit_account_form_wrap_end(){
	?>
	</div>
	<?php
}


/* ЛК - Детали профиля - обрамление личных данных пользоваткеля */
add_action('woocommerce_before_edit_account_form', 'miks_woocommerce_before_edit_account_form', 5);
function miks_woocommerce_before_edit_account_form(){
	?>
	<div class="detalsprof__change">
		<?php
}
add_action('woocommerce_edit_account_form', 'miks_woocommerce_edit_account_form', 10);
function miks_woocommerce_edit_account_form(){
	?>
	</div>
	<?php
}

/* ЛК - Детали профиля - Обрамление названия организации */
add_action('woocommerce_edit_account_form', 'miks_woocommerce_edit_account_form_start', 10);
function miks_woocommerce_edit_account_form_start(){
	?>
	<div class="detalsprof__organization">
		<?php
}
add_action('woocommerce_edit_account_form_end', 'miks_woocommerce_edit_account_form_end', 50);
function miks_woocommerce_edit_account_form_end(){
	?>
	</div>
	<?php
}

/* Лк - Адрес - Обрамление  */
add_action('woocommerce_before_edit_account_address_form', 'miks_woocommerce_before_edit_account_address_form_start', 10);
function miks_woocommerce_before_edit_account_address_form_start(){
	?>
	<div class="adress__wrapper">
		<?php
}
add_action('woocommerce_after_edit_account_form', 'miks_woocommerce_after_edit_account_form_end', 50);
function miks_woocommerce_after_edit_account_form_end(){
	?>
	</div>
	<?php
}

add_action( 'wp_footer', 'cart_update_qty_script' );
 
function cart_update_qty_script() {
    if (is_cart()) :
    ?>
	<script>
	jQuery('div.woocommerce').on('change', '.qty', function() {
		jQuery("[name='update_cart']").removeAttr("disabled").trigger("click");
	});
	</script>
	<?php
    endif; }
/*
	 add_action( 'woocommerce_before_quantity_input_field', 'truemisha_quantity_plus', 25 );
add_action( 'woocommerce_after_quantity_input_field', 'truemisha_quantity_minus', 25 );
 
function truemisha_quantity_plus() {
	echo '<button type="button" class="plus">+</button>';
}
 
function truemisha_quantity_minus() {
	echo '<button type="button" class="minus">-</button>';
}*/

/* Сортировка ппо имени (чтобы сделать по умолчанию через админку woocommerce) */
add_filter( 'woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args' );
function custom_woocommerce_get_catalog_ordering_args( $args ) {
$orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
if ( 'name_list' == $orderby_value ) {
$args['orderby'] = 'name';
$args['order'] = 'ASC';
$args['meta_key'] = '';
}
return $args;
}
add_filter( 'woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby' );

function custom_woocommerce_catalog_orderby( $sortby ) {
$sortby['name_list'] = 'Сортировать по имени';
return $sortby;
}


/* Отображать (ТОВАР ДОБАВЛЕН В КОРЗИНУ вместо кнопки "в корзину") */
// для страницы самого товара
add_filter( 'woocommerce_product_single_add_to_cart_text', 'truemisha_single_product_btn_text' );
function truemisha_single_product_btn_text( $text ) {
	if( WC()->cart->find_product_in_cart( WC()->cart->generate_cart_id( get_the_ID() ) ) ) {
		$text = 'Добавлен';
	}
	return $text;
}
// для страниц каталога товаров, категорий товаров и т д
add_filter( 'woocommerce_product_add_to_cart_text', 'truemisha_product_btn_text', 20, 2 );
function truemisha_product_btn_text( $text, $product ) {
	if( 
	   $product->is_type( 'simple' )
	   && $product->is_purchasable()
	   && $product->is_in_stock()
	   && WC()->cart->find_product_in_cart( WC()->cart->generate_cart_id( $product->get_id() ) )
	) {
		$text = 'Добавлен';
	}
	return $text;
}

 /* Кнопка отчистить корзину в корзине */
add_action('init', 'woocommerce_clear_cart_url');
function woocommerce_clear_cart_url() {
    global $woocommerce;
    if( isset($_REQUEST['clear-cart']) ) {
        $woocommerce->cart->empty_cart();
    }
}

add_action('woocommerce_before_cart_collaterals', 'miks_woocommerce_before_cart_collaterals_start', 5);
function miks_woocommerce_before_cart_collaterals_start(){
	?>
	<form class="clear-cart" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post"><button type="submit"
			onclick='javascript:if(!confirm("Удалить все товары из корзины?")) {return false;}' class="button"
			name="clear-cart">Очистить корзину</button>
	</form>
	<?php
}

add_action( 'woocommerce_single_product_summary', 'dev_designs_show_sku', 5 );
function dev_designs_show_sku(){
global $product;
echo '<div class="product__article">';
echo 'Артикул: ' . $product->get_sku();
echo '</div>';
}
