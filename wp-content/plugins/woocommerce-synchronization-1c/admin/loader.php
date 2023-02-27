<?php

use Itgalaxy\Wc\Exchange1c\Admin\AjaxActions\ClearLogsAjaxAction;
use Itgalaxy\Wc\Exchange1c\Admin\AjaxActions\ClearTempAjaxAction;
use Itgalaxy\Wc\Exchange1c\Admin\AjaxActions\LastRequestResponseAjaxAction;
use Itgalaxy\Wc\Exchange1c\Admin\AjaxActions\LogsCountAndSizeAjaxAction;
use Itgalaxy\Wc\Exchange1c\Admin\AjaxActions\TempCountAndSizeAjaxAction;
use Itgalaxy\Wc\Exchange1c\Admin\MetaBoxes\MetaBoxShopOrder;
use Itgalaxy\Wc\Exchange1c\Admin\Other\AdminNoticeIfHasTrashedProductWithGuid;
use Itgalaxy\Wc\Exchange1c\Admin\Other\AdminNoticeIfNotVerified;
use Itgalaxy\Wc\Exchange1c\Admin\PluginActionLinksFilter;
use Itgalaxy\Wc\Exchange1c\Admin\Product\GuidProductDataTab;
use Itgalaxy\Wc\Exchange1c\Admin\ProductAttributesPage1cIdInfo;
use Itgalaxy\Wc\Exchange1c\Admin\ProductVariation\GuidField;
use Itgalaxy\Wc\Exchange1c\Admin\ProductVariation\HeaderGuidInfo;
use Itgalaxy\Wc\Exchange1c\Admin\RequestProcessing\GetInArchiveLogs;
use Itgalaxy\Wc\Exchange1c\Admin\RequestProcessing\GetInArchiveTemp;
use Itgalaxy\Wc\Exchange1c\Admin\SettingsPage;
use Itgalaxy\Wc\Exchange1c\Admin\TableColumns\TableColumnProduct;
use Itgalaxy\Wc\Exchange1c\Admin\TableColumns\TableColumnProductAttribute;
use Itgalaxy\Wc\Exchange1c\Admin\TableColumns\TableColumnProductCat;

if (!defined('ABSPATH')) {
    return;
}

// do not continue initialization if not admin panel
if (!is_admin()) {
    return;
}

new SettingsPage();
new PluginActionLinksFilter();
new ProductAttributesPage1cIdInfo();

// table columns
new TableColumnProductAttribute();
new TableColumnProductCat();
new TableColumnProduct();

// metaboxes
new MetaBoxShopOrder();

// product
new GuidProductDataTab();

// product variation
new HeaderGuidInfo();
new GuidField();

// bind ajax actions
new ClearLogsAjaxAction();
new ClearTempAjaxAction();
new LastRequestResponseAjaxAction();
new LogsCountAndSizeAjaxAction();
new TempCountAndSizeAjaxAction();

// bind admin request handlers
new GetInArchiveLogs();
new GetInArchiveTemp();

// bind other admin actions
new AdminNoticeIfHasTrashedProductWithGuid();
new AdminNoticeIfNotVerified();
