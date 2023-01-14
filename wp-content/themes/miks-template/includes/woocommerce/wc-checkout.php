<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/* Настройка страницы оформления заказа */

// удаляем ненужные поля
add_filter( 'woocommerce_checkout_fields', 'wpbl_remove_some_fields', 1 );
function wpbl_remove_some_fields( $array ) {
    unset( $array['billing']['billing_address_2'] ); // 2-ая строка адреса 
    unset( $array['billing']['billing_state'] ); // Область / район
    unset( $array['billing']['billing_postcode'] ); // Почтовый индекс
    /*
    $radioVal == $_POST["organisation"];
       if($radioVal = "private_person") {
        unset( $array['billing']['billing_company'] ); // Компания
    }*/
    return $array;
}


// меняем пласехолдер

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' , 1);

function custom_override_checkout_fields( $fields ) {
    $fields['billing']['billing_first_name']['placeholder'] = 'Ваше имя...*';
    $fields['billing']['billing_first_name']['label'] = false;
    $fields['billing']['billing_first_name']['priority'] = 1;
    $fields['billing']['billing_first_name']['autofocus'] = false;
    
    $fields['billing']['billing_last_name']['placeholder'] = 'Ваша фамилия...*';
    $fields['billing']['billing_last_name']['label'] = false;
    $fields['billing']['billing_last_name']['priority'] = 2;

    $fields['billing']['billing_email']['placeholder'] = 'e-mail...*';
    $fields['billing']['billing_email']['label'] = false;
    $fields['billing']['billing_email']['priority'] = 3;

    $fields['billing']['billing_phone']['placeholder'] = 'Телефон...*';
    //$fields['billing']['billing_phone']['class'][0] = 'form-row-wide';
    $fields['billing']['billing_phone']['label'] = false;
    $fields['billing']['billing_phone']['priority'] = 4;

    $fields['billing']['billing_address_1']['label'] = false;
    $fields['billing']['billing_address_1']['priority'] = 5;

    $fields['billing']['billing_city']['placeholder'] = 'Ваш город...*';
    $fields['billing']['billing_city']['label'] = false;
    $fields['billing']['billing_city']['priority'] = 6;

    $fields['billing']['billing_company']['placeholder'] = 'Наименование организации (Bk)*';
    $fields['billing']['billing_company']['label'] = false;
    $fields['billing']['billing_company']['priority'] = 7;
    $fields['billing']['billing_company']['class'] = array('displaynone', 'form-row-wide');


    $fields['order']['order_comments']['placeholder'] = 'Ваши пожелания (дополнения) к заказу...';
    $fields['order']['order_comments']['label'] = false;

    //echo '<pre>'; print_r( $fields ); echo '</pre>';
    
    return $fields;
}
// Меняем приоритет адреса доставки
add_filter('woocommerce_default_address_fields', 'wc_override_address_fields');
function wc_override_address_fields( $fields ) {
	$fields['address_1']['placeholder'] = 'Улица и номер дома...*';
	$fields['address_1']['priority'] = 80;
	return $fields;
}

// Добавление выбора физ. или юр. лицо
add_action( 'woocommerce_after_checkout_billing_form', 'organisation_checkout_field' );
function organisation_checkout_field( $checkout ) {
    echo '<div id="organisation_checkout_field">';
    woocommerce_form_field( 'organisation', array(
        'type'    => 'radio',
        'class'   => array('form-row-wide'),
        'label'   =>  '',
	    'options' => array(
			'private_person' => 'Я физическое лицо',
			'company' => 'Я юридическое лицо',
		)
        ), $checkout->get_value( 'organisation' ));
    echo '</div>';
}

