/* eslint-disable no-console,no-undef */

const openerBtn = $('.info-window-opener__button');
const openerHideBtn = $('.info-window-opener__close');
const modalBody = $('.info-window-modal-body');
const closeBtn = $('.info-window-modal-body__close');
const readMoreBtn = $('.info-window-modal-body__readmore');

const buttonClassesToRemove = 'info-window-opener__button--red info-window-opener__button--orginal-yellow info-window-opener__button--yellow info-window-opener__button--green info-window-opener__button--blue info-window-opener__button--gray';
const infoWindowBodyClassesToRemove = 'info-window-modal-body--red info-window-modal-body--orginal-yellow info-window-modal-body--yellow info-window-modal-body--green info-window-modal-body--blue info-window-modal-body--gray';
const infoWindowCloseButtonClassesToRemove = 'info-window-modal-body__close--red info-window-modal-body__close--orginal-yellow info-window-modal-body__close--yellow info-window-modal-body__close--green info-window-modal-body__close--blue info-window-modal-body__close--grey';
const openerHideButtonClassesToRemove = 'info-window-opener__close--red info-window-opener__close--orginal-yellow info-window-opener__close--yellow info-window-opener__close--green info-window-opener__close--blue info-window-opener__close--gray';

const toggleStates = (selector) => {
	const currentModal = selector.closest('.single-info-window').find('.info-window-modal');
	const currentOpener = selector.closest('.single-info-window').find('.info-window-opener');
	selector.closest('.single-info-window').find('.info-window-opener').toggleClass('info-window-opener--hidden');
	currentModal.toggleClass('info-window-modal--show');

	currentModal.attr('aria-hidden', (i, attr) => {
		return attr === 'true' ? 'false' : 'true'
	});
	currentModal.attr('closed', (i, attr) => {
		return attr === 'no' ? 'yes' : 'no'
	});
	currentOpener.attr('closed', (i, attr) => {
		return attr === 'no' ? 'yes' : 'no'
	});
};

const updateTotalClicks = (selector) => {
	const PostId = selector.attr('data-post-id');
	$.ajax({
		url: oppijaportaali_js.ajax_url,
		type: 'POST',
		data: ({
			action: 'update_info_window_open_count',
			postId: PostId,
			metaKey: '_info_window_total_opens',
		}),
		success: function () {

		}
	});
};

const updateButtonClicks = (selector) => {
	const PostId = selector.attr('data-post-id');
	$.ajax({
		url: oppijaportaali_js.ajax_url,
		type: 'POST',
		data: ({
			action: 'update_info_window_open_count',
			postId: PostId,
			metaKey: '_info_window_button_click',
		}),
		success: function () {

		}
	});
};

const updateClosedInfoWindowsByUser = (selector) => {
	const postId = selector.attr('data-post-id');
	const userId = selector.attr('data-user-id');

	// Do nothing if not logged in
	if( userId === 0 ) {
		return;
	}

	$.ajax({
		url: oppijaportaali_js.ajax_url,
		type: 'POST',
		data: ({
			action: 'update_closed_info_windows_by_user',
			postId: postId,
			userId: userId,
			nonce: oppijaportaali_js.nonce
		}),
		success: () => {

		}
	});
};

const updateHidedInfoWindowsByUser = (selector) => {
	const postId = selector.attr('data-post-id');
	const userId = selector.attr('data-user-id');

	// Do nothing if not logged in
	if( userId === 0 ) {
		return;
	}

	$.ajax({
		url: oppijaportaali_js.ajax_url,
		type: 'POST',
		data: ({
			action: 'update_hided_info_windows_by_user',
			postId: postId,
			userId: userId,
			nonce: oppijaportaali_js.nonce
		}),
		success: () => {

		}
	});
};

const setInfoWindowAsDisabledGrey = (selector) => {
	modalBody.removeClass(infoWindowBodyClassesToRemove);
	openerBtn.removeClass(buttonClassesToRemove);
	closeBtn.removeClass(infoWindowCloseButtonClassesToRemove);
	openerHideBtn.removeClass(openerHideButtonClassesToRemove);
	selector.closest('.single-info-window').find('.info-window-opener__button').addClass('info-window-opener__button--disabled-grey');
	selector.closest('.single-info-window').find('.info-window-opener__close').addClass('info-window-opener__close--disabled-grey');
	setTimeout(() => {
		selector.closest('.single-info-window').find('.info-window-modal-body').addClass('info-window-modal-body--disabled-grey');
		selector.closest('.single-info-window').find('.info-window-modal-body__close').addClass('info-window-modal-body__close--disabled-grey');
	}, 400);
};

const setInfoWindowAsHidden = (selector) => {
	selector.closest('.single-info-window').find('.info-window-opener__button').addClass('info-window-opener__button--hidden');
	selector.closest('.single-info-window').find('.info-window-opener__close').addClass('info-window-opener__close--hidden');
};



export const infoWindowFunctions = () => {

	openerBtn.on('click', (e) => {
		e.preventDefault();
		const element = $(e.currentTarget);
		toggleStates(element);
		updateTotalClicks(element);

		element.closest('.single-info-window').find('.info-window-modal[closed="no"]').fadeIn( 300 );
	});

	readMoreBtn.on('click', (e) => {
		const element = $(e.currentTarget);
		updateButtonClicks(element);
	});

	closeBtn.on('click', (e) => {
		e.preventDefault();
		const element = $(e.currentTarget);
		toggleStates(element);
		updateClosedInfoWindowsByUser(element);
		setInfoWindowAsDisabledGrey(element);

		element.closest('.single-info-window').find('.info-window-modal[closed="yes"]').fadeOut( 800 );
	});

	openerHideBtn.on('click', (e) => {
		e.preventDefault();
		const element = $(e.currentTarget);
		setInfoWindowAsHidden(element);
		updateHidedInfoWindowsByUser(element);
	});
}
