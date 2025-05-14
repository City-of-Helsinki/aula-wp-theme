<?php

// Helper file to be used to assign apunappi chat scripts for certain schools

namespace ApunappiSchools;

/**
 * Checks if ammattikoulu or lukio matches the apunappi schools
 *
 * @param $school_id
 *
 * @return bool
 */
function is_apunappi_school( $school_id ) {
	$apunappi_schools = get_apunappi_schools_array();

	return in_array( $school_id, $apunappi_schools );
}


/**
 * Checks if user has certain depertment in meta user_department
 *
 * @return bool
 */
function user_has_apunappi_department() {
	if ( ! is_user_logged_in() ) {
		return false;
	}
	$current_user_id = get_current_user_id();
	$user_department = get_user_meta( $current_user_id, 'user_department', true );

	if ( empty( $user_department ) ) {
		return false;
	}

	// User department might have multiple values separated by ; ==> lets have array
	$school_ids = explode( ';', $user_department );

	foreach ( $school_ids as $school_id ) {
		if ( in_array( $school_id, get_apunappi_schools_array() ) ) {
			return true;
		}
	}

	return false;


}

function get_apunappi_schools_array() {
	return [
		// Toinen aste schools
		'K4W', // Abraham Wetterin tien toimipaikka
		'K5H', // Hattulantien toimipaikka
		'K2I', // Ilkantien toimipaikka
		'K3K', // Kullervonkadun toimipaikka
		'K2M', // Meritalon toimipaikka
		'K3M', // Muotoilijankadun toimipaikka
		'K4M', // Myllypuron toimipaikka
		'K3P', // Prinsessantien toimipaikka
		'K2S', // Savonkadun toimipaikka
		'K5S', // Sturenkadun toimipaikka
		'K1T', // Teollisuuskadun toimipaikka
		'K2V', // Valuraudankujan toimipaikka
		'K4V', // Vilppulantien toimipaikka
		'K4X', // Vuokkiniemenkadun toimipaikka

		// Lukio schools
		'AlppL',  // Alppilan lukio
		'EtuTL',  // Etu-Töölön lukio
		'KallL',  // Kallion lukio
		'KoneL',  // Konepajan lukio
		'KielL',  // Helsingin kielilukio
		'KuvTL',  // Helsingin kuvataidelukio
		'LuonL',  // Helsingin luonnontiedelukio
		'MediL',  // Helsingin medialukio
		'MäkeL',  // Mäkelänrinteen lukio
		'RessL',  // Ressun lukio
		'SibeL',  // Sibeliuslukio
		'VuosL',   // Vuosaaren lukio

		// peruskoulu schools
		'JätkPK',      // Jätkäsaaren peruskoulu
		'KruuY',       // Kruununhaan yläasteen koulu
		'RessPK',      // Ressun peruskoulu
		'TaivPK',      // Taivallahden peruskoulu
		'HaagPK',      // Haagan peruskoulu
		'KannPK',      // Kannelmäen peruskoulu
		'MeilY',       // Meilahden yläasteen koulu
		'PakiY',       // Pakilan yläasteen koulu
		'PihkA',       // Pihkapuiston Ala-aste.
		'PitäPK',      // Pitäjänmäen peruskoulu
		'SolaK',       // Solakallion koulu
		'ToivK',       // Toivolan koulu
		'TorpPK',      // Torpparinmäen peruskoulu
		'AKivPK',      // Aleksis Kiven peruskoulu
		'AraPK',       // Arabian peruskoulu
		'KalaPK',      // Kalasataman peruskoulu
		'KäpyPK',      // Käpylän peruskoulu
		'PasiPK',      // Pasilan peruskoulu
		'YhtKAY',      // Yhtenäiskoulu
		'HiidPK',      // Hiidenkiven peruskoulu
		'KankPK',      // Kankarepuiston peruskoulu
		'KarvK',       // Karviaistien koulu
		'LatoPK',      // Latokartanon peruskoulu
		'MaatPK',      // Maatullin peruskoulu
		'MalmPK',      // Malmin peruskoulu
		'PuisPK',      // Puistolan peruskoulu
		'PukmPK',      // Pukinmäenkaaren peruskoulu
		'SuutPK',      // Suutarinkylän peruskoulu
		'KruuPK',      // Kruunuvuorenrannan peruskoulu
		'LaajPK',      // Laajasalon peruskoulu
		'OutaK',       // Outamon koulu
		'PoroPK',      // Porolahden peruskoulu
		'AurPK',       // Aurinkolahden peruskoulu
		'ItäkPK',      // Itäkeskuksen peruskoulu
		'MeriPK',      // Merilahden peruskoulu
		'MylpPK',      // Myllypuron peruskoulu
		'NaulK',       // Naulakallion koulu
		'PuipPK',      // Puistopolun peruskoulu
		'SakaK',       // Sakarinmäen peruskoulu
		'VartY',       // Vartiokylän yläasteen koulu
		'VesaPK',      // Vesalan peruskoulu
		'VuonPK',      // Vuoniityn peruskoulu
	];
}
