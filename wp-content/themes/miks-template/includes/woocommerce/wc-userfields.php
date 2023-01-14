<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
// когда пользователь сам редактирует свой профиль
add_action( 'show_user_profile', 'true_show_profile_fields' );
// когда чей-то профиль редактируется админом например
add_action( 'edit_user_profile', 'true_show_profile_fields' );

function true_show_profile_fields( $user ) {
	// выводим заголовок для наших полей
 	echo '<h3>Дополнительная информация в Админ панеле</h3>';
	// поля в профиле находятся в рамметке таблиц <table>
 	echo '<table class="form-table">';
 	// добавляем поле billing_company
	$den_company = get_the_author_meta( 'billing_company', $user->ID );
 	echo '<tr><th><label for="billing_company">den_company</label></th>
 	<td><input type="text" name="billing_company" id="billing_company" value="' . esc_attr( $den_company ) . '" class="regular-text" /></td>
	</tr>';

    // добавляем поле den_inn
	$den_inn = get_the_author_meta( 'organisation_inn', $user->ID );
    echo '<tr><th><label for="organisation_inn">organisation_inn</label></th>
    <td><input type="text" name="organisation_inn" id="organisation_inn" value="' . esc_attr( $den_inn ) . '" class="regular-text" /></td>
   </tr>';
   // добавляем поле den_kpp
	$den_kpp = get_the_author_meta( 'organisation_kpp', $user->ID );
    echo '<tr><th><label for="organisation_kpp">organisation_kpp</label></th>
    <td><input type="text" name="organisation_kpp" id="organisation_kpp" value="' . esc_attr( $den_kpp ) . '" class="regular-text" /></td>
   </tr>';
   // добавляем поле den_ur_adress
	$den_ur_adress = get_the_author_meta( 'organisation_ur_adress', $user->ID );
    echo '<tr><th><label for="organisation_ur_adress">organisation_ur_adress</label></th>
    <td><input type="text" name="organisation_ur_adress" id="organisation_ur_adress" value="' . esc_attr( $den_ur_adress ) . '" class="regular-text" /></td>
   </tr>';
 	echo '</table>';
}

// когда пользователь сам редактирует свой профиль
add_action( 'personal_options_update', 'true_save_profile_fields' );
// когда чей-то профиль редактируется админом например
add_action( 'edit_user_profile_update', 'true_save_profile_fields' );
 
function true_save_profile_fields( $user_id ) {
	update_user_meta( $user_id, 'billing_company', sanitize_text_field( $_POST[ 'billing_company' ] ) );
	update_user_meta( $user_id, 'organisation_inn', sanitize_text_field( $_POST[ 'organisation_inn' ] ) );
	update_user_meta( $user_id, 'organisation_kpp', sanitize_text_field( $_POST[ 'organisation_kpp' ] ) );
	update_user_meta( $user_id, 'organisation_ur_adress', sanitize_text_field( $_POST[ 'organisation_ur_adress' ] ) );
}

// Добавление инфо юр лица в панели упрвления (Профиле пользователя)
add_action( 'woocommerce_edit_account_form', 'den_dop_fild' );
function den_dop_fild() {
    $user = wp_get_current_user();
		echo '<h2>Введите название организации:</h2>';
		echo '<p class="info">Если вы <b>не являетесь</b> юридическим лицом, просим Вас не заполнять эти поля!</p>'
?>
<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
	<label for="billing_company"><?php _e( 'Название организации: ', 'woocommerce' ); ?></label>
	<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_company"
		id="billing_company" value="<?php echo esc_attr( $user->billing_company ); ?>" />
</p>

<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
	<label for="organisation_inn"><?php _e( 'ИНН огранизации:', 'woocommerce' ); ?></label>
	<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="organisation_inn"
		id="organisation_inn" value="<?php echo esc_attr( $user->organisation_inn ); ?>" />
</p>

<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
	<label for="organisation_kpp"><?php _e( 'КПП организации:', 'woocommerce' ); ?></label>
	<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="organisation_kpp"
		id="organisation_kpp" value="<?php echo esc_attr( $user->organisation_kpp ); ?>" />
</p>

<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
	<label for="organisation_ur_adress"><?php _e( 'Юридический адрес:', 'woocommerce' ); ?></label>
	<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="organisation_ur_adress"
		id="organisation_ur_adress" value="<?php echo esc_attr( $user->organisation_ur_adress ); ?>" />
</p>

<?php
}

