<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

add_action( 'after_setup_theme', 'miks_add_woocommerce_support' );

add_action( 'after_setup_theme', 'miks_setup');
function miks_setup() {
    add_theme_support( 'wc-product-gallery-zoom' );
	  add_theme_support( 'wc-product-gallery-slider' );
	  add_theme_support( 'wc-product-gallery-lightbox' );
}

function miks_add_woocommerce_support() {
add_theme_support( 'woocommerce', array(
  'thumbnail_image_width' => 140,
  'gallery_thumbnail_image_width' => 100,
  'single_image_width' => 500,
) );
}


/* Добавить свой размер (для чертежей в категориях товаров) */
add_action( 'after_setup_theme', 'true_add_image_size' );
function true_add_image_size() {
	add_image_size( 'category_photo', 244, 244, true );
}
function bost_miks_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 6,
		'columns'        => 3
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'bost_miks_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
//remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
//remove_action( 'woocommerce_after_shop_loop', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'bost_miks_woocommerce_wrapper_before' ) ) {
	function bost_miks_woocommerce_wrapper_before() {
		?>
<div class="miks__shop__wrapper">
	<?php
	}
}
add_action( 'woocommerce_before_main_content', 'bost_miks_woocommerce_wrapper_before' );

if ( ! function_exists( 'bost_miks_woocommerce_wrapper_after' ) ) {
	function bost_miks_woocommerce_wrapper_after() {
		?>
</div>
<?php
		}
	}
add_action( 'woocommerce_after_main_content', 'bost_miks_woocommerce_wrapper_after' );

/* кнопка логина на сайт */
function my_account_loginout_link() {

if (is_user_logged_in() ) {
global $wp;
$current_user = get_user_by( 'id', get_current_user_id() );

echo '<div class="header__account">';
	echo '<a class="header___am"
		href="'. get_permalink( wc_get_page_id( 'myaccount' ) ) .'"><span>'.$current_user->display_name.'</span></a> ';
	echo '<a class="header__logout" title="Выйти"
		href="'. wp_logout_url( get_permalink( wc_get_page_id( 'shop' ) ) ) .'"></a>';
	echo '</div>';
echo '<div class="header__account__mobile__block">';
	echo '<a class="header__account__mobile" href="'. get_permalink( wc_get_page_id( 'myaccount' ) ) .'"></a>';
	echo '<a class="header__account__mobile"
		href="'. wp_logout_url( get_permalink( wc_get_page_id( 'shop' ) ) ) .'"></a>';
	echo '</div>';
}
elseif (!is_user_logged_in() ) {
echo '<div class="header__account"><a class="header___a" href="' . get_permalink( wc_get_page_id( 'myaccount' ) ) . '">
		<span>Войти</span></a></div>';
}
}

if ( ! function_exists( 'bost_miks_woocommerce_cart_link_fragment' ) ) {
function bost_miks_woocommerce_cart_link_fragment( $fragments ) {
ob_start();
bost_miks_woocommerce_cart_link();
$fragments['a.cart-contents'] = ob_get_clean();

return $fragments;
}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'bost_miks_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'bost_miks_woocommerce_cart_link' ) ) {
function bost_miks_woocommerce_cart_link() {
?>
<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>"
	title="<?php esc_attr_e( 'Просмотреть корзину', 'bost-miks' ); ?>">
	<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d ', '%d ', WC()->cart->get_cart_contents_count(), 'bost-miks' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
	<span class="mini-cart-count">
		<?php echo esc_html( $item_count_text ); ?>
	</span>
</a>
<?php
	}
}

if ( ! function_exists( 'bost_miks_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function bost_miks_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
<?php bost_miks_woocommerce_cart_link(); ?>

<div class="header-name-mini-cart">
	<?php
		$instance = array(
		'title' => '',
		);

		the_widget( 'WC_Widget_Cart', $instance );
	?>
</div>

<?php
	}
}