/* eslint-disable no-console,no-undef */

const activeRow = $('.services-row--active');
const inactiveRow = $('.services-row--inactive');
const nameInput = $('#service-name-input');
const urlInput = $('#service-url-input');

const setServicesRow = (setVisible, content) => {
	if(setVisible === 1) {
		activeRow.html(content);
	} else {
		inactiveRow.html(content);
	}
};

const clearInputs = () => {
	nameInput.val('');
	urlInput.val('');
};

const addNewOwnService = () => {
	const form = $("#add-new-service-form");
	const notifications = $('.add-new-service-form__notifications');
	form.submit(function (event) {
		event.preventDefault();
		notifications.hide();
		const serviceName = nameInput.val();
		const serviceUrl = urlInput.val();

		if (!serviceName || !serviceUrl) {
			notifications.show();
			notifications.text(oppijaportaali_js.add_new_form_errors);
			return;
		}

		form.addClass('form-loading');

		$.ajax({
			url: oppijaportaali_js.ajax_url,
			type: 'POST',
			data: ({
				action: 'add_new_own_service',
				service_details: {
					serviceName: serviceName,
					serviceUrl: serviceUrl
				},
				user_id: oppijaportaali_js.user_id,
				nonce: oppijaportaali_js.nonce
			}),
			success: function (content) {
				notifications.show();
				form.removeClass('form-loading');
				notifications.text(oppijaportaali_js.new_service_added);
				inactiveRow.html(content);
				clearInputs();

				setTimeout(() => {
					notifications.fadeOut();
				},5000);
			}
		});
	});
};

const removeOwnService = () => {
	$(document).on('click', '.services-item-dropdown__link--remove-own', (e) => {
		e.preventDefault();
		const target = $(e.currentTarget);
		const ownId = target.attr('data-own-service-id');
		const ownIdentifier = target.attr('data-own-service-identifier');
		const closestColumn = target.closest('.services-column');

		$.ajax({
			url: oppijaportaali_js.ajax_url,
			type: 'POST',
			data: ({
				action: 'remove_own_service',
				serviceId: ownId,
				serviceIdentifier: ownIdentifier,
				userId: oppijaportaali_js.user_id,
				nonce: oppijaportaali_js.nonce
			}),
			success: function (content) {
				alert(content);
				closestColumn.fadeOut();
			}
		});
	});
}

const pinOwnService = () => {
	$(document).on('click', '.services-item-dropdown__link--pin-own', (e) => {
		e.preventDefault();
		const target = $(e.currentTarget);
		const ownId = target.attr('data-own-service-id');
		const setVisible = target.attr('data-own-service-set-visible');
		const ownIdentifier = target.attr('data-own-service-identifier');
		const closestColumn = target.closest('.services-column');

		$.ajax({
			url: oppijaportaali_js.ajax_url,
			type: 'POST',
			data: ({
				action: 'pin_own_service',
				serviceId: ownId,
				serviceIdentifier: ownIdentifier,
				setVisible: setVisible,
				userId: oppijaportaali_js.user_id,
				nonce: oppijaportaali_js.nonce
			}),
			success: function (content) {
				setServicesRow(parseInt(setVisible), content);
				closestColumn.fadeOut();
			}
		});
	});
}

export const ownServices = () => {
	addNewOwnService();
	removeOwnService();
	pinOwnService();
}