// СОХРАНЕНИЕ полей джля юр лица в профииле (РАБОЧЕЕ)
add_action( 'woocommerce_save_account_details', 'den_save_ur_field', 12, 1 );
function den_save_ur_field( $user_id ) {
    // For organisation_name
    if( isset( $_POST['billing_company'] ) )
        update_user_meta( $user_id, 'billing_company', sanitize_text_field( $_POST['billing_company'] ) );

	// For organisation_address
    if( isset( $_POST['organisation_inn'] ) )
        update_user_meta( $user_id, 'organisation_inn', sanitize_text_field( $_POST['organisation_inn'] ) );
	
	// For organisation_inn
    if( isset( $_POST['organisation_kpp'] ) )
        update_user_meta( $user_id, 'organisation_kpp', sanitize_text_field( $_POST['organisation_kpp'] ) );
	
	// For organisation_kpp
    if( isset( $_POST['organisation_ur_adress'] ) )
        update_user_meta( $user_id, 'organisation_ur_adress', sanitize_text_field( $_POST['organisation_ur_adress'] ) );

}

/* создание доп вкладки */
/*
add_filter( 'woocommerce_product_tabs', 'truemisha_new_product_tab', 35 );
function truemisha_new_product_tab( $tabs ) {
 
	$tabs[ 'new_super_tab' ] = array(
		'title' 	=> 'Дополнительная вкладка',
		'priority' 	=> 35,
		'callback' 	=> 'truemisha_new_tab_content'
	);
	return $tabs;
}
function truemisha_new_tab_content() {
	echo '<p>Какой-то HTML код для вкладки</p>';
}
*/

/* Настрока табов товаров */
add_filter( 'woocommerce_product_tabs', 'truemisha_rename_tabs', 25 );
 
function truemisha_rename_tabs( $tabs ) {
	//echo '<pre>';
	//echo print_r($tabs);
	//echo '</pre>';
	if( empty( $tabs[ 'additional_information' ] ) ) {
	unset( $tabs[ 'additional_information' ] );
	}
	else {
	$tabs[ 'additional_information' ][ 'title' ] = 'Характеристики';
	}

	if( empty( $tabs[ 'description' ] ) ) {
	unset( $tabs[ 'description' ] );
	}else {
 	$tabs[ 'description' ][ 'title' ] = 'О товаре';
	}
	
	if( empty( $tabs[ 'reviews' ] ) ) {
	unset( $tabs[ 'reviews' ] );
	}
	else {
	$tabs[ 'reviews' ][ 'title' ] = 'Мнения клиентов';
	}

	if( empty( $tabs[ 'new_super_tab' ] ) ) {
	unset( $tabs[ 'new_super_tab' ] );
	}
	
	return $tabs;

}



/* В карточке товара информация о доставке и самовывозе */
add_action( 'woocommerce_single_product_summary', 'miks_info_delivery', 25 );
function miks_info_delivery(){
	?>
<div class="info_delivery_tovar checkout_delivery_pay">
	<p>Доставка по Челябинску - 400 руб</p>
	<p>Доставка до двери при заказе от 30тыс/руб - бесплатно</p>
	<p>Свамовывоз - бесплатно</p>
	<p>Транспортными по России - цена зависит от выбраной ТК</p>
</div>
<?php
}

//add_action( 'woocommerce_single_product_summary', 'woocommerce1cStockTab', 15 );
// (1) добавим нашу вкладку в набор вкладок товара
/*
add_filter('woocommerce_product_tabs', function ($tabs) {
    $tabs['woocommerce1cStockTab'] = [
        'title' => __('Наличие склад / магазин', 'child-theme'),
        'priority' => 50,
        'callback' => 'woocommerce1cStockTab'
    ];

    return $tabs;
});
*/
// (2) метод, который формирует содержимое нашей вкладки
/*
function woocommerce1cStockTab() {
	// получим набор складов
	$stocks = get_option('all_1c_stocks', []);

	// получим данные по остаткам в товаре
	$productStockData = get_post_meta(get_the_ID(), '_separate_warehouse_stock', true);
		echo '<h3>Наличие в магазине:</h3>';
		echo '<ul>';
			// пробежим по набору складов и отобразим каждый в виде названия
			// и значения остатка в этом товаре
			foreach ($stocks as $guid => $warehouse) {
			echo '<li>'
			. '<strong>'
			. esc_html($warehouse['Наименование'])
			. '</strong> - '
			. (isset($productStockData[$guid]) ? $productStockData[$guid] : 0)
			. ' шт.</li>';
			}
		echo '</ul>';
}*/