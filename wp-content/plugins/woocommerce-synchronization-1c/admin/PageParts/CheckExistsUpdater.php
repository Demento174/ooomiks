<?php

namespace Itgalaxy\Wc\Exchange1c\Admin\PageParts;

use Itgalaxy\Wc\Exchange1c\Includes\Bootstrap;

class CheckExistsUpdater
{
    public static function render()
    {
        $code = get_site_option(Bootstrap::PURCHASE_CODE_OPTIONS_KEY);

        if (empty($code)) {
            return;
        }

        if (class_exists('\\Puc_v4_Factory')) {
            return;
        }

        echo sprintf(
            '<div class="error notice notice-error"><p><strong>%1$s</strong>: %2$s</p></div>',
            esc_html__('1C Data Exchange', 'itgalaxy-woocommerce-1c'),
            esc_html__(
                'Not loaded `Puc_v4_Factory`. Plugin updates not working.',
                'itgalaxy-woocommerce-1c'
            )
        );
    }
}
