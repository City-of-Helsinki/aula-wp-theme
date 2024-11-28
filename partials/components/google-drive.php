<?php

if ( ! is_user_logged_in() ) {
	return;
}

get_template_part( 'partials/components/google-drive-new-document' );

if ( ! defined( 'GOOGLE_CLIENT_ID' ) || ! defined( 'GOOGLE_CLIENT_SECRET' ) || ! defined( 'GOOGLE_OAUTH_SCOPE' ) || ! defined( 'GOOGLE_REDIRECT_URI' ) ) {
	return;
}

get_template_part( 'partials/components/google-drive-retrieve-files' );

