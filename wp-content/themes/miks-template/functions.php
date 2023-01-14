<?php 
/* Подключение Карбон филс */
require_once get_template_directory() . '/includes/carbon/carbon.php';

/* Отключение мусора */
require_once get_template_directory() . '/includes/functions/off-functions.php';

/* Подключение CSS / JS / Скриптов и тд.*/
require_once get_template_directory() . '/includes/functions/enqueue-scripts-styles.php';

/* Хуки header */
require_once get_template_directory() . '/includes/theme-hocks/header-hocks.php';

function bost_miks_setup() {
		add_theme_support( 'title-tag' );

		// (Создание областей меню в админке).
	register_nav_menus(
		array(
			'header-menu' => esc_html__( 'Меню в шапке сайта', 'bost-miks' ),
			'footer-menu' => esc_html__( 'Меню в подвале сайта', 'bost-miks' ),
			'footer-menu-prod' => esc_html__( 'Категории товаров в подвале', 'bost-miks' ),
			'footer-menu-prod2' => esc_html__( 'Категории товаров в подвале2', 'bost-miks' ),
			'footer-menu-prod3' => esc_html__( 'Категории товаров в подвале3', 'bost-miks' ),
		)
	);
}

/* Load WooCommerce compatibility file. */
add_theme_support( 'woocommerce' );

if ( class_exists( 'WooCommerce' ) ) {
	require_once get_template_directory() . '/includes/woocommerce/woocommerce.php';
	require_once get_template_directory() . '/includes/woocommerce/wc-functions-remove.php';
	require_once get_template_directory() . '/includes/woocommerce/wc-functions.php';
	require_once get_template_directory() . '/includes/woocommerce/wc-checkout.php';
	require_once get_template_directory() . '/includes/woocommerce/wc-userfields.php';
}
add_action( 'after_setup_theme', 'bost_miks_setup' );

function miks_widgets_init() {
 
	/* В боковой колонке - первый сайдбар */
	register_sidebar(
		array(
			'id' => 'shop_filter', // уникальный id
			'name' => 'Сайтбар Магазина', // название сайдбара
			'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
			'before_widget' => '<div id="%1$s" class="side_shop widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
			'after_widget' => '</div>',
			'before_title' => '<div class="filter_button">Фильтры</div><h3 class="widget-title">', // по умолчанию заголовки виджетов в <h2>
			'after_title' => '</h3>'
		)
	);

	register_sidebar(
		array(
			'id' => 'sidebar_blog', // уникальный id
			'name' => 'Записи блога', // название сайдбара
			'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
			'before_widget' => '<div id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">', // по умолчанию заголовки виджетов в <h2>
			'after_title' => '</h3>'
		)
	);
}
add_action( 'widgets_init', 'miks_widgets_init' );

// Подписи ALT к фото
add_filter('wp_get_attachment_image_attributes', 'change_attachement_image_attributes', 20, 2);
function change_attachement_image_attributes($attr, $attachment) {
global $post;
if ($post->post_type == 'product') {
$title = $post->post_title;
static $num = 0;
$num++;
$attr['alt'] = sprintf("Фото %d - %s. Купить в Челябинске в интернет магазине ООО МИКС",$num,$title);
}
return $attr;
}

  // View Cart, Update Cart, Proceed to Checkout
function tb_text_strings( $translated_text, $text, $domain ) {
	switch ( $translated_text ) {
		case 'Просмотр корзины' :
		$translated_text = __( 'Просмотр', 'woocommerce' );
		break;
	}
	return $translated_text;
	}
add_filter( 'gettext', 'tb_text_strings', 20, 3 );

// набор параметров при обновлении поста товара
add_filter('itglx_wc1c_update_post_product_params','postProductParams', 10, 2);

// набор параметров при создании поста товара
add_filter('itglx_wc1c_insert_post_new_product_params', 'postProductParams', 10, 2);

function postProductParams($params, $element)
{
    foreach ($element->ЗначенияСвойств->ЗначенияСвойства as $option) {
        $guid = trim((string) $option->Ид);
        // если это нужное свойство, то используем его значение для названия
        if ($guid === '27a85333-e1d6-11ec-b14d-d85ed3562322') {
            $params['post_title'] = html_entity_decode(trim((string) $option->Значение));
            break;
        }
    }
    return $params;
}
/**
 * Update CSS within in Admin
 */

