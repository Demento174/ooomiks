<?php
/**
 * Additional Information tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/additional-information.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

global $post;
$_product = new WC_Product_Variable( $post->ID );
$variations = $_product->get_available_variations();

$heading = apply_filters( 'woocommerce_product_additional_information_heading', __( 'Additional information', 'woocommerce' ) );

?>

<?php if ( $heading ) : ?>

	<h2><?php echo esc_html( $heading ); ?></h2>
<?php endif; ?>
<div class="main_additional-information main_content">
    <?php do_action( 'woocommerce_product_additional_information', $product ); ?>
</div>
<?php if($variations): ?>
    <?php foreach ($variations as $variation):
        ?>

    <div class="variation_additional-information" style="display: none" data-id="<?=$variation['variation_id']?>">
        <table class="woocommerce-product-attributes shop_attributes">
            <tbody>
            <?php foreach ($variation['attributes'] as $attribute_name => $option ):?>
            <tr class="woocommerce-product-attributes-item ">
                <th class="woocommerce-product-attributes-item__label"><?php echo wc_attribute_label( str_replace('attribute_','',$attribute_name) ); // WPCS: XSS ok. ?></th>
                <td class="woocommerce-product-attributes-item__value">
                    <?=$option?>
                </td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <?php endforeach; ?>
<?php endif;?>
