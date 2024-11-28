export const langDropdown = () => {
	const dropdownToggler = $('.lang-dropdown-toggle');
	const dropdown = $('.lang-dropdown-menu');

	dropdownToggler.on('click', (e) => {
		e.preventDefault();
		dropdown.toggleClass('lang-dropdown-menu--open');
	});
}