add_action( 'woocommerce_legal_face', 'my_custom_checkout_field_legal_face' );
function my_custom_checkout_field_legal_face( $checkout ) {
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;
    $user = wp_get_current_user();
    $radioVal = $_POST["organisation"];
    
    global $woocommerce, $post;

    echo '<div class="woocommerce-organisation-fields__field-wrapper"><h2>Реквизиты организации</h2>';

    woocommerce_form_field( 'billing_company', array(
		'required'      => true,
        'autocomplete' => 'organization',
        'priority'  => '888',
        'type'          => 'text',
        'class'         => array('form-row-wide'),
        'placeholder'   => __('Наименование организации...*'),
        'maxlength'         => 100, //максимум 100
    ),  $user->billing_company);
	
	woocommerce_form_field( 'organisation_inn', array(
		'required'      => true,
        'type'          => 'text',
        'class'         => array('form-row-wide'),
        'placeholder'   => __('ИНН организации...*'),
        'maxlength'         => 12, //максимум 12 символов ИНН
    ), $user->organisation_inn);
	
	woocommerce_form_field( 'organisation_kpp', array(
		'required'      => true,
        'type'          => 'text',
        'class'         => array('form-row-wide'),
        'placeholder'   => __('КПП организации...*'),
        'maxlength'         => 9, //максимум 9 символов ИНН
    ), $user->organisation_kpp);
	
	woocommerce_form_field( 'organisation_ur_adress', array(
		'required'      => true,
        'type'          => 'text',
        'class'         => array('form-row-wide'),
        'placeholder'   => __('Юридический адрес...*'),
        'maxlength'         => 120, //максимум 120

    ), $user->organisation_ur_adress);

    echo '<div id="organisation_checkout_field">';
    woocommerce_form_field( 'paywidth', array(
        'type'    => 'radio',
        'class'   => array('form-row-wide'),
        'label'   =>  '',
	    'options' => array(
			'with_nds' => 'Выставить счет с НДС', // Название кнопки
			'no_nds' => 'Выставить счет без НДС', // Название кнопки
		)
        ), $user->paywidth);

       // echo '<pre>'; print_r( $fields ); echo '</pre>';

    echo '</div>';
    echo '</div>';

}

/* Блок ошибок если не введены поля */
/*
Функция верификации (заполнены ли обязательные поля).
Особенностью функции является вывод предупреждения только в случае если выбрано юр. лицо:
*/
add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');
function my_custom_checkout_field_process() {
	$radioVal = $_POST["organisation"];

	if($radioVal == "company") {
		if ( ! $_POST['billing_company'] ) wc_add_notice( __( '<strong>Наименование компании/strong> является обязательным полем.' ), 'error' );

		if ( ! $_POST['organisation_inn'] ) wc_add_notice( __( '<strong>ИНН</strong> является обязательным полем.' ), 'error' );
		if ( ! $_POST['organisation_kpp'] ) wc_add_notice( __( '<strong>КПП</strong> является обязательным полем.' ), 'error' );
		if ( ! $_POST['organisation_ur_adress'] ) wc_add_notice( __( '<strong>Юр адрес</strong> является обязательным полем.' ), 'error' );
        if ( ! $_POST['paywidth'] ) wc_add_notice( __( '<strong>Параметры выставления счета</strong> является обязательным полем.' ), 'error' );
    }
}

/** Обновляем метаданные заказа со значением поля */

add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );
function my_custom_checkout_field_update_order_meta( $order_id ) {

$radioVal = $_POST["organisation"];
$radioVal1 = $_POST["paywidth"];

if ( ! empty( $_POST['billing_company'] ) ) {
    update_post_meta( $order_id, 'billing_company', sanitize_text_field( $_POST['billing_company'] ) ); }
    
if ( ! empty( $_POST['organisation_inn'] ) ) {
    update_post_meta( $order_id, 'organisation_inn', sanitize_text_field( $_POST['organisation_inn'] ) ); }
if ( ! empty( $_POST['organisation_kpp'] ) ) {
    update_post_meta( $order_id, 'organisation_kpp', sanitize_text_field( $_POST['organisation_kpp'] ) ); }
if ( ! empty( $_POST['organisation_ur_adress'] ) ) {
    update_post_meta( $order_id, 'organisation_ur_adress', sanitize_text_field( $_POST['organisation_ur_adress'] ) ); }

if($radioVal == "company") {
    update_post_meta( $order_id, 'company', 'on' ); }
else {
    update_post_meta( $order_id, 'company' , 'off' ); }

if($radioVal1 == "with_nds") {
    update_post_meta( $order_id, 'paywidth', 'Выставить счет с НДС' ); }
else {
    update_post_meta( $order_id, 'paywidth' , 'Выставить счет без НДС' ); }
}


