<?php

namespace Itgalaxy\Wc\Exchange1c\ExchangeProcess\DataGenerators\TypeSaleModeQuery;

use Itgalaxy\Wc\Exchange1c\Includes\Logger;
use Itgalaxy\Wc\Exchange1c\Includes\SettingsHelper;

class DocumentProductsData
{
    /**
     * @param \SimpleXMLElement $document
     * @param \WC_Order         $order
     *
     * @return void
     */
    public static function generate(\SimpleXMLElement $document, \WC_Order $order)
    {
        $productsXml = $document->addChild('Товары');
        $products = self::prepareList($order);

        foreach ($products as $product) {
            $productXmlArray = self::prepareProductItemXmlArray($product, $order);
            $productXml = $productsXml->addChild('Товар');

            self::generateProductItemXmlByArray($productXml, $productXmlArray);
        }

        self::shippingItem($order, $productsXml);
    }

    /**
     * @param \WC_Order $order
     *
     * @return array
     */
    private static function prepareList(\WC_Order $order)
    {
        $products = [];

        foreach ($order->get_items() as $item) {
            $qtyItem = (float) $item['qty'] - abs($order->get_qty_refunded_for_item($item->get_id()));

            // ignore items with 0 qty
            if (empty($qtyItem)) {
                continue;
            }

            if (version_compare(WC_VERSION, '4.4', '<')) {
                $product = $order->get_product_from_item($item);
            } else {
                $product = $item->get_product();
            }

            $sku = '';

            if ($product instanceof \WC_Product && $product->get_sku()) {
                $sku = $product->get_sku();
            }

            $totalItem = round((float) $item->get_total() - (float) $order->get_total_refunded_for_item($item->get_id()), wc_get_price_decimals());
            $discountItem = round((float) $item->get_subtotal() - (float) $item->get_total(), wc_get_price_decimals());
            $taxItem = round((float) $item->get_total_tax(), wc_get_price_decimals());

            if (
                !SettingsHelper::isEmpty('send_orders_combine_data_variation_as_main_product')
                && $item['variation_id']
            ) {
                if (!isset($products[$item['product_id']])) {
                    $products[$item['product_id']] = [
                        'id' => $item['product_id'],
                        'productId' => $item['product_id'],
                        'variationId' => '',
                        '_id_1c' => get_post_meta($item['product_id'], '_id_1c', true),
                        'quantity' => $qtyItem,
                        'name' => htmlspecialchars(get_post_field('post_title', $item['product_id'])),
                        'lineTotal' => $totalItem,
                        'discountItem' => $discountItem,
                        'lineTax' => $taxItem,
                        'sku' => $sku,
                        'attributes' => [],
                    ];
                } else {
                    $products[$item['product_id']]['quantity'] += $qtyItem;
                    $products[$item['product_id']]['lineTotal'] += $totalItem;
                    $products[$item['product_id']]['discountItem'] += $discountItem;
                    $products[$item['product_id']]['lineTax'] += $taxItem;
                }
            } else {
                $exportProduct = [
                    'originalItem' => $item,
                    'originalProduct' => $product,
                    'id' => $item['variation_id'] ? $item['variation_id'] : $item['product_id'],
                    'productId' => $item['product_id'],
                    'variationId' => $item['variation_id'],
                    '_id_1c' => get_post_meta(
                        $item['variation_id'] ? $item['variation_id'] : $item['product_id'],
                        '_id_1c',
                        true
                    ),
                    'quantity' => $qtyItem,
                    'name' => htmlspecialchars($item['name']),
                    'lineTotal' => $totalItem,
                    'discountItem' => $discountItem,
                    'lineTax' => $taxItem,
                    'lineId' => $item->get_id(),
                    'sku' => $sku,
                    'attributes' => [],
                ];

                if (
                    empty($exportProduct['_id_1c'])
                    && $product instanceof \WC_Product
                    && $item['variation_id']
                    && !SettingsHelper::isEmpty('send_orders_use_variation_characteristics_from_site')
                    && $product->get_attribute_summary()
                ) {
                    $attributes = explode(', ', $product->get_attribute_summary());

                    foreach ($attributes as $attribute) {
                        $exportProduct['attributes'][] = explode(': ', $attribute);
                    }
                }

                $products[] = $exportProduct;
            }
        }

        /**
         * Filters a prepared set of products from an order before using it in XML.
         *
         * @since 1.84.3
         *
         * @param array     $products
         * @param \WC_Order $order
         */
        return \apply_filters('itglx_wc1c_xml_order_product_rows', $products, $order);
    }

