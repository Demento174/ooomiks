jQuery(function () {
	$('.header__burgers').click(function (event) {
		$('.header__burgers,.header__menus').toggleClass('actives');
		$('.fa-cart-shopping,.fa-user-o,.fa-search').toggleClass('color');
		$('.mini-cart-count').toggleClass('border');
		$('body').toggleClass('locks');
	});
	$('.search__adaptive').click(function (event) {
		$('.search_form').toggleClass('search__active');
	});
	$('.filter_button').click(function (event) {
		$('.widget-title').toggleClass('title_actives');
		$('.filter_button').toggleClass('filter_active');
		$('.price_slider_wrapper').toggleClass('actives');
	});

	$('.miks__filter__button').click(function (event) {
		$('.sidebar__shop').toggleClass('sidebar_active');
		$('.show__filter__text').toggleClass('text__hidden');
		$('.hide__filter__text').toggleClass('text__active');
		//$('.bapf_body').addClass('hide');
	});

	document.querySelectorAll('.berocket_single_filter_widget').forEach(label =>
		label.addEventListener('click', function () {
			this.classList.toggle('checked');
		}))
});