/* eslint-disable no-console, no-undef */

const music = document.getElementById("concentration-music");
const toggleControls = $('.toggle-music-controls');
const startButton = $('a[data-button-type="start-music"]');
const pauseButton = $('a[data-button-type="pause-music"]');
const forwardButton = $('a[data-button-type="forward-music"]');
const previousButton = $('a[data-button-type="previous-music"]');
const body = $('body');
const setList = oppijaportaali_js.music_tracks;
let i = 0;

const nextTrack = () => {
	// Check for last audio file in the playlist
	if (i === setList.length - 1) {
		i = 0;
	} else {
		i++;
	}

	// Change the audio element source
	music.src = setList[i];
	music.play();
}

const prevTrack = () => {
	// Check for last audio file in the playlist
	if (i === 0) {
		i = setList.length - 1;
	} else {
		i--;
	}

	// Change the audio element source
	music.src = setList[i];
	music.play();
}

export const musicFunctions = () => {

	music.src = setList[i];

	// Listen for the music ended event, to play the next audio file
	music.addEventListener('ended', nextTrack, false)

	toggleControls.on('click', (e) => {
		e.preventDefault();
		const target = $(e.currentTarget);

		target.attr('aria-expanded', (i, attr) => {
			return attr === 'true' ? 'false' : 'true'
		});

		body.toggleClass('has-music-controls-opened');

		if(body.hasClass('has-music-controls-opened')) {
			startButton.attr('tabIndex', '');
			pauseButton.attr('tabIndex', '');
		} else {
			startButton.attr('tabIndex', -1);
			pauseButton.attr('tabIndex', -1);
		}
	});

	startButton.on('click', (e) => {
		e.preventDefault();
		body.addClass('has-music-playing');
		music.play();
	});

	pauseButton.on('click', (e) => {
		e.preventDefault();
		body.removeClass('has-music-playing');
		music.pause();
	});

	forwardButton.on('click', (e) => {
		e.preventDefault();
		nextTrack();
	});

	previousButton.on('click', (e) => {
		e.preventDefault();
		prevTrack();
	});
};
