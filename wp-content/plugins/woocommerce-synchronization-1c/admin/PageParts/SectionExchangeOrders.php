<?php

namespace Itgalaxy\Wc\Exchange1c\Admin\PageParts;

use Itgalaxy\Wc\Exchange1c\Admin\PageParts\SectionExchangeOrdersTabs\SectionExchangeOrdersAdditionalTab;
use Itgalaxy\Wc\Exchange1c\Admin\PageParts\SectionExchangeOrdersTabs\SectionExchangeOrdersLoadChangesTab;
use Itgalaxy\Wc\Exchange1c\Admin\PageParts\SectionExchangeOrdersTabs\SectionExchangeOrdersMainTab;
use Itgalaxy\Wc\Exchange1c\Admin\PageParts\SectionExchangeOrdersTabs\SectionExchangeOrdersPaymentsTab;

class SectionExchangeOrders
{
    /**
     * @var array
     */
    private static $orderStatusList = [];

    /**
     * @var array
     */
    private static $paymentGatewayList = [];

    public static function render()
    {
        $section = [
            'title' => esc_html__('Exchange orders with 1C', 'itgalaxy-woocommerce-1c'),
            'tabs' => [
                SectionExchangeOrdersMainTab::getSettings(),
                SectionExchangeOrdersAdditionalTab::getSettings(),
                SectionExchangeOrdersPaymentsTab::getSettings(),
                SectionExchangeOrdersLoadChangesTab::getSettings(),
            ],
        ];

        Section::render($section);
    }

    /**
     * @return array
     */
    public static function getOrderStatusList()
    {
        if (!empty(self::$orderStatusList)) {
            return self::$orderStatusList;
        }

        $statusList = [
            '' => esc_html__('Not chosen', 'itgalaxy-woocommerce-1c'),
        ];

        foreach (wc_get_order_statuses() as $status => $label) {
            $statusList[str_replace('wc-', '', $status)] = $label;
        }

        self::$orderStatusList = $statusList;

        return self::$orderStatusList;
    }

    /**
     * @return array
     */
    public static function getPaymentGatewayList()
    {
        if (!empty(self::$paymentGatewayList)) {
            return self::$paymentGatewayList;
        }

        $gateways = \WC()->payment_gateways->payment_gateways();
        $gatewayList = [
            '' => esc_html__('Not chosen', 'itgalaxy-woocommerce-1c'),
        ];

        if (empty($gateways)) {
            self::$paymentGatewayList = $gatewayList;

            return self::$paymentGatewayList;
        }

        foreach ($gateways as $gateway) {
            if ($gateway->enabled === 'yes') {
                $gatewayList[$gateway->id] = !empty($gateway->title) ? $gateway->title : $gateway->id;
            }
        }

        self::$paymentGatewayList = $gatewayList;

        return self::$paymentGatewayList;
    }
}
