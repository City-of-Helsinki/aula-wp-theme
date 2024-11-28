/* eslint-disable no-console, no-unused-vars, no-undef */

import {setMainNavMultiavatar} from "./avatar";

const body = $('body');
const hideSearch = $('#hide-search-input');
const hideDrive = $('#hide-drive-input');
const hideClassroom = $('#hide-classroom-input');
const userSettingsModal = $('#user-settings-modal');
const duckDuckWrapper = $('.search-engine-wrapper--duckduckgo');
const googleWrapper = $('.search-engine-wrapper--google');
const selectVisibility = $('#profile-image-visibility');

const setProfilePicVisibility = () => {
	selectVisibility.change(() => {
		const visibilityVal = selectVisibility.val();
		if(visibilityVal === 'use_o365') {
			body.removeClass('use-multiavatar-profile-picture use-empty-profile-picture');
			body.addClass('use-o365-profile-picture');
		}

		if(visibilityVal === 'use_multiavatar') {
			body.addClass('use-multiavatar-profile-picture');
			body.removeClass('use-o365-profile-picture use-empty-profile-picture');
		}

		if(visibilityVal === 'use_empty') {
			body.removeClass('use-multiavatar-profile-picture use-o365-profile-picture');
			body.addClass('use-empty-profile-picture');
		}
	});
};

const toggleSearchStatus = (value) => {
	if(value === 1) {
		$('body').addClass('has-search-hidden');
		duckDuckWrapper.attr('tabIndex', -1);
		googleWrapper.attr('tabIndex', -1);
	} else {
		$('body').removeClass('has-search-hidden');
		duckDuckWrapper.attr('tabIndex', 0);
		googleWrapper.attr('tabIndex', 0);
	}
};

const getHideSearchValue = () => {
	if (hideSearch.is(":checked")) {
		return 1;
	}

	return 0;
};

const getHideDriveValue = () => {
	if (hideDrive.is(":checked")) {
		return 1;
	}

	return 0;
};

const getHideClassroomValue = () => {
	if (hideClassroom.is(":checked")) {
		return 1;
	}

	return 0;
};

const openUserSettingsModal = () => {
	$('.open-user-settings').on('click', (e) => {
		e.preventDefault();
		userSettingsModal.modal('show');
	});
};

const toggleSearchEngine = (value) => {
	body.removeClass('has-search-engine-duckduckgo has-search-engine-google');
	body.addClass('has-search-engine-' + value);
	if(value === 'google') {
		duckDuckWrapper.attr('tabIndex', -1);
		googleWrapper.attr('tabIndex', 0);
	} else {
		duckDuckWrapper.attr('tabIndex', 0);
		googleWrapper.attr('tabIndex', -1);
	}
};

const updateUserSettings = () => {
	const form = $("#update-user-settings-form");
	const notifications = $('.update-user-settings-form__notifications');
	form.submit(function (event) {
		event.preventDefault();
		notifications.hide();
		const profilePictureVal = $('#profile-image-input').val();
		const profilePictureVisibility = $('#profile-image-visibility').val();
		const searchEngine = $('#search-engine-selection').val();
		const customSchoolSelection = $('#oppiaste-custom-selection');
		let customSchool = 'empty';
		const hideSearchVal = getHideSearchValue();
		const hideDriveVal = getHideDriveValue();
		const hideClassroomVal = getHideClassroomValue();
		toggleSearchStatus(hideSearchVal);
		toggleSearchEngine(searchEngine);

		form.addClass('form-loading');

		// Check for custom school value as this is not always in DOM
		if (customSchoolSelection.length) {
			// Get the value of the selected option
			customSchool = customSchoolSelection.val();
		}

		$.ajax({
			url: oppijaportaali_js.ajax_url,
			type: 'POST',
			data: ({
				action: 'update_user_settings',
				profilePicture: profilePictureVal,
				hideSearch: hideSearchVal,
				hideDrive: hideDriveVal,
				hideClassroom: hideClassroomVal,
				profilePictureVisibility: profilePictureVisibility,
				searchEngine: searchEngine,
				customSchool: customSchool,
				userId: oppijaportaali_js.user_id,
				nonce: oppijaportaali_js.nonce
			}),
			success: function (content) {
				notifications.show();
				form.removeClass('form-loading');
				notifications.text(content);
				setMainNavMultiavatar(profilePictureVal);

				setTimeout(() => {
					notifications.fadeOut();
					userSettingsModal.modal('hide')
				}, 3000)
			}
		});
	});
};

const settingsOpener = () => {
	const opener = $('.user-settings-modal-opener');

	opener.on('click', (e) => {
		e.preventDefault();
		const target = $(e.currentTarget);
		target.closest('.main-nav__items__item').find('.main-nav__user-settings-menu').toggleClass('main-nav__user-settings-menu--opened');
		target.attr('aria-expanded', (i, attr) => {
			return attr === 'true' ? 'false' : 'true'
		});
	});
};

const settingsCloser = () => {
	userSettingsModal.on('hide.bs.modal', function (e) {
		$('ul.main-nav__user-settings-menu').toggleClass('main-nav__user-settings-menu--opened')
	})
};

const setInitialDuckDuckTabindex = () => {
	if($('body').hasClass('has-search-hidden')) {
		duckDuckWrapper.attr('tabIndex', -1);
	} else {
		duckDuckWrapper.attr('tabIndex', 0);
	}
};

export const userSettings = () => {
	openUserSettingsModal();
	updateUserSettings();
	settingsOpener();
	settingsCloser();
	setInitialDuckDuckTabindex();
	setProfilePicVisibility();
}
