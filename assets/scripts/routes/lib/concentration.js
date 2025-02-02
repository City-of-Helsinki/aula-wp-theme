/* eslint-disable no-console, no-undef */

import {enableFullScreen, disableFullScreen} from "./fullscreen";

const music = document.getElementById("mindfullness-music");
const body = $('body');
const durationSelectionButton = $('.concentration-opener__list-item-button');
const concentration = $('.concentration');
const startConcentrationBtn = $('.start-concentration');
const concentrationLoading = $('.concentration__loading');
const concentrationTextWrapper = $('.concentration__text-wrapper');
const concentrationText = $('.concentration__text');
const stopConcentrationBtn = $('.stop-concentration');
const textCloseBtn = $('.concentration__text-close');
const muteBtn = $('.mute-concentration');

let timeoutId;

const muteAudio = () => {
	music.muted = true;
}

const unmuteAudio = () => {
	music.muted = false;
};

const audioFunctions = () => {
	muteBtn.on('click', (e) => {
		e.preventDefault();
		const target = $(e.currentTarget);
		target.toggleClass('concentration__action-button--active');

		if(music.muted === false) {
			muteAudio();
		} else {
			unmuteAudio();
		}
	});
};

const actionButtonToggler = () => {
	const button = $('.actions-wrapper__list-item--concentration');

	button.on('click', (e) => {
		e.preventDefault();
		body.toggleClass('concentration-settings-opened');
		concentration.toggleClass('concentration--open');
	});
};

const setMusicTrack = (url) => {
	$('#mindfullness-music > source').attr('src', url);
};

const clickDuration = () => {
	durationSelectionButton.on('click', (e) => {
		e.preventDefault();
		const target = $(e.currentTarget);
		startConcentrationBtn.attr('disabled', false);
		durationSelectionButton.each((i, e) => {
			const current = $(e);
			current.attr('aria-pressed', 'false');
			current.removeClass('concentration-opener__list-item-button--selected');
		});
		target.addClass('concentration-opener__list-item-button--selected');
		target.attr('aria-pressed', 'true');
		setMusicTrack(target.attr('data-track-url'));
	});
};

const startConcentration = () => {
	startConcentrationBtn.on('click', (e) => {
		e.preventDefault();
		enableFullScreen();
		const postId = $('.concentration-opener__list-item-button[aria-pressed="true"]').attr('data-post-id');
		concentrationLoading.show();
		body.toggleClass('concentration-settings-opened');
		setButtonsInitialStatus();

		$.ajax({
			url: oppijaportaali_js.ajax_url,
			type: 'POST',
			data: ({
				action: 'load_concentration',
				postId: postId
			}),
			success: function (response) {
				const data = JSON.parse(response);
				concentrationLoading.hide();
				concentrationTextWrapper.html(data.content);
				concentrationText.addClass('concentration__text--open');
				concentration.css('background-image', 'url(' + data.bg_url + ')');
				music.src = data.track_url;
				music.play();
				body.addClass('mindfullness-ongoing');

				timeoutId = setTimeout( () => {
					stopConcentration(true);
				}, data.duration * 60 * 1000);
			}
		});
	});
};

const stopConcentration = (useFade = false) => {
	setButtonsInitialStatus();
	music.src = "";

	if(useFade) {
		concentration.fadeOut(3000);

		// remove style attribute and concentration open after fadeout time
		setTimeout( () => {
			concentration.removeAttr('style');
			concentration.removeClass('concentration--open');
			concentrationTextWrapper.html('');
			concentrationText.removeClass('concentration__text--open');
		}, 3100); // time need to be a little bit more than fadeout

	} else {
		concentrationTextWrapper.html('');
		concentrationText.removeClass('concentration__text--open');
		concentration.css('background-image', 'none');
		concentration.removeClass('concentration--open');
	}

	body.removeClass('concentration-settings-opened mindfullness-ongoing');
	muteBtn.removeClass('concentration__action-button--active');
	unmuteAudio();
	disableFullScreen();
	clearTimeout(timeoutId);
};

const setButtonsInitialStatus = () => {
	startConcentrationBtn.attr('disabled', true);

	durationSelectionButton.each((i, e) => {
		const current = $(e);
		current.attr('aria-pressed', 'false');
		current.removeClass('concentration-opener__list-item-button--selected');
	});
};

const mainConcentrationCloser = () => {
	stopConcentrationBtn.on('click', (e) => {
		e.preventDefault();
		stopConcentration();
	});
};

const textWrapperCloser = () => {
	textCloseBtn.on('click', (e) => {
		e.preventDefault();
		concentrationText.removeClass('concentration__text--open');
	});
};

export const concentrationFunctions = () => {
	actionButtonToggler();
	clickDuration();
	startConcentration();
	mainConcentrationCloser();
	textWrapperCloser();
	audioFunctions();
};
