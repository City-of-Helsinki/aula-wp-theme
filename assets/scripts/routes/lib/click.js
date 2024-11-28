/* eslint-disable no-console, no-undef */

import { closeAllServiceDropdowns, closeUserMenu } from "./helpers"

export const clickHandler = () => {
	$('body').on( 'click', (e) => {
		if (e.target.tagName.toLowerCase() === 'div' || e.target.tagName.toLowerCase() === 'main' || e.target.tagName.toLowerCase() === 'input') {
			closeAllServiceDropdowns();
			closeUserMenu();
		}

	});
};
