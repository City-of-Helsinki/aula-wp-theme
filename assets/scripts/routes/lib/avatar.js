/* eslint-disable no-console, no-undef */
import multiavatar from '@multiavatar/multiavatar/dist/esm'

const mainNavMultiavatar = $('#main-nav-multiavatar');
const preview = $('#user-settings-multiavatar-preview');

const defaultAvatar = `<svg width="126px" height="126px" viewBox="0 0 126 126" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <g id="Updates-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g id="Group">
            <rect id="Rectangle" fill-opacity="0.695749563" fill="#000000" x="0" y="0" width="126" height="126"></rect>
            <g id="Bitmap-Copy" transform="translate(26.000000, 30.000000)" fill="#838383">
                <path d="M38.0882353,37.0909091 C48.3094853,37.0909091 56.5882353,28.7918182 56.5882353,18.5454545 C56.5882353,8.29909091 48.3094853,0 38.0882353,0 C27.8669853,0 19.5882353,8.29909091 19.5882353,18.5454545 C19.5882353,28.7918182 27.8669853,37.0909091 38.0882353,37.0909091 L38.0882353,37.0909091 Z M0,60.0798226 L0,96 L74,96 L74,60.0798226 C74,47.6940133 49.34875,41.4545455 37,41.4545455 C24.65125,41.4545455 0,47.6940133 0,60.0798226 Z" id="Icon"></path>
            </g>
        </g>
    </g>
</svg>`

const setMultiavatar = () => {
	if(oppijaportaali_js.multiavatar) {
		const svgCode = multiavatar(oppijaportaali_js.multiavatar);
		preview.html(svgCode);
		mainNavMultiavatar.html(svgCode);
	} else {
		mainNavMultiavatar.html(defaultAvatar);
	}
};

const previewAvatar = () => {
	const userSettingsInput = $('#profile-image-input');
	userSettingsInput.on('input', () => {
		const value = userSettingsInput.val();
		const svgCode = multiavatar(value);

		if(value) {
			preview.html(svgCode);
		} else {
			preview.html(defaultAvatar);
		}
	});
};

export const setMainNavMultiavatar = (string) => {
	const svgCode = multiavatar(string);
	mainNavMultiavatar.html(svgCode);
};

export const avatar = () => {
	previewAvatar();
	setMultiavatar();
};
