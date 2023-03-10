<?php

namespace Itgalaxy\Wc\Exchange1c\ExchangeProcess\Entities;

use Itgalaxy\Wc\Exchange1c\Includes\SettingsHelper;

class ProductAttributeEntity
{
    /**
     * @param string $label
     * @param string $name
     * @param string $guid
     *
     * @return array
     *
     * @throws \Exception
     */
    public static function insert($label, $name, $guid)
    {
        global $wpdb;

        $naturalName = self::getUniqueAttributeName($label);

        $newAttributeParams = [
            'attribute_label' => $label,
            'attribute_name' => $naturalName ? $naturalName : $name,
            'attribute_type' => 'select',
            'attribute_public' => SettingsHelper::isEmpty('attribute_create_enable_public') ? 0 : 1,
            'attribute_orderby' => 'menu_order',
            'id_1c' => $guid,
        ];

        /**
         * Filters a set of parameters when creating a new attribute.
         *
         * @since 1.80.1
         *
         * @param array $newAttributeParams
         */
        $newAttributeParams = \apply_filters('itglx_wc1c_create_product_attribute_args', $newAttributeParams);

        $wpdb->insert("{$wpdb->prefix}woocommerce_attribute_taxonomies", $newAttributeParams);

        // maybe error when insert processing, for example, non exists column `id_1c`
        if (empty($wpdb->insert_id)) {
            throw new \Exception("LAST ERROR - {$wpdb->last_error}, LAST QUERY - {$wpdb->last_query}");
        }

        \do_action('woocommerce_attribute_added', $wpdb->insert_id, $newAttributeParams);

        \wp_schedule_single_event(time(), 'woocommerce_flush_rewrite_rules');

        // Clear transients.
        \delete_transient('wc_attribute_taxonomies');

        if (
            class_exists('\\WC_Cache_Helper')
            && method_exists('\\WC_Cache_Helper', 'invalidate_cache_group')
        ) {
            \WC_Cache_Helper::invalidate_cache_group('woocommerce-attributes');
        }

        \delete_option('pa_' . $newAttributeParams['attribute_name'] . '_children');

        return $newAttributeParams;
    }

