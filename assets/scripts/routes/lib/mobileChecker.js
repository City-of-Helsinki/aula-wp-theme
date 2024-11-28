import { isMobile } from "./helpers"

export const isMobileDevice = () => {
	const body = $('body');

	if(!isMobile()) {
		body.addClass('desktop-device');
	}
};
