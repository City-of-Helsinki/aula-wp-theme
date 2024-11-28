export const setCurrentTime = () => {
	let currentTime = () => {
		const now = new Date();
		let hours = now.getHours();
		let minutes = now.getMinutes();

		if (minutes < 10) {
			minutes = '0' + minutes;
		}

		if (hours < 10) {
			hours = '0' + hours;
		}

		const clock = hours + ':' + minutes;
		$('#the-time').html(clock);
		$('#the-mobile-time').html(clock);
	};
	setInterval(currentTime, 1000);
}
