<?php

	// include
	require '../_inc/config.php';

	// just to be safe
	if ( ! logged_in() ) {
		redirect('/');
	}


	$post_id = filter_input( INPUT_POST, 'post_id', FILTER_VALIDATE_INT );

	// does this even exist?
	if ( !$post_id || !$post = get_post($post_id, false) ) {
		flash()->error('no such post');
		redirect('back');
	}

	// is this the author?
	if ( !can_edit( $post ) ) {
		flash()->error('what are you trying?');
		redirect('back');
	}


	$query = $db->prepare("
		DELETE FROM posts
		WHERE id = :post_id
	");

	$delete = $query->execute([
		'post_id' => $post_id
	]);


	// messed up
	if ( ! $delete ) {
		flash()->warning( 'sorry' );
		redirect('back');
	}


	// remove all tags for this post too
	$query = $db->prepare("
		DELETE FROM posts_tags
		WHERE post_id = :post_id
	");

	$query->execute([
		'post_id' => $post_id
	]);


	// let's go home
	flash()->success( 'goodbye' );
	redirect('/');
