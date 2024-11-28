/* eslint-disable no-console, no-undef */

const tabButton = $('.action-tabs-nav__link');
const tabContent = $('.action-tabs__single-tab');

const setActiveButton = (buttonElement) => {
	tabButton.each((i, e) => {
		const current = $(e);
		current.attr('aria-selected', 'false');
		current.removeClass('action-tabs-nav__link--active');
	});

	buttonElement.addClass('action-tabs-nav__link--active');
	buttonElement.attr('aria-selected', 'false');
};

const setActiveTab = (buttonElement) => {
	tabContent.each((i, e) => {
		const current = $(e);
		current.hide();
	});

	const tab = $('#' + buttonElement.attr('aria-controls'));

	tab.fadeIn();
};

export const tabsFunctionality = () => {
	tabButton.on('click', (e) => {
		const target = $(e.currentTarget);

		// Set active button
		setActiveButton(target);

		// Set active tab panel
		setActiveTab(target);
	});
};
