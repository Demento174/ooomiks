<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Or just remove them all in one line
//add_filter( 'woocommerce_enqueue_styles', '__return_false' );

/* отключаем стандартную обертку */
//remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);

/* отключаем стандартные хлебьные крошки у WOOCOMMERCE */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
/* отключаем стандартные картинки */
//remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
/* отключаем сайтбар от всех страниц ву коммерса */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
/* Отключаю цену товара чтобы подключить с другим приоритетом на странице товара */
//remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price'); // удалили цену
/* Отключаю повторный ввод купона на странице корзины */
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
/* отключаю отзывы на странице товара */
//remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

/*
if ( is_page('cart') ){
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb');
}
  */  
// удалить слово распродажа
/*
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
add_filter( 'woocommerce_sale_flash', '__return_null' );
*/
add_filter('woocommerce_sale_flash', 'my_custom_sale_flash', 10, 3);
function my_custom_sale_flash($text, $post, $_product) {
return '<span class="onsale">Цена снижена!</span>';
}

//удалить текст «Отображение 1-21 из 26» со страниц каталога 
//remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
/* отключаю сообщение "вы добавили в корзину что то" */
//add_filter( 'wc_add_to_cart_message_html', '__return_null');

// название товара в уведомлении о добавлении в корзину
add_filter( 'wc_add_to_cart_message', 'tb_custom_add_to_cart_product_message', 10, 2 ); 
function tb_custom_add_to_cart_product_message( $message, $product_id ) { 
    $message = sprintf(esc_html__('Вы добавили "%s" в Корзину. Отличный выбор!'), get_the_title( $product_id ) ); 
    return $message; 
}

/* Тс этим покупают справа */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_upsell_display', 99 );

add_filter('woocommerce_short_description', 'miks_short_dicription');
function miks_short_dicription($content){
    if(!is_product()):?>
<div class="tovar-short-discription">
	<?php echo $content ?>
</div>
<?php
endif;

}

/* Удалить сайтбар из катрочки товара */

function theme_remove_sidebar( $is_active_sidebar, $index ) {
    /*
    if( $index !== "shop_filter" ) {
        return $is_active_sidebar;
    } 
    */
        if ( is_tax( 'product_cat' ) ) {
        return $is_active_sidebar;
        }

        if ( is_tax( 'single-product' ) ) {
        return $is_active_sidebar;
        }

        if ( is_tax( 'product' ) ) {
        return $is_active_sidebar;
        }
    return false;
}