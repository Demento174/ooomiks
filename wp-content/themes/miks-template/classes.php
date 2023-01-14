<?php

if((float) phpversion()<7.4)
{
    $current_version = phpversion();
    wp_die("min version php 7.4, current version $current_version");
}
/**
 * Автозагрузчик классов
 */
require_once (get_template_directory().'/autoload.php');

/**
 * Подключение модулей Composer
 */
require_once (get_template_directory().'/vendor/autoload.php');


/**
 * Стандартные настройки шаблона
 */
//new Classes\TemplateSetup\TemplateSetup();


/**
 * Настройки шаблонизатора TWIG
 */
//new Classes\TwigSettings\TwigSettings();


/**
 * Надстройка над плагином Advanced Custom field
 */
//new Classes\ACF\ACFController();

/**
 * Подключение стилей и скриптов
 */
//new Classes\ScriptsAndStyles\RegisterScriptsAndStyle();

/***
 * Отключение стандартного поля ввода контента
 */
//new Classes\DisableContentEditor\DisableContentEditorController();


/**
 * Контроллер для ajax запросов
 */
new Classes\SimpleAJAX\IndexSimpleAjax();


/**
 * Отключение пунктов меню
 */
//new Classes\DisableAdminMenu\DisableAdminMenuController();

/**
 * Кастомные типы записей
 */
//new Classes\CPT\CustomPostTypeController();


/**
 * Кастомные таксономии
 */
//new Classes\CPT\CustomTaxonomyController();

/**
 * Класс для дебага
 */
new Classes\Debugger\Debugger();

/**
 * Класс для кастомизации Административной части
 */

//\Classes\CustomAdminPanelStyle::login_head(
//    [get_bloginfo( 'template_directory' ) . '/public/css/admin.css'],
//    null
//);

/**
 * Импорт товаров со сторонних сайтов
 */
//new \Classes\Import\Init();

/**
 * Надстройка над классом вывода ошибок, необходим функция debug()
 */
new \Classes\Debugger();

/**
 * Регистрация виджетов
 */
//$widgets =  new \Classes\Widgets\Widgets(get_template_directory().'/Views/blocks');
//
//$widgets->handler_acfRegisterBlock();
//$widgets->disable_default_blocks();