// Вывести реквизиты в бланке заказа () СТРАНИЦА СПАСИБО!
add_action( 'woocommerce_order_details_after_customer_details', 'organisation_checkout_field_echo_in_order' );
function organisation_checkout_field_echo_in_order($order) {
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;
	$user_id_company = get_post_meta( $user_id, 'company', 'on' );
    $mikse = get_post_meta( $order->id, 'company', true );
  /*
  echo '<pre>';
  echo print_r( $mikse );
  echo '</pre>';
  */
  if($mikse == 'on') { 
        echo '<div class="orders__company__on">';
        echo '<header class="woocommerce-Address-title title">';
		echo '<h2>Реквизиты компании</h2>';
        echo '</header>';
        echo '<p>Изминить реквизиты вы можете на странице детали профиля</p>';

        echo '<br><br>';
		echo 'Наименование Вашей организации: ';
        echo '<b>';
        echo get_post_meta( $order->id, 'billing_company', true );
        echo '</b>';
        echo '<br><br>';

        echo 'ИНН организации: ';
        echo '<b>';
        echo get_post_meta( $order->id, 'organisation_inn', true );
        echo '</b>';
        echo '<br><br>';

        echo 'КПП организации: ';
        echo '<b>';
        echo get_post_meta( $order->id, 'organisation_kpp', true );
        echo '</b>';
        echo '<br><br>';

        echo 'Юридический адрес: '; 
        echo '<b>';
        echo get_post_meta( $order->id, 'organisation_ur_adress', true );
        echo '</b>';
        echo '<br><br>';

        echo 'Выставление счета: ';
        echo '<b>';
        echo get_post_meta( $order->id, 'paywidth', true );
        echo '</b>';
        echo '</div>';

	}
    else {
        echo '';
    }
}

// вывести Информацию об организации
add_action( 'woocommerce_insert_organisation_details', 'organisation_checkout_field_echo_in_order' );
add_filter( 'woocommerce_get_order_item_totals', 'truemisha_field_in_email', 25, 2 );
 
function truemisha_field_in_email( $rows, $order ) {
 
 	// удалите это условие, если хотите добавить значение поля и на страницу "Заказ принят"
    /*
	if( is_order_received_page() ) {
		return $rows;
	}
*/
    if ( ! empty( $_POST['billing_company'] ) )  {
    $rows[ 'billing_company' ] = array(
    'label' => 'Название организации: ',
    'value' => get_post_meta( $order->get_id(), 'billing_company', true )
    );

    $rows[ 'organisation_inn' ] = array(
    'label' => 'ИНН организации: ',
    'value' => get_post_meta( $order->get_id(), 'organisation_inn', true )
    );

    $rows[ 'organisation_kpp' ] = array(
    'label' => 'КПП организации: ',
    'value' => get_post_meta( $order->get_id(), 'organisation_kpp', true )
    );

    $rows[ 'organisation_ur_adress' ] = array(
    'label' => 'Юридический адрес: ',
    'value' => get_post_meta( $order->get_id(), 'organisation_ur_adress', true )
    );

    $rows[ 'paywidth' ] = array(
    'label' => 'Выствление счета: ',
    'value' => get_post_meta( $order->get_id(), 'paywidth', true )
    );

}
return $rows;
}

// ниже информации о плательщике
function cloudways_show_email_order_meta_customer( $order, $sent_to_admin, $plain_text ) {
  $billing_company = get_post_meta( $order->id, 'billing_company', true );

  $organisation_inn = get_post_meta( $order->id, 'organisation_inn', true );
  $organisation_kpp = get_post_meta( $order->id, 'organisation_kpp', true );
  $organisation_ur_adress = get_post_meta( $order->id, 'organisation_ur_adress', true );
  $paywidth = get_post_meta( $order->id, 'paywidth', true );
  if( $billing_company ){
      if ( $sent_to_admin ) {
        echo '<h2>Информация о компании (СТРОКА 310)</h2>';
        echo 'Название организации: ' . $billing_company;
        echo '<br>';
        echo 'ИНН организации: ' . $organisation_inn;
        echo '<br>';
        echo 'КПП организации: ' . $organisation_kpp;
        echo '<br>';
        echo 'Юридический адрес: ' . $organisation_ur_adress;
        echo '<br>';
        echo 'Выставление счета: ' . $paywidth;
        echo '<br>';
      }
  }
  else {
    echo '<h2>Информация о компании (СТРОКА 324)</h2>';
    echo '<br>Клиент не является юридическим лицом<br>';
    echo '<br>';
  }
}
add_action('woocommerce_email_customer_details', 'cloudways_show_email_order_meta_customer', 30, 3 );