    /**
     * @param array     $product
     * @param \WC_Order $order
     *
     * @return array
     */
    private static function prepareProductItemXmlArray($product, $order)
    {
        $includeTax = !SettingsHelper::isEmpty('send_orders_include_tax_to_price_item_and_shipping');
        $productXmlArray = [];

        /**
         * Filters the prepared product from an order before using it in XML.
         *
         * @since 1.84.3
         *
         * @param array     $product
         * @param \WC_Order $order
         */
        $product = \apply_filters('itglx_wc1c_xml_order_product_row_params', $product, $order);

        // has 1C guid
        if (!empty($product['_id_1c'])) {
            $productXmlArray['Ид'] = $product['_id_1c'];
        } else {
            if (!SettingsHelper::isEmpty('send_orders_use_product_id_from_site')) {
                Logger::log('used product/variation `id` from site in node "Ид"', [$product['id'], $order->get_id()]);

                $productXmlArray['Ид'] = $product['id'];
            } else {
                Logger::log('generate product without node "Ид"', [$product['id'], $order->get_id()]);
            }

            if ($product['sku'] !== '') {
                Logger::log('no 1C guid, added "Артикул"', [$product['id'], $product['sku'], $order->get_id()]);

                $productXmlArray['Артикул'] = $product['sku'];
            } else {
                Logger::log('no 1C guid and empty sku, "Артикул" no added', [$product['id'], $order->get_id()]);
            }
        }

        $productXmlArray['Наименование'] = wp_strip_all_tags(html_entity_decode($product['name']));

        $unit = get_post_meta($product['id'], '_unit', true);

        $productXmlArray['БазоваяЕдиница'] = [
            'value' => $unit ? $unit['value'] : 'шт',
            'attributes' => [
                'Код' => $unit ? $unit['code'] : 796,
                'НаименованиеПолное' => $unit ? $unit['nameFull'] : 'Штука',
                'МеждународноеСокращение' => $unit ? $unit['internationalAcronym'] : 'PCE',
            ],
        ];

        if ($includeTax) {
            $product['lineTotal'] += $product['lineTax'];
        }

        $productXmlArray['ЦенаЗаЕдиницу'] = $product['quantity'] ? $product['lineTotal'] / $product['quantity'] : 0;
        $productXmlArray['Количество'] = $product['quantity'];
        $productXmlArray['Сумма'] = $product['lineTotal'];

        if (
            !SettingsHelper::isEmpty('send_orders_add_information_discount_for_each_item')
            && !empty($product['discountItem'])
        ) {
            $productXmlArray['Скидки'] = [
                'Скидка' => [
                    [
                        'Наименование' => 'Скидка',
                        'Сумма' => $product['quantity'] ? $product['discountItem'] / $product['quantity'] : $product['discountItem'],
                        'УчтеноВСумме' => 'true',
                    ],
                ],
            ];
        }

        if (!empty($product['attributes'])) {
            $productXmlArray['ХарактеристикиТовара'] = ['ХарактеристикаТовара' => []];

            foreach ($product['attributes'] as $attribute) {
                if (!isset($attribute[1])) {
                    continue;
                }

                $productXmlArray['ХарактеристикиТовара']['ХарактеристикаТовара'][] = [
                    'Наименование' => $attribute[0],
                    'Значение' => $attribute[1],
                ];
            }
        }

        $productXmlArray['ЗначенияРеквизитов'] = [
            'ЗначениеРеквизита' => [
                [
                    'Наименование' => 'ВидНоменклатуры',
                    'Значение' => 'Товар',
                ],
                [
                    'Наименование' => 'ТипНоменклатуры',
                    'Значение' => 'Товар',
                ],
                [
                    'Наименование' => 'НомерПозицииКорзины',
                    'Значение' => !empty($product['lineId']) ? $product['lineId'] : '',
                ],
            ],
        ];

        /**
         * Filters a dataset before using it to build XML.
         *
         * @since 1.16.2
         * @since 1.90.0 The `$product` parameter was added
         *
         * @param array $productXmlArray
         * @param int   $productId
         * @param int   $variationId
         * @param array $product
         */
        return apply_filters('itglx_wc1c_xml_product_info_custom', $productXmlArray, $product['productId'], $product['variationId'], $product);
    }