function admin_style() {
  wp_enqueue_style('admin-styles', get_stylesheet_directory_uri() . '/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');

/* Хуки footer */
require_once get_template_directory() . '/includes/theme-hocks/footer-hocks.php';


add_action(
  'wp_footer',
  function() {
    ?>
    <script type="text/javascript">
            ( function () {
                'use strict';
 
                // Флаг, что Метрика уже загрузилась.
                var loadedMetrica = false,
                    // Ваш идентификатор сайта в Яндекс.Метрика.
                    metricaId     = 88580233,
                    // Переменная для хранения таймера.
                    timerId;
 
                // Для бота Яндекса грузим Метрику сразу без "отложки",
                // чтобы в панели Метрики были зелёные кружочки
                // при проверке корректности установки счётчика.
                if ( navigator.userAgent.indexOf( 'YandexMetrika' ) > -1 ) {
                    loadMetrica();
                } else {
                    // Подключаем Метрику, если юзер начал скроллить.
                    window.addEventListener( 'scroll', loadMetrica, {passive: true} );
 
                    // Подключаем Метрику, если юзер коснулся экрана.
                    window.addEventListener( 'touchstart', loadMetrica );
 
                    // Подключаем Метрику, если юзер дернул мышкой.
                    document.addEventListener( 'mouseenter', loadMetrica );
 
                    // Подключаем Метрику, если юзер кликнул мышкой.
                    document.addEventListener( 'click', loadMetrica );
 
                    // Подключаем Метрику при полной загрузке DOM дерева,
                    // с "отложкой" в 1 секунду через setTimeout,
                    // если пользователь ничего вообще не делал (фоллбэк).
                    document.addEventListener( 'DOMContentLoaded', loadFallback );
                }
 
                function loadFallback() {
                    timerId = setTimeout( loadMetrica, 1000 );
                }
 
                function loadMetrica( e ) {
 
                    // Пишем отладку в консоль браузера.
                    if ( e && e.type ) {
                        console.log( e.type );
                    } else {
                        console.log( 'DOMContentLoaded' );
                    }
 
                    // Если флаг загрузки Метрики отмечен,
                    // то ничего более не делаем.
                    if ( loadedMetrica ) {
                        return;
                    }
 
                    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js", "ym");
                    ym( metricaId, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true });
 
                    // Отмечаем флаг, что Метрика загрузилась,
                    // чтобы не загружать её повторно при других
                    // событиях пользователя и старте фоллбэка.
                    loadedMetrica = true;
 
                    // Очищаем таймер, чтобы избежать лишних утечек памяти.
                    clearTimeout( timerId );
 
                    // Отключаем всех наших слушателей от всех событий,
                    // чтобы избежать утечек памяти.
                    window.removeEventListener( 'scroll', loadMetrica );
                    window.removeEventListener( 'touchstart', loadMetrica );
                    document.removeEventListener( 'mouseenter', loadMetrica );
                    document.removeEventListener( 'click', loadMetrica );
                    document.removeEventListener( 'DOMContentLoaded', loadFallback );
                }
            } )()
    </script>
    <?php
  }
);

add_action( 'wp_enqueue_scripts', function () {
	wp_dequeue_style( 'font-awesome' );
} );

/* Количество редакций в бд */
function dco_wp_revisions_to_keep( $revisions, $post ) {
    if ( 'page' == $post->post_type ) {
        return 3; // Для страниц
    } else {
        return 3; // Для записей
    }
}
add_filter( 'wp_revisions_to_keep', 'dco_wp_revisions_to_keep', 10, 2 );

/* отчистить все редакции
global $wpdb;
$wpdb->query(
	"
	DELETE a,b,c FROM $wpdb->posts a  
	LEFT JOIN $wpdb->term_relationships b ON (a.ID = b.object_id)  
	LEFT JOIN $wpdb->postmeta c ON (a.ID = c.post_id)  
	WHERE a.post_type = 'revision'
	"
);
*/
//защита от не работающих функций
if ( ! function_exists('pll__')) {
	function pll__( $string) {
		return $string;
	}
}
?>