/**
 * Информация о заказе на странице редактирования заказа в панели администратора
 * Выводим значение поля на странице редактирования заказа (в админ панеле)
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
    $mikse = get_post_meta( $order->id, 'company', true );
    if($mikse == 'on') {
    echo '<h3>Информация о компании:</h3>';
    echo '<p><strong>'.__('Название организации: ').':</strong> ' . get_post_meta( $order->id, 'billing_company', true ) . '</p>';
    echo '<p><strong>'.__('ИНН организации').':</strong> ' . get_post_meta( $order->id, 'organisation_inn', true ) . '</p>';
    echo '<p><strong>'.__('КПП организации').':</strong> ' . get_post_meta( $order->id, 'organisation_kpp', true ) . '</p>';
    echo '<p><strong>'.__('Юридический адрес организации').':</strong> ' . get_post_meta( $order->id, 'organisation_ur_adress', true ) . '</p>';
    echo '<p><strong>'.__('Счет с НДС или НЕТ?').':</strong> ' . get_post_meta( $order->id, 'paywidth', true ) . '</p>';
    }
    else {
        echo '<h3>Информация о компании:</h3>';
        echo 'Клиент не является юридичесским лицом.';
    }
}

/* добавление онформации на почту */
add_action( 'woocommerce_email_customer_details', 'woocommerce_email_after_order_table_func', 50 );
function woocommerce_email_after_order_table_func() {
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;
	$user_id_company = get_user_meta( $user_id, 'company', 'on' );
	if($user_id_company) {
	?>

<h3>Реквизиты компании (362)</h3>
<table>
	<tr>
		<td><strong>Адрес: </strong></td>
		<td><?php echo wptexturize( get_user_meta( $order_id, 'organisation_address', true ) ); ?></td>
	</tr>
	<tr>
		<td><strong>ИНН: </strong></td>
		<td><?php echo wptexturize( get_user_meta( $user_id, 'organisation_inn', true ) ); ?></td>
	</tr>
	<tr>
		<td><strong>КПП: </strong></td>
		<td><?php echo wptexturize( get_user_meta( $user_id, 'organisation_kpp', true ) ); ?></td>
	</tr>
</table>

<?php
	}
}
// СОХРАНЕНИЕ полей для юр лица в профииле
add_action( 'woocommerce_save_account_details', 'save_favorite_color_account_details', 12, 1 );
function save_favorite_color_account_details( $user_id ) {
    // For billing_company
    if( isset( $_POST['billing_company'] ) )
        update_user_meta( $user_id, 'billing_company', sanitize_text_field( $_POST['billing_company'] ) );

	// For organisation_address
    if( isset( $_POST['organisation_address'] ) )
        update_user_meta( $user_id, 'organisation_address', sanitize_text_field( $_POST['organisation_address'] ) );
	
	// For organisation_inn
    if( isset( $_POST['organisation_inn'] ) )
        update_user_meta( $user_id, 'organisation_inn', sanitize_text_field( $_POST['organisation_inn'] ) );
	
	// For organisation_kpp
    if( isset( $_POST['organisation_kpp'] ) )
        update_user_meta( $user_id, 'organisation_kpp', sanitize_text_field( $_POST['organisation_kpp'] ) );
	
}

/* Скрывать способы доставки */
add_filter( 'woocommerce_package_rates', 'truemisha_remove_shipping_method', 20, 2 );
function truemisha_remove_shipping_method( $rates, $package ) {
  
	// удаляем способ доставки, если доступна бесплатная
	if ( isset( $rates[ 'free_shipping:1' ] ) ) {
	    unset( $rates[ 'flat_rate:2' ] );
	}
	if ( isset( $rates[ 'free_shipping:3' ] ) ) {
	    unset( $rates[ 'free_shipping:1' ] );
      unset( $rates[ 'flat_rate:2' ] );
	}
	return $rates;
}

/* Способы оплаты */

add_filter( 'woocommerce_available_payment_gateways', 'kvk_field_cheque_payment_method', 20, 1);
function kvk_field_cheque_payment_method( $gateways ){
if( !is_admin() ) {
    foreach( $gateways as $gateway_id => $gateway ) {

        if( WC()->session->get( 'is_company' ) ){
            unset( $gateways['cod'] );
            unset( $gateways['all'] );
        } else {
			unset( $gateways['bacs'] );
		}
    }
    return $gateways;
}
}

