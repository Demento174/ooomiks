<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {


    /* чертеж категории товара */
    Container::make( 'term_meta', __( 'Category Properties' ) )
    ->where( 'term_taxonomy', '=', 'product_cat' )
    ->add_fields( array(
        Field::make( 'image', 'crb_thumb', __( 'Картинка на категрию' ) ),
    ) );

    Container::make( 'theme_options', 'Настройки шаблона OOO MIKS' )

    ->set_icon( 'dashicons-carrot' )
    ->add_tab( 'Логотип', array(
        Field::make( 'select', 'miks_header_logic', 'Будет использоваться логотип?' )
            ->add_options(array(
                'yes' => 'Да, буду использовать логотип',
                'no' => 'Нет, буду использовать текст',
            )),
        Field::make( 'image', 'miks_header_logo', 'Логотип' )
            ->set_conditional_logic(array(
                'relation' => 'AND',
                array(
                    'field' => 'miks_header_logic',
                    'value' => 'yes',
                    'compare' => '=',
                )
            )),
        Field::make( 'text', 'miks_header_site_name', 'Название сайта' )
            
            ->set_default_value('Сайт')
                ->set_conditional_logic(array(
                    'relation' => 'AND',
                    array(
                        'field' => 'miks_header_logic',
                        'value' => 'no',
                        'compare' => '=',
                    )
                )),
        Field::make( 'text', 'miks_header_site_desc', 'Описание сайта' )
            ->set_conditional_logic(array(
                'relation' => 'AND',
                array(
                    'field' => 'miks_header_logic',
                    'value' => 'no',
                    'compare' => '=',
                )
            ))
            ->set_default_value(get_bloginfo('description')),
    ) )

    ->add_tab( 'HEADER - шапка сайта', array(
        Field::make( 'text', 'crb_phone_header', 'Номер телефона:' )->set_default_value('Наш телефон: +1(234)567-89-10'),
        Field::make( 'text', 'crb_adres_header', 'Адрес магазина:' )->set_default_value('Наш адрес: г. Челябинск, ул. Краснознаменная, 28.'),
        Field::make( 'text', 'crb_graphrab_header', 'График работы:' )->set_default_value('График работы: ПН-ПТ с 8:30 - 18:00'),

        Field::make( 'complex', 'crb_social_urls', 'Настройка значков соц сетей: (все поля являются обязательными)' )
            ->add_fields( array(
                Field::make( 'image', 'image', 'Изображение (иконка)' ) // We're only changing the label field to an image one
                    ->set_width( 50 )
                    ->set_required(),
                Field::make( 'text', 'url', 'URL - ссылка на соц сеть' )
                    ->set_width( 50 )
                    ->set_required(),
            ) ),
    ) )

     ->add_tab( 'WOOCOMMERCE - Магазин', array(
        Field::make( 'text', 'crb_min_price', 'Минимальная сумма заказа: (указать только сумму цифрами)' )->set_default_value('400'),
        Field::make( 'rich_text', 'crb_where_delivery', __( 'Когда будет доставлен заказ (Страница чекаут)' ) ),

    ) )

    ->add_tab( 'ПОДВАЛ', array(
        Field::make( 'text', 'crb_copyright_footer', 'Копирайты сайта:' ),
        Field::make( 'complex', 'footer-pay', 'Значки оплаты' )
            ->add_fields( array(
                Field::make( 'image', 'image_pay', 'Фото значка' ) // We're only changing the label field to an image one
                    ->set_width( 50 )
                    ->set_required(),
                Field::make( 'text', 'url_pay', 'Ссылка значка' )
                    ->set_width( 50 )
                    ->set_required(),
            ) ),
    ));

    Container::make( 'post_meta', 'Настройки слайдера главной страницы' )
    ->where( 'post_type', '=', 'page' )
    ->where( 'post_template', '=', 'templates/font-page.php' )
    ->add_fields( array(
        Field::make( 'complex', 'slider_work', 'Слайдер:')
        ->add_fields( array(
            Field::make( 'image', 'photo_slide', 'Фото слайда'),
            Field::make( 'text', 'photo_title', 'Заголовок слайда (отображается в центре)'),
            Field::make( 'textarea', 'photo_disc', 'Текст описания слайда (отображается под заголовком)'),
        ))));

    Container::make( 'post_meta', 'Плюсы нашей компании: (Желательно заполнять не больше 5)' )
    ->where( 'post_type', '=', 'page' )
    ->where( 'post_template', '=', 'templates/font-page.php' )
       ->add_fields( array(
        Field::make( 'complex', 'front_plus', 'Плюсы выбора нашей компании:' )
        ->add_fields( array(
            Field::make( 'image', 'front_plus_photo', 'Значек (картинка)' ),
            Field::make( 'text', 'front_plus_title', 'Короткий заголовок' ),
            Field::make( 'text', 'front_plus_text', 'Описание плюса (желательно коротко)' ),
        )) ))
        ->add_fields( array(
            Field::make( 'complex', 'front_block', 'ОСНОВНЫЕ КАТЕГОРИИ:' )
            ->add_fields( array(
                Field::make( 'image', 'front_block_photo', 'Значек (картинка)' ),
                Field::make( 'text', 'front_block_title', 'Короткий заголовок' ),
                Field::make( 'text', 'front_block_url', 'Ссылка на категорию' ),
            )) ));


    Container::make( 'post_meta', 'Настройка страницы (О компании):' )
    ->where( 'post_type', '=', 'page' )
    ->where( 'post_template', '=', 'templates/template-aboutcomany.php' )
        ->add_fields( array(
        Field::make( 'text', 'about_title', 'Заголовок о компании' ),
        Field::make( 'rich_text', 'about_disc', 'Описание компании (до фотограций)' ),

        Field::make( 'complex', 'about_company', 'Фотографии между описаниями')
        ->add_fields( array(
            Field::make( 'image', 'photo_company', 'Фотография (картинка)'),
            Field::make( 'text', 'text_pod_photo', 'Описание фотографии'),
        )),
        Field::make( 'rich_text', 'about_after_desc', 'Описание компании (после фотографий)' ),
));

    Container::make( 'post_meta', __( 'Наши реквизиты' ) )
    ->where( 'post_type', '=', 'page' )
    ->where( 'post_template', '=', 'templates/template-aboutcomany.php' )
    ->add_fields( array(
        Field::make( 'text', 'miks_ur_adress', __( 'Юридический адрес' ) ),
        Field::make( 'text', 'miks_phone', __( 'Телефон' ) ),
        Field::make( 'text', 'miks_inn', __( 'ИНН' ) ),
        Field::make( 'text', 'miks_kpp', __( 'КПП' ) ),
        Field::make( 'text', 'miks_ogrul', __( 'ОГРЮЛ' ) ),
        Field::make( 'text', 'miks_okpo', __( 'ОКПО' ) ),
        Field::make( 'text', 'miks_okato', __( 'ОКАТО' ) ),
        Field::make( 'text', 'miks_bank', __( 'Наименование банка' ) ),
        Field::make( 'text', 'miks_schet', __( 'Расчетный счет' ) ),
        Field::make( 'text', 'miks_korschet', __( 'Корреспондирующий счет' ) ),
        Field::make( 'text', 'miks_bik', __( 'БИК' ) ),
        Field::make( 'file', 'crb_price_list', 'Price list (PDF)' ),
    ) );
/*
    Container::make( 'post_meta', 'Добавить сотрудника' )
    ->where( 'post_type', '=', 'page' )
    ->where( 'post_template', '=', 'templates/template-aboutcomany.php' )
        ->add_fields( array(
            Field::make( 'text', 'worker_titlt', 'Заголовок' ),
            Field::make( 'complex', 'worker_cont_one', 'Добавить сотрудника' )
            ->add_fields( array(
                Field::make( 'image', 'worker_photo', 'Фотография (sotr)'),
                Field::make( 'text', 'worker_fio', 'FIO'),
                Field::make( 'text', 'worker_parent', 'DOLJNIST'),
                Field::make( 'complex', 'worker_dop', 'Список песен' )
                     ->add_fields( array(
                           Field::make( 'text', 'worker_tel_em', 'Email'),
                           Field::make( 'text', 'worker_tel_numb', '3nachenie'),
                          ) )
                 ) )
        ) );
*/
 Container::make( 'post_meta', __( 'Настройка страницы контактов (Контакты магазина / Адрес / Время работы и тд' ) )
    ->where( 'post_type', '=', 'page' )
    ->where( 'post_template', '=', 'templates/template-contact.php' )
    ->add_fields( array(
    Field::make( 'text', 'contacts_dop', 'Подзаголовок страницы' ),
    Field::make( 'text', 'contacts_letter', 'Заголовок обратной связи' ),
    Field::make( 'text', 'contacts_letter_text', 'текст обратной связи' ),
    Field::make( 'text', 'contacts_title', 'Заголовок на странице' ),
    Field::make("map", "crb_company_location", "Местоположение"),
    Field::make( 'complex', 'contacts_magazine', 'Заполните поля ниже:' )
    ->add_fields( array(
        Field::make( 'image', 'contacts_magazine_photo', 'Логотип' ),
        Field::make( 'text', 'contacts_magazine_title', 'Заголовок (Адрес / телефон)' ),
        Field::make( 'text', 'contacts_magazine_text', 'Данные (номер телефона / адрес)' ),
    ))
  
));

    /* Страница ОПЛАТА */
     Container::make( 'post_meta', __( 'Настройки страницы ОПЛАТА' ) )
    ->where( 'post_type', '=', 'page' )
    ->where( 'post_template', '=', 'templates/template-pay.php' )
    ->add_fields( array(
    Field::make( 'text', 'pay_title', 'Подзаголовок под титулом страницы' ),

    Field::make( 'complex', 'pay_complex', 'Заполните поля ниже:' )
    ->add_fields( array(
        Field::make( 'text', 'pay_complex_title', 'Подзаголовок (Для способа оплаты)' ),
        Field::make( 'rich_text', 'pay_complex_text', 'Подзаголовок (Для способа оплаты)s' ),
    ))
    ));

    /* Страница ДОСТАВКА*/
     Container::make( 'post_meta', __( 'Настройки страницы ДОСТАВКА' ) )
    ->where( 'post_type', '=', 'page' )
    ->where( 'post_template', '=', 'templates/template-delivery.php' )
    ->add_fields( array(
    Field::make( 'text', 'delivery_dop', 'Подзаголовок под титулом страницы' ),

    Field::make( 'complex', 'delivery_complex', 'Заполните поля ниже:' )
    ->add_fields( array(
        Field::make( 'text', 'delivery_title', 'Подзаголовок (Для способа оплаты)' ),
        Field::make( 'text', 'delivery_text', 'Подзаголовок (Для способа оплаты)' ),
        Field::make( 'text', 'delivery_price', 'Подзаголовок (Для способа оплаты)' ),
    ))
    ));

}

?>