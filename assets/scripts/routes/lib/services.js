/* eslint-disable no-console, no-unused-vars, no-undef */

export const updateButtonClicks = () => {
	const linkItem = $('.services-column__link');

	linkItem.on('click', (e) => {
		const element = $(e.currentTarget);
		const PostId = element.attr('data-post-id');

		if(!PostId) {
			return;
		}

		$.ajax({
			url: oppijaportaali_js.ajax_url,
			type: 'POST',
			data: ({
				action: 'update_service_open_count',
				postId: PostId,
				metaKey: '_service_clicks',
			}),
			success: function () {

			}
		});
	});
};

export const allServicesToggler = () => {
	$('.all-services-toggler').on('click', (e) => {
		e.preventDefault();
		const target = $(e.currentTarget);
		const inactiveServices = $('.services-row--inactive');
		target.toggleClass('all-services-toggler--open');
		target.attr('aria-expanded', (i, attr) => {
			return attr === 'true' ? 'false' : 'true'
		});
		inactiveServices.slideToggle(800);
	});
};

export const addToServices = () => {
	$(document).on('click', '.services-item-dropdown__link--add', (e) => {
		e.preventDefault();
		const target = $(e.currentTarget);
		target.addClass('disabled');
		const serviceId = target.attr('data-item-id');
		const activeServices = $('.services-row--active');
		const closestColumn = target.closest('.services-column');

		$.ajax({
			url: oppijaportaali_js.ajax_url,
			type: 'POST',
			data: ({
				action: 'add_service_to_favorites',
				service_id: serviceId,
				user_id: oppijaportaali_js.user_id
			}),
			success: function (content) {
				closestColumn.fadeOut();
				activeServices.html(content);
			}
		});
	});
}

export const removeFromServices = () => {
	const inactiveServices = $('.services-row--inactive');
	inactiveServices.hide();

	$(document).on('click', '.services-item-dropdown__link--remove', (e) => {
		e.preventDefault();
		const target = $(e.currentTarget);
		target.addClass('disabled');
		const serviceId = target.attr('data-item-id');
		const closestColumn = target.closest('.services-column');

		$.ajax({
			url: oppijaportaali_js.ajax_url,
			type: 'POST',
			data: ({
				action: 'remove_service_from_favorites',
				service_id: serviceId,
				user_id: oppijaportaali_js.user_id
			}),
			success: function (content) {
				closestColumn.fadeOut();
				inactiveServices.html(content);
			}
		});
	});
}

export const servicesToggler = () => {
	$(document).on('click', '.services-column__toggler', (e) => {
		e.preventDefault();
		const target = $(e.currentTarget);
		target.next().toggleClass('services-item-dropdown--open');

		target.attr('aria-expanded', (i, attr) => {
			return attr === 'true' ? 'false' : 'true'
		});
	});
}