// The WordPress Ajax PHP receiver
add_action( 'wp_ajax_kvk_nummer', 'get_ajax_kvk_nummer' );
add_action( 'wp_ajax_nopriv_kvk_nummer', 'get_ajax_kvk_nummer' );
function get_ajax_kvk_nummer() {
	
    if ( $_POST['organisation'] == 'company' ){
        WC()->session->set('is_company', '1');

    } else {
        WC()->session->set('is_company', '0');
    }
    die();
}


// The jQuery Ajax request
add_action( 'wp_footer', 'checkout_kvk_fields_script' );
function checkout_kvk_fields_script() {
    // Only checkout page
    if( is_checkout() && ! is_wc_endpoint_url() ):

    // Remove "is_company" custom WC session on load
    if( WC()->session->get('is_company') ){
        WC()->session->__unset('is_company');
    }
    ?>
<script type="text/javascript">
jQuery(function($) {
	var a = 'input[name=organisation]';

	// Ajax function
	function checkKvkNummer(value) {
		$.ajax({
			type: 'POST',
			url: wc_checkout_params.ajax_url,
			data: {
				'action': 'kvk_nummer',
				'organisation': $('input[name=organisation]:checked').val(),
				//'organisation': value != '' ? 1 : 0, // чредование значений для валидации text или включения checkbox
			},
			success: function(result) {
				$('body').trigger('update_checkout');
			}
		});
	}

	// On start
	checkKvkNummer($(a).val());

	// On change event
	$(a).change(function() {
		checkKvkNummer($(this).val());
	});
});
</script>
<?php
    endif;
};

/* ограничение на минимальную сумму заказа */

add_action( 'woocommerce_checkout_process', 'truemisha_no_checkout_min_order_amount' );
function truemisha_no_checkout_min_order_amount() {
    // Минимальная сумма заказа берется из настроек в теме!
    $minimum_amount = carbon_get_theme_option( 'crb_min_price' );

	if ( WC()->cart->subtotal < $minimum_amount ) {
		wc_add_notice( 
			sprintf( 
				'<b>Минимальная сумма заказа %s</b>, а у вы хотите заказать всего лишь на %s.',
				wc_price( $minimum_amount ),
				wc_price( WC()->cart->subtotal )
			),
			'error'
		);
	}
}

// Добавление чекбокса
add_action( 'woocommerce_review_order_before_submit', 'truemisha_privacy_checkbox', 15 );
 
function truemisha_privacy_checkbox() {

    echo "<div class='privacy__policy'>";
	woocommerce_form_field( 'privacy_policy_checkbox', array(
		'type'          => 'checkbox',
		'class'         => array( 'form-row' ),
		'label_class'   => array( 'woocommerce-form__label-for-checkbox' ),
		'input_class'   => array( 'woocommerce-form__input-checkbox' ),
		'required'      => true,
		'label'         => 'Принимаю <a href="' . get_privacy_policy_url() . '">политику конфиденциальности</a>',
	));
    echo "</div>";
}
 
// Валидация
add_action( 'woocommerce_checkout_process', 'truemisha_privacy_checkbox_error', 25 );
 
function truemisha_privacy_checkbox_error() {
 
	if ( empty( $_POST[ 'privacy_policy_checkbox' ] ) ) {
		wc_add_notice( 'Для заказа на сайте, Вам нужно принять политику конфиденциальности!', 'error' );
	}
 
}

/* Передать инн в 1 с */
add_filter('itglx_wc1c_order_xml_contragent_data_array', function ($contragentData, $order) {
    /*
     * заполним ИНН контрагента из меты заказа, при генерации XML получится тег в "Контрагент->ИНН",
     * то есть прямой потомок, как, например "Роль"
     */
    $contragentData['Наименованиеорганизации1'] = get_post_meta($order->get_id(), 'billing_company', true);
    $contragentData['ИНН'] = get_post_meta($order->get_id(), 'organisation_inn', true);
    $contragentData['КПП'] = get_post_meta($order->get_id(), 'organisation_kpp', true);
    $contragentData['ЮРадрес'] = get_post_meta($order->get_id(), 'organisation_ur_adress', true);
    $contragentData['ТИПсчета'] = get_post_meta($order->get_id(), 'paywidth', true);
  
    return $contragentData;
}, 10, 2);