<?php

	require_once '_inc/config.php';

	// not logged in
	if ( ! logged_in() ) {
		redirect('/');
	}

	// log yourself out
	do_logout();

	// flash it & go home
	flash()->success('Bye bye!');
	redirect('/');
