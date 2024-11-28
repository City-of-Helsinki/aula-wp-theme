export const serviceFailureToggler = () => {
	$('#toggle-service-failure').on('click', () => {
		$('.service-failure-read-more-content').slideToggle();
	});
}
