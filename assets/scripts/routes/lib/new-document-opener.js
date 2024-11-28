/* eslint-disable no-console, no-undef */

const opener = $('.google-drive-new-document-opener');

export const newGoogleDocumentOpener = () => {
	opener.on('click', (e) => {
		e.preventDefault();
		const target = $(e.currentTarget);
		const dropdown = target.next();

		target.attr('aria-expanded', (i, attr) => {
			return attr === 'true' ? 'false' : 'true'
		});

		dropdown.toggleClass('google-drive-new-document-options-list--opened');

	});
};