    /**
     * Retrieving an attribute record at `guid`.
     *
     * @param string $value Attribute `guid`.
     *
     * @return null|object
     */
    public static function get($value)
    {
        global $wpdb;

        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM `{$wpdb->prefix}woocommerce_attribute_taxonomies` WHERE `id_1c` = %s",
                (string) $value
            )
        );
    }

    public static function getByName($value)
    {
        global $wpdb;

        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM `{$wpdb->prefix}woocommerce_attribute_taxonomies` WHERE `attribute_name` = %s",
                (string) $value
            )
        );
    }

    public static function getByLabel($value)
    {
        global $wpdb;

        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM `{$wpdb->prefix}woocommerce_attribute_taxonomies` WHERE `attribute_label` = %s",
                (string) $value
            )
        );
    }

    public static function update($attributeUpdate, $attributeID)
    {
        global $wpdb;

        $wpdb->update(
            $wpdb->prefix . 'woocommerce_attribute_taxonomies',
            $attributeUpdate,
            [
                'attribute_id' => $attributeID,
            ]
        );

        // Clear transients.
        \delete_transient('wc_attribute_taxonomies');

        if (
            class_exists('\\WC_Cache_Helper')
            && method_exists('\\WC_Cache_Helper', 'invalidate_cache_group')
        ) {
            \WC_Cache_Helper::invalidate_cache_group('woocommerce-attributes');
        }
    }

    private static function getUniqueAttributeName($label)
    {
        $name = \wc_sanitize_taxonomy_name(self::sanitizeTransliterationName($label));

        // if for some reason an empty result is received, then they should immediately return a negative result
        if (empty($name)) {
            return false;
        }

        // https://developer.wordpress.org/reference/functions/register_taxonomy/
        $maxNameLength = 32;

        // WooCommerce added prefix - `pa_`
        $maxNameLength -= 3;

        // count value up to 99 - `-00`
        $maxNameLength -= 3;

        if (strlen($name) > $maxNameLength) {
            $name = substr($name, 0, $maxNameLength);
        }

        /*
         * the second call to clear a possible incorrect result,
         * for example, it might get `opisanie-dlya-sluzhebnogo-`, but it should be `opisanie-dlya-sluzhebnogo`
         */
        $name = \wc_sanitize_taxonomy_name($name);
        $resolvedName = $name;
        $count = 0;
        $attribute = self::getByName($resolvedName);

        while ($attribute && $count < 100) {
            ++$count;
            $resolvedName = $name . '-' . $count;
            $attribute = self::getByName($resolvedName);
        }

        if ($count > 99) {
            return false;
        }

        return $resolvedName;
    }

    private static function sanitizeTransliterationName($title)
    {
        $iso9Table = [
            '??' => 'A',
            '??' => 'B',
            '??' => 'V',
            '??' => 'G',
            '??' => 'G',
            '??' => 'G',
            '??' => 'D',
            '??' => 'E',
            '??' => 'YO',
            '??' => 'YE',
            '??' => 'ZH',
            '??' => 'Z',
            '??' => 'Z',
            '??' => 'I',
            '??' => 'J',
            '??' => 'J',
            '??' => 'I',
            '??' => 'YI',
            '??' => 'K',
            '??' => 'K',
            '??' => 'L',
            '??' => 'L',
            '??' => 'M',
            '??' => 'N',
            '??' => 'N',
            '??' => 'O',
            '??' => 'P',
            '??' => 'R',
            '??' => 'S',
            '??' => 'T',
            '??' => 'U',
            '??' => 'U',
            '??' => 'F',
            '??' => 'H',
            '??' => 'TS',
            '??' => 'CH',
            '??' => 'DH',
            '??' => 'SH',
            '??' => 'SHH',
            '??' => '',
            '??' => 'Y',
            '??' => '',
            '??' => 'E',
            '??' => 'YU',
            '??' => 'YA',
            '??' => 'a',
            '??' => 'b',
            '??' => 'v',
            '??' => 'g',
            '??' => 'g',
            '??' => 'g',
            '??' => 'd',
            '??' => 'e',
            '??' => 'yo',
            '??' => 'ye',
            '??' => 'zh',
            '??' => 'z',
            '??' => 'z',
            '??' => 'i',
            '??' => 'j',
            '??' => 'j',
            '??' => 'i',
            '??' => 'yi',
            '??' => 'k',
            '??' => 'k',
            '??' => 'l',
            '??' => 'l',
            '??' => 'm',
            '??' => 'n',
            '??' => 'n',
            '??' => 'o',
            '??' => 'p',
            '??' => 'r',
            '??' => 's',
            '??' => 't',
            '??' => 'u',
            '??' => 'u',
            '??' => 'f',
            '??' => 'h',
            '??' => 'ts',
            '??' => 'ch',
            '??' => 'dh',
            '??' => 'sh',
            '??' => 'shh',
            '??' => '',
            '??' => 'y',
            '??' => '',
            '??' => 'e',
            '??' => 'yu',
            '??' => 'ya',
        ];

        $geo2lat = [
            '???' => 'a',
            '???' => 'b',
            '???' => 'g',
            '???' => 'd',
            '???' => 'e',
            '???' => 'v',
            '???' => 'z',
            '???' => 'th',
            '???' => 'i',
            '???' => 'k',
            '???' => 'l',
            '???' => 'm',
            '???' => 'n',
            '???' => 'o',
            '???' => 'p',
            '???' => 'zh',
            '???' => 'r',
            '???' => 's',
            '???' => 't',
            '???' => 'u',
            '???' => 'ph',
            '???' => 'q',
            '???' => 'gh',
            '???' => 'qh',
            '???' => 'sh',
            '???' => 'ch',
            '???' => 'ts',
            '???' => 'dz',
            '???' => 'ts',
            '???' => 'tch',
            '???' => 'kh',
            '???' => 'j',
            '???' => 'h',
        ];

        $hy = [
            '??' => 'ev', '????' => 'u', '[\s\t]+???' => '\svo',
            '??' => 'A', '??' => 'B', '??' => 'G', '??' => 'D', '??' => 'Ye', '??' => 'Z', '??' => 'E',
            '??' => 'Eh', '??' => 'Th', '??' => 'Zh', '??' => 'I', '??' => 'L', '??' => 'X', '??' => 'Tc',
            '??' => 'K', '??' => 'H', '??' => 'Dz', '??' => 'Gh', '??' => 'Tch', '??' => 'M', '??' => 'Y',
            '??' => 'N', '??' => 'Sh', '??' => 'Vo', '??' => 'Ch', '??' => 'P', '??' => 'J', '??' => 'R',
            '??' => 'S', '??' => 'V', '??' => 'T', '??' => 'R', '??' => 'C', '??' => 'Ph', '??' => 'Kh',
            '??' => 'O', '??' => 'F',
            '??' => 'a', '??' => 'b', '??' => 'g', '??' => 'd', '??' => 'e', '??' => 'z', '??' => 'e',
            '??' => 'eh', '??' => 'th', '??' => 'zh', '??' => 'i', '??' => 'l', '??' => 'x', '??' => 'tc',
            '??' => 'k', '??' => 'h', '??' => 'dz', '??' => 'gh', '??' => 'tch', '??' => 'm', '??' => 'y',
            '??' => 'n', '??' => 'sh', '??' => 'o', '??' => 'ch', '??' => 'p', '??' => 'j', '??' => 'r',
            '??' => 's', '??' => 'v', '??' => 't', '??' => 'r', '??' => 'c', '??' => 'ph', '??' => 'kh',
            '??' => 'o', '??' => 'f',
            '???' => '#', '???' => '-', '??' => '', '??' => '', '???' => '',
        ];

        $iso9Table = array_merge($iso9Table, $geo2lat, $hy);
        $locale = \get_locale();

        switch ($locale) {
            case 'bg_BG':
                $iso9Table['??'] = 'SHT';
                $iso9Table['??'] = 'sht';
                $iso9Table['??'] = 'A';
                $iso9Table['??'] = 'a';
                break;
            case 'uk':
            case 'uk_ua':
                $iso9Table['??'] = 'Y';
                $iso9Table['??'] = 'y';
                break;
        }

        $title = strtr($title, \apply_filters('ctl_table', $iso9Table));

        if (function_exists('iconv')) {
            $title = iconv('UTF-8', 'UTF-8//TRANSLIT//IGNORE', $title);
        }

        $title = preg_replace("/[^A-Za-z0-9'_\\-\\.]/", '-', $title);
        $title = preg_replace('/\-+/', '-', $title);
        $title = preg_replace('/^-+/', '', $title);

        return preg_replace('/-+$/', '', $title);
    }
}
