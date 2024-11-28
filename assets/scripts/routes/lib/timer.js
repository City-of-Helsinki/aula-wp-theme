/* eslint-disable no-console, no-undef */

const modal = $('#timer-modal');
const music = document.getElementById("timer-is-up-music");
const body = $('body');
const timerLeftSelector = $('.timer-left-text');
const minutesInput = $('#timer-minutes-input');
const startTimerButton = $('.timer-settings-form__btn--start');
const continueTimerButton = $('.timer-settings-form__btn--continue');
const pauseTimerButton = $('.timer-settings-form__btn--pause');
const stopTimerButton = $('.timer-settings-form__btn--stop');
const minutesButton = $('.add-new-service-form__btn--timer-minutes');
//const form = $("#timer-form");
const repeatTimerButton = $('.actions-wrapper-time-left__repeat');
const closeTimerButton = $('.actions-wrapper-time-left__close');
const pauseCircleTimerButton = $('.actions-wrapper-time-left__pause');
const resumeCircleTimerButton = $('.actions-wrapper-time-left__resume');
const circle = document.getElementById('timer-circle');
let length;

let siteTitle = $(document).prop('title');
let timerOngoing = false;
let timeInSeconds = 60 * 25;
let originalTimeInSeconds = 60 * 25;
let timeoutId;
let count = 0;

const setMinutesButtonsDisabled = (status = true) => {
	minutesButton.each((i, e) => {
		const current = $(e);
		current.attr('disabled', status);
	});
};

const updateTimeLeft = () => {
	minutesInput.change( () => {
		setTimerMinutes();
		timerLeftSelector.html(setReadableTimeFormat(timeInSeconds));
	});
};

const setReadableTimeFormat = (timeInSeconds) => {
	let minutes = parseInt(timeInSeconds / 60, 10);
	let seconds = parseInt(timeInSeconds % 60, 10);

	minutes = minutes < 10 ? "0" + minutes : minutes;
	seconds = seconds < 10 ? "0" + seconds : seconds;

	return minutes + ":" + seconds;
};

const updateTimer = () => {
	if(timeInSeconds > 0) {
		timeoutId = setTimeout(updateTimer, 1000);
	} else {
		music.play();
		setInitialStatus();
		body.addClass('has-timer-finished');
		circle.style.strokeDashoffset = 0;
		setTimeout( () => {
			alert(oppijaportaali_js.time_is_up);
		}, 2000);
	}

	if(timerOngoing) {
		let timeLeft = setReadableTimeFormat(timeInSeconds);

		circle.style.strokeDashoffset = (count / originalTimeInSeconds) * length;

		timeInSeconds--;
		count++;

		$(document).prop('title', siteTitle + ' - ' + timeLeft);
		timerLeftSelector.html(timeLeft);
	}
};

const setTimerMinutes = () => {
	const howManyMinutes = minutesInput.val();
	timeInSeconds = 60 * howManyMinutes;
	originalTimeInSeconds = 60 * howManyMinutes;
};

const setMinutesDisabled = (status = true) => {
	minutesInput.attr('disabled', status);
};

const setInitialStatus = () => {
	setTimerMinutes();
	timerOngoing = false;
	setMinutesDisabled(false);
	setMinutesButtonsDisabled(false);
	startTimerButton.attr('disabled', false);
	continueTimerButton.attr('disabled', true);
	pauseTimerButton.attr('disabled', true);
	body.removeClass('has-timer-ongoing has-timer-finished has-timer-paused');
	timerLeftSelector.html(setReadableTimeFormat(timeInSeconds));
	$(document).prop('title', siteTitle);
	count=0;
};

const closeModal = () => {
	modal.modal('hide');
};

export const timerFunctions = () => {

	updateTimeLeft();

	startTimerButton.on('click', (e) => {
		e.preventDefault();
		setTimerMinutes();
		setMinutesDisabled();
		setMinutesButtonsDisabled();
		body.addClass('has-timer-ongoing');
		startTimerButton.attr('disabled', true);
		pauseTimerButton.attr('disabled', false);
		timerOngoing = true;
		length = circle.getTotalLength();
		circle.style.strokeDasharray = length;
		circle.style.strokeDashoffset = 0;
		closeModal();
		updateTimer();
	});

	pauseTimerButton.on('click', (e) => {
		e.preventDefault();
		pauseTimerButton.attr('disabled', true);
		continueTimerButton.attr('disabled', false);
		body.addClass('has-timer-paused');
		timerOngoing = false;
	});

	pauseCircleTimerButton.on('click', (e) => {
		e.preventDefault();
		pauseTimerButton.attr('disabled', true);
		continueTimerButton.attr('disabled', false);
		body.addClass('has-timer-paused');
		timerOngoing = false;
	});

	continueTimerButton.on('click', (e) => {
		e.preventDefault();
		pauseTimerButton.attr('disabled', false);
		continueTimerButton.attr('disabled', true);
		body.removeClass('has-timer-paused');
		timerOngoing = true;
	});

	resumeCircleTimerButton.on('click', (e) => {
		e.preventDefault();
		pauseTimerButton.attr('disabled', false);
		continueTimerButton.attr('disabled', true);
		body.removeClass('has-timer-paused');
		timerOngoing = true;
	});

	stopTimerButton.on('click', (e) => {
		e.preventDefault();
		clearTimeout(timeoutId);
		setInitialStatus();
	});

	closeTimerButton.on('click', (e) => {
		e.preventDefault();
		clearTimeout(timeoutId);
		setInitialStatus();
	});

	repeatTimerButton.on('click', (e) => {
		e.preventDefault();

		if(body.hasClass('has-timer-ongoing')) {
			return;
		}

		clearTimeout(timeoutId);
		setTimerMinutes();
		setMinutesDisabled();
		setMinutesButtonsDisabled();
		body.addClass('has-timer-ongoing');
		body.removeClass('has-timer-finished');
		startTimerButton.attr('disabled', true);
		pauseTimerButton.attr('disabled', false);
		timerOngoing = true;
		length = circle.getTotalLength();
		circle.style.strokeDasharray = length;
		circle.style.strokeDashoffset = 0;
		updateTimer();
	});

	minutesButton.on('click', (e) => {
		e.preventDefault();
		const target = $(e.currentTarget);
		const minutes = target.attr('data-timer-minutes');
		minutesInput.val(minutes);
		setTimerMinutes();
		timerLeftSelector.html(setReadableTimeFormat(timeInSeconds));
	});
};
