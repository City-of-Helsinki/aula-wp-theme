/* eslint-disable no-console, no-unused-vars, no-undef */

import { detectIncognito } from "detectincognitojs";

import {setCurrentTime} from "./lib/currentTime";
import {langDropdown} from "./lib/langDropdown";
import {addToServices, removeFromServices, servicesToggler, allServicesToggler, updateButtonClicks} from "./lib/services";
import {serviceFailureToggler} from "./lib/serviceFailure"
import {ownServices} from "./lib/ownServices"
import {avatar} from "./lib/avatar";
import {userSettings} from "./lib/userSettings";
import {infoWindowFunctions} from "./lib/infoWindow";
import {isMobileDevice} from "./lib/mobileChecker";
import {clickHandler} from "./lib/click";
import {timerFunctions} from "./lib/timer";
import {musicFunctions} from "./lib/music";
import {tabsFunctionality} from "./lib/tabs";
import {newGoogleDocumentOpener} from "./lib/new-document-opener";
import {concentrationFunctions} from "./lib/concentration";
import {filesModifiedDropdownFunctions} from "./lib/lastModifiedDropdown";

const removeSanuli = () => {
	const sanuliActionItem = $('.actions-wrapper__list-item--sanuli');
	const sanuliModal = $('#sanuli-modal');
	sanuliActionItem.remove();
	sanuliModal.remove();
};

export default {
	init() {
		// JavaScript to be fired on all pages

		detectIncognito().then((result) => {
			// Nice package to detect incognito :)
			// https://github.com/Joe12387/detectIncognito
			// see browser name and if result is private: result.browserName & result.isPrivate
			if(result.isPrivate) {
				removeSanuli();
			}
		});

		// Google files dropdown functions
		filesModifiedDropdownFunctions();

		// Concentration
		concentrationFunctions();

		// Tabs
		tabsFunctionality();

		// Google document opener
		newGoogleDocumentOpener();

		// Music functions
		musicFunctions();

		// Timer functions
		timerFunctions();

		// Click handler
		clickHandler();

		// Check for mobile device
		isMobileDevice();

		// Services toggler
		servicesToggler();

		// Info window stuff
		infoWindowFunctions();

		//Update time
		setCurrentTime();

		//Language dropdown
		langDropdown();

		// Adding to services
		addToServices();

		// Removing from services
		removeFromServices();

		//Toggler for all services
		allServicesToggler();

		// Service failure toggler
		serviceFailureToggler();

		// Own services related
		ownServices();

		// Update services open count
		updateButtonClicks();

		// Avatar thingies
		avatar();

		// User settings
		userSettings();

		function iOS() {
			return [
				'iPad Simulator',
				'iPhone Simulator',
				'iPod Simulator',
				'iPad',
				'iPhone',
				'iPod'
			].includes(navigator.platform)
			// iPad on iOS 13 detection
			|| (navigator.userAgent.includes("Mac") && "ontouchend" in document)
		}
		if(iOS() && !localStorage.getItem('oppijaportaali-ios-dialog')) {
			jQuery('.ios-homescreen-dialog').show();
			localStorage.setItem('oppijaportaali-ios-dialog', true);
		}
		if (localStorage.getItem('oppijaportaali-ios-dialog')) {
            jQuery('.ios-homescreen-dialog').on("click", () => {
                jQuery('.ios-homescreen-dialog').hide();
            });
        }

	},
	finalize() {
		// JavaScript to be fired on all pages, after page specific JS is fired
	},
};
