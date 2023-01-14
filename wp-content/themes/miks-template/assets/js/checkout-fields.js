// Включить радио кнопку изначально
jQuery(function () {
	var $radios = jQuery('input:radio[name=organisation]');
	var $radios1 = jQuery('input:radio[name=paywidth]');
	if ($radios.is(':checked') === false) {
		$radios.filter('[value="private_person"]').prop('checked', true);
		$radios1.filter('[value="with_nds"]').prop('checked', true);
	}
});

// Скрытие реквизитов
jQuery(document).ready(function ($) {
	$('.woocommerce-organisation-fields__field-wrapper').hide();

	$("input[name=organisation]:radio").click(function () {
		if ($('input[name=organisation]:checked').val() == "private_person") {
			$('.woocommerce-organisation-fields__field-wrapper').hide();
		} else if ($('input[name=organisation]:checked').val() == "company") {
			$('.woocommerce-organisation-fields__field-wrapper').show();
		}
	});
});