    /**
     * @param \WC_Order         $order
     * @param \SimpleXMLElement $productsXml
     *
     * @return void
     */
    private static function shippingItem(\WC_Order $order, \SimpleXMLElement $productsXml)
    {
        if ($order->get_shipping_total() <= 0) {
            return;
        }

        $shippingPrice = round($order->get_shipping_total() - $order->get_total_shipping_refunded(), \wc_get_price_decimals());

        if (!SettingsHelper::isEmpty('send_orders_include_tax_to_price_item_and_shipping')) {
            $shippingPrice += round($order->get_shipping_tax(), \wc_get_price_decimals());
        }

        $shippingItemArray = [
            'Ид' => 'ORDER_DELIVERY',
            'Наименование' => \wp_strip_all_tags(html_entity_decode($order->get_shipping_method())),
            'БазоваяЕдиница' => [
                'value' => 'шт',
                'attributes' => [
                    'Код' => 796,
                    'НаименованиеПолное' => 'Штука',
                    'МеждународноеСокращение' => 'PCE',
                ],
            ],
            'ЦенаЗаЕдиницу' => $shippingPrice,
            'Количество' => 1,
            'Сумма' => $shippingPrice,
            'ЗначенияРеквизитов' => [
                'ЗначениеРеквизита' => [
                    [
                        'Наименование' => 'ВидНоменклатуры',
                        'Значение' => 'Услуга',
                    ],
                    [
                        'Наименование' => 'ТипНоменклатуры',
                        'Значение' => 'Услуга',
                    ],
                ],
            ],
        ];

        /**
         * Filters the content of the `shipping` item by `order` before generating XML.
         *
         * @since 1.103.0
         *
         * @param array     $shippingItemArray
         * @param \WC_Order $order
         */
        $shippingItemArray = \apply_filters('itglx/wc/1c/sale/query/order-shipping-item', $shippingItemArray, $order);

        $shippingItemXml = $productsXml->addChild('Товар');

        self::generateProductItemXmlByArray($shippingItemXml, $shippingItemArray);
    }

    /**
     * @param \SimpleXMLElement $productXmlObject
     * @param array             $itemArray
     *
     * @return void
     */
    private static function generateProductItemXmlByArray($productXmlObject, $itemArray)
    {
        foreach ($itemArray as $key => $value) {
            if (!is_array($value)) {
                $productXmlObject->addChild($key, htmlspecialchars($value));
            } elseif (isset($value['attributes'])) {
                $child = $productXmlObject->addChild($key, htmlspecialchars($value['value']));

                foreach ($value['attributes'] as $attributeName => $attributeValue) {
                    $child->addAttribute($attributeName, htmlspecialchars($attributeValue));
                }
            } else {
                $child = $productXmlObject->addChild($key);

                foreach ($value as $subKey => $subValue) {
                    foreach ($subValue as $subChildValue) {
                        $subChild = $child->addChild($subKey);

                        foreach ($subChildValue as $nodeName => $nodeValue) {
                            $subChild->addChild($nodeName, htmlspecialchars($nodeValue));
                        }
                    }
                }
            }
        }
    }
}
