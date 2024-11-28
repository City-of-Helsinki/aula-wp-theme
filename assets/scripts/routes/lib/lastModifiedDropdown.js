/* eslint-disable no-console, no-undef */

const openerBtn = $('.table-sorter-btn');
const dropdownLink = $('.sortable-options__link');
const dropdown = $('.sortable-options');
const loadingOverlay = $('.drive-loading-overlay');

const buttonOpener = () => {
	openerBtn.on('click', (e) => {
		e.preventDefault();
		openerBtn.attr('aria-expanded', (i, attr) => {
			return attr === 'true' ? 'false' : 'true'
		});

		dropdown.attr('aria-hidden', (i, attr) => {
			return attr === 'true' ? 'false' : 'true'
		});
	});
};

const dropdownLinkClick = () => {
	dropdownLink.on('click', (e) => {
		e.preventDefault();
		loadingOverlay.addClass('drive-loading-overlay--shown');
		const target = $(e.currentTarget);
		const orderBy = target.attr('data-orderby');

		dropdownLink.each((i, e) => {
			const current = $(e);
			current.removeClass('sortable-options__link--active');
			current.attr('aria-pressed', 'false');
		});

		target.addClass('sortable-options__link--active');
		target.attr('aria-pressed', 'true');

		$.ajax({
			url: oppijaportaali_js.ajax_url,
			type: 'POST',
			data: ({
				action: 'update_drive_table_body',
				orderby: orderBy
			}),
			success: function (content) {
				$('.google-drive-table tbody').html(content);
				loadingOverlay.removeClass('drive-loading-overlay--shown');
			}
		});

	});
};

export const filesModifiedDropdownFunctions = () => {
	buttonOpener();
	dropdownLinkClick();
};
