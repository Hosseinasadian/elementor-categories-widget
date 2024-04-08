jQuery(document).ready(function () {
	jQuery('.rtl-toggle-categories').click(function (e) {
		e.preventDefault();
		let el = jQuery(this);
		let prev = el.prev();
		if (prev.hasClass('rtl-hide-extra-categories')) {
			el.find('span:first-child').html(rtl_translations.show_less_categories)
			el.find('svg').replaceWith('<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><g><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 10.828l-4.95 4.95-1.414-1.414L12 8l6.364 6.364-1.414 1.414z"></path></g></svg>')
		} else {
			el.find('span:first-child').html(rtl_translations.show_more_categories)
			el.find('svg').replaceWith('<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><g><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></g></svg>')
		}
		prev.toggleClass('rtl-hide-extra-categories');
	})
